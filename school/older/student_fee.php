<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
require_once "util.inc";
require_once "school.inc";

$con = connect();

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
 || user_type($_SESSION['uid'], 'Accounts', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
if (isset($_REQUEST['command']) && ($_REQUEST['command'] == "Print")) {
  print_header('Student Receipt', 'student_fee.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate')) {
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a class", 'student_fee.php', 'Back');
    exit;
  }
  //Make sure there is data for the class
  if ($_REQUEST['student_id'] == '0') {
    $sql="select * from student_fee where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_REQUEST['term_id']}
     and class_id = {$_REQUEST['class_id']}";
    $student_name = "";
  } else {
    //Make sure there is data for the student
    $sql="select * from student_fee where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_REQUEST['term_id']}
     and class_id = {$_REQUEST['class_id']}
     and student_id = {$_REQUEST['student_id']}";
	 
   $student_name = "Student: " . get_value('student', 'admission_number', 'id', 
     $_REQUEST['student_id'], $con);
    $student_name .= " " . get_value('student', 'firstname', 'id', 
      $_REQUEST['student_id'], $con);
    $student_name .= " " . get_value('student', 'lastname', 'id', 
      $_REQUEST['student_id'], $con);
  }
  $result = mysql_query($sql) or die(mysql_error() . "Ehen");
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("There is no data for " . 
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
     " Session, " . get_value('term','name','id',$_REQUEST['term_id'], $con).
     " Term, Class ".get_value('class','name','id',$_REQUEST['class_id'],$con).
     " $student_name", 'student_fee.php', 'Back');
     exit;
   }  
  //Lets get the school info
   $sql="select * from school_info";
   $result2 = mysql_query($sql) or die(mysql_error());
   if (mysql_num_rows($result2) > 0) {
     $row2 = mysql_fetch_array($result2);
	 $name = $row2['name'];
	 $address = $row2['address'];
	 $phone = $row2['phone'];
	 $email = $row2['email'];
	 $web = $row2['web'];
	 $logo = $row2['logo'];
   } else {
     $name = "";
	 $address = "";
	 $phone = "";
	 $email = "";
	 $web = "";
	 $logo = "";
	 
   }
   //Generate a single student's receipt or all the students 
   //in a class
   if ($_REQUEST['student_id'] == '0') {
    $sql="select * from student where current_class_id={$_REQUEST['class_id']}";
   } else {
     $sql="select * from student where id={$_REQUEST['student_id']}";
   }
   echo " 
      <table>
       <tr>
        <!--<td colspan='2'><h3>Receipt</h3></td>-->";
   if (!isset($_REQUEST['command'])) {
      echo "
	 <td>		  
	  <a style='cursor:hand;'; onclick='window.open(\"student_fee.php?action=Generate&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}&student_id={$_REQUEST['student_id']}&command=Print\", \"smallwin\", 
		   \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
	   <img src='images/icon_printer.gif'></a>
        </td>
       </tr>";
   }
   $result = mysql_query($sql) or die('Cannot execute sql* ' . mysql_error());
   while($row = mysql_fetch_array($result)) { 
     echo "
       <tr>
        <td colspan='3'>
         <table border='0'>
          <tr>
	   <!--
           <td>
            <table>
             <tr>
              <td>
               <img src='upload/{$logo}' alt='School Logo'
                width='80' height='80'>
              </td>
             </tr>
            </table>
           </td>
	   -->
           <td colspan='3'>
            <table style='text-align:center; font-weight:bold;'>
             <tr style='font-size:2em;'><td>$name</td></tr>
             <tr><td>$address</td></tr>
             <tr><td>$phone</td></tr>
             <tr><td>$email $web</td></tr>
            </table>
           </td>
          </tr>
         </table>
        </td>
       </tr> 
       <tr style='text-align:center; font-weight:bold; font-size:2em;'>
        <td>STUDENT RECEIPT</td></tr> 
       <tr>
        <td colspan='3'>
         <table>
          <tr>
           <td><b>Name(Surname First):</b> 
            {$row['firstname']} {$row['lastname']}
           </td>
          </tr>
          <tr>
           <td><b>Admission Number:</b> {$row['admission_number']}</td>
           <td><b>Term:</b> " . 
            get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
           <td><b>Session:</b> ".
            get_value('session','name','id',$_SESSION['session_id'],$con)."</td 
          </tr> 
          <tr>
           <td><b>Class:</b> " .  
            get_value('class', 'name', 'id', $_REQUEST['class_id'], $con)."</td>
          </tr> 
         </table>
        </td>
       </tr> 
       <tr>
        <td colspan='3' width='80%'>
         <table border='1' style='table-layout:fixed; text-align:center;'>
          <tr>
           <td><b>Date</b></td>
           <td><b>Teller Number</b></td>
           <td colspan='2'>
            <table border='1' style='table-layout:fixed;'>
             <tr>
              <td><b>Fee</b></td>
              <td><b>Amount</b></td>
             </tr>
            </table>
           </td>
          </tr>";
     //Fetch school fees for student in that class/term/session
     $sql1="select * from student_fee where
      session_id={$_SESSION['session_id']} and term_id={$_REQUEST['term_id']}
      and class_id={$_REQUEST['class_id']}
     ";
     if ($_REQUEST['student_id'] == 0) {
       $sql1 .= " and student_id = {$row['id']} ";
     } else {
      $sql1 .=" and student_id = {$_REQUEST['student_id']} ";
     }
     $sql1 .= " order by date_of_payment";
     $result1 = mysql_query($sql1) or die(mysql_error());
     $total_paid = 0;
     while($row1 = mysql_fetch_array($result1)) {
       echo "
	  <tr>
           <td>{$row1['date_of_payment']}</td>
           <td>{$row1['teller_number']}</td>
           <td colspan='2'>
       ";
       $total_paid += $row1['amount'];

       $sql3 = "select f.name, fc.amount from fee_class fc join fee f 
        on f.id = fc.fee_id where fc.class_id={$_REQUEST['class_id']}";
       $result3 = mysql_query($sql3) or die(mysql_error());
       echo "
	    <table border='1' style='table-layout:fixed;'>";
       $total_fees = 0;
       while ($row3 = mysql_fetch_array($result3)) { 
         $total_fees += $row3['amount'];
         echo "
	     <tr>
	      <td>{$row3['name']}</td>
              <td>{$row3['amount']}</td></td>
	     </tr>";
       } 
       echo "  <tr>
               <td><b>Total School Fees</b></td>
               <td><b>$total_fees</b></td>
              </tr>";
       echo "  <tr><td><b>Total Paid</b></td><td><b>$total_paid</b></td></tr>";
       $balance = $total_fees - $total_paid;
       if ($balance > 0) {
        echo "<tr>
	      <td><b style='color:red;'>Owing</b></td>
              <td><b style='color:red;'>$balance</b></td>
	     </tr>";
       }
       echo "
	    </table>
	   </td>
	  </tr>";
     }
       echo "
	    </table>
	   </td>
	  </tr>";
   }
   echo "</table>";
   exit;
}
 ?> 
<table> 
 <tr class="class1">
  <td colspan='3'><h3>Generate Student Financial Record</h3></td>
 </tr>
 <form name='form1' action="student_fee.php" method="post">
 <tr>
  <td>Term</td>
  <td>
   <select name='term_id'>
   <?php 
    $sql ="select * from term where session_id={$_SESSION['session_id']}";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) { 
      echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>Class</td>
  <td>
   <select name="class_id" onchange='get_students_with_all();'>
    <option value='0'></option>
    <?php
    $sql="select * from class";
    $result = mysql_query($sql);
    while($row1 = mysql_fetch_array($result)) {
      echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
    }
    ?>
   </select>
  </td>
 </tr>
 <tr><td>Student</td><td><div id="students"></div></td></tr>
 <tr>
  <td>
   <input name='action' type='submit' value='Generate'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
