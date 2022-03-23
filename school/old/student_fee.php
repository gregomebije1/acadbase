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

if (isset($_REQUEST['command']) && ($_REQUEST['command'] == "Print")) {
  print_header('Student Receipt', 'student_fee.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate')) {
  
  $sql="select * from student where id={$_REQUEST['student_id']} and school_id={$_SESSION['school_id']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  $adm_nr = $row['admission_number'];
  $student_name = $adm_nr . "{$row['firstname']} {$row['lastname']}";
  //Make sure there is data for the class
  if ($_REQUEST['student_id'] == '0') {
    $sql="select * from student_fees where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_SESSION['term_id']}
     and class_id = {$_SESSION['class_id']}";
    $student_name = "";
  } else {
    //Make sure there is data for the student
    $sql="select * from student_fees where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_SESSION['term_id']}
     and class_id = {$_SESSION['class_id']}
     and admission_number = {$adm_nr}";
  }
    $result = mysqli_query($con, $sql) or die(mysqli_error($con) . "Ehen");
    if (mysqli_num_rows($result) <= 0) {
      echo msg_box("There is no data for " . 
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
       " Session, " . get_value('term','name','id',$_SESSION['term_id'], $con).
       " Term, Class ".get_value('class','name','id',$_SESSION['class_id'],$con).
       " $student_name", 'student_fee.php', 'Back');
      exit;
    }  
  //Lets get the school info
   $sql="select * from school";
   $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
   if (mysqli_num_rows($result2) > 0) {
     $row2 = mysqli_fetch_array($result2);
	 $name = $row2['name'];
	 $address = $row2['address'];
	 $phone = $row2['phone'];
	 $email = $row2['email'];
	 $website = $row2['website'];
	 $logo = $row2['logo'];
   } else {
     $name = "";
	 $address = "";
	 $phone = "";
	 $email = "";
	 $website = "";
	 $logo = "";
	 
   }
   //Generate a single student's receipt or all the students 
   //in a class
   if ($_REQUEST['student_id'] == '0') {
    $sql="select * from student where class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";
   } else {
     $sql="select * from student where id={$_REQUEST['student_id']} and school_id={$_SESSION['school_id']}";
   }
   echo " 
      <table>
       <tr>
        <!--<td colspan='2'><h3>Receipt</h3></td>-->";
		
   if (!isset($_REQUEST['command'])) {
      echo "
	 <td>		  
	  <a style='cursor:hand;'; onclick='window.open(\"student_fee.php?action=Generate&student_id={$_REQUEST['student_id']}&command=Print\", \"smallwin\", 
		   \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
	   <img src='images/icon_printer.gif'></a>
        </td>
       </tr>";
   }
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while($row = mysqli_fetch_array($result)) { 
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
             <tr><td>$email $website</td></tr>
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
            get_value('term', 'name', 'id', $_SESSION['term_id'], $con) . "</td>
           <td><b>Session:</b> ".
            get_value('session','name','id',$_SESSION['session_id'],$con)."</td 
          </tr> 
          <tr>
           <td><b>Class:</b> " .  
            get_value('class', 'name', 'id', $_SESSION['class_id'], $con)."</td>
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
     $sql1="select * from student_fees where
      session_id={$_SESSION['session_id']} and term_id={$_SESSION['term_id']}
      and class_id={$_SESSION['class_id']}
     ";
     if ($_REQUEST['student_id'] == 0) {
       $sql1 .= " and admission_number={$row['admission_number']} ";
     } else {
      $sql1 .=" and admission_number={$adm_nr} ";
     }
     $sql1 .= " order by date";
     $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
     $total_paid = 0;
     while($row1 = mysqli_fetch_array($result1)) {
       echo "
	  <tr>
           <td>{$row1['date']}</td>
           <td><!--Teller--></td>
           <td colspan='2'>
       ";
       $total_paid += $row1['amount_paid'];

       $sql3 = "select f.name, fc.amount from fee_class fc join fee f 
        on f.id = fc.fee_id where fc.class_id={$_SESSION['class_id']}";
       $result3 = mysql_query($sql3) or die(mysqli_error($con));
       echo "
	    <table border='1' style='table-layout:fixed;'>";
       $total_fees = 0;
       while ($row3 = mysqli_fetch_array($result3)) { 
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
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)) { 
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
    $result = mysqli_query($con, $sql);
    while($row1 = mysqli_fetch_array($result)) {
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
