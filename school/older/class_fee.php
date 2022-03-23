<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
require_once "util.inc";

$con = connect();
if (!(user_type($_SESSION['uid'], 'Administrator', $con)
 || user_type($_SESSION['uid'], 'Accounts', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "Print")) {
  print_header('School Fees Report', 'class_fee.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && 
 (($_REQUEST['action'] == 'Generate') || ($_REQUEST['action'] == 'Print'))) {
  if ($_REQUEST['class_id'] == 'all_classes') {
    $sql="select * from student_fee where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_REQUEST['term_id']}";
     $class_name = $_REQUEST['class_id'];
  } else if ($_REQUEST['class_id'] == 'all_jss_classes') {
    $sql="SELECT c.type, c.name, s.admission_number, s.firstname, 
     s.lastname, s.current_class_id, s.scholarship FROM student_fee sf
     JOIN (class c, student s) ON ( s.current_class_id = c.id
     AND sf.student_id = s.id )  WHERE sf.session_id = {$_SESSION['session_id']}
     AND sf.term_id ={$_REQUEST['term_id']} and c.type = 'jss'";
     $result = mysql_query($sql) or die(mysql_error());
     $class_name = $_REQUEST['class_id'];
  } else if ($_REQUEST['class_id'] == 'all_sss_classes')	{
    $sql="SELECT c.type, c.name, s.admission_number, s.firstname, 
     s.lastname, s.current_class_id, s.scholarship FROM student_fee sf
     JOIN (class c, student s) ON ( s.current_class_id = c.id
     AND sf.student_id = s.id )  WHERE sf.session_id ={$_SESSION['session_id']}
     AND sf.term_id ={$_REQUEST['term_id']} and c.type = 'sss'";
     $class_name = $_REQUEST['class_id'];
  } else {
    $sql="select * from student_fee where 
     session_id = {$_SESSION['session_id']}    
     and term_id = {$_REQUEST['term_id']}
     and class_id = {$_REQUEST['class_id']}";
    $class_name = get_value('class','name','id',$_REQUEST['class_id'], $con);
  }
  //echo "$sql<br>";
	
  if (mysql_num_rows(mysql_query($sql)) <= 0) {
    echo msg_box("There is no data for " . 
     get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
     " Session, " . get_value('term','name','id',$_REQUEST['term_id'], $con).
     " Term, Class $class_name", 
       'class_fee.php', 'Back');
    exit;
  }
  echo "
  <table>
   <tr class='class1'>
    <td style='text-align:center;'><h3>Class Fee</h3></td>
     <table>
      <tr>
       <td><b>Session:</b> ".
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con). "</td> 
       <td><b>Term:</b> " . 
       get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
       <td><b>Class:</b> ";
  if (($_REQUEST['class_id'] == 'all_classes') 
    || ($_REQUEST['class_id'] == 'all_jss_classes')
    || ($_REQUEST['class_id'] == 'all_sss_classes')) {
    echo $_REQUEST['class_id'];
  } else {
    echo get_value('class', 'name', 'id', $_REQUEST['class_id'], $con);
  }
  echo "</td>";
  if ($_REQUEST['action'] == 'Generate') {
    echo "<td><a style='cursor:hand;'; onclick='window.open(\"class_fee.php?action=Print&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}\", \"smallwin\", \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'><img src='images/icon_printer.gif'></a></td>
    ";
   }
   echo "
      </tr> 
     </table>
    </td>
   </tr>
   <tr>
    <td>
     <table style='table-layout:fixed;'>
      <tr>
       <th>Admission Number</th>
       <th>Firstname</th>
       <th>Lastname</th>
       <th>Class</th>
       <th>Date of Payment</th>
       <th>Teller Number</th>
       <th>Amount Due</th>
       <th>Amount Paid</th>
	   <th>Balance</th>
      </tr>
     </table>
    </td>
   </tr> ";
   $amount_due = 0;
   $amount_paid = 0;
   $total_balance = 0;
   //Fetch students in that class
   if ($_REQUEST['class_id'] == 'all_classes') {
     $sql="select * from student";
   } else if ($_REQUEST['class_id'] == 'all_jss_classes') {
     $sql="SELECT s.id, c.type, c.name, s.admission_number, s.firstname, 
      s.lastname, s.current_class_id, s.scholarship FROM student s
      JOIN class c ON  s.current_class_id = c.id
      and c.type = 'jss'";
   } else if ($_REQUEST['class_id'] == 'all_sss_classes') {
     $sql="SELECT s.id, c.type, c.name, s.admission_number, s.firstname, 
       s.lastname, s.current_class_id, s.scholarship FROM student s
       JOIN class c ON  s.current_class_id = c.id
       and c.type = 'sss'";
   } else {
     $sql="select * from student 
      where current_class_id = {$_REQUEST['class_id']}";
   }
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     echo "<tr>
            <td>
             <table style='table-layout:fixed;'>
              <tr>
               <td colspan='5'>
                <table style='table-layout:fixed;'>
                 <tr>
     ";
     if ($_REQUEST['action'] == 'Generate') {
       echo "
               <td>
                <a href='student_fee.php?class_id={$row['current_class_id']}&term_id={$_REQUEST['term_id']}&student_id={$row['id']}&action=Generate'>
				 {$row['admission_number']}</a>";
		if ($row['scholarship'] == 'Yes') 
		  echo "<span style='color:red;'>On Scholarship</span>";
		echo "</td>";
     } else {
       echo "<td>{$row['admission_number']} {$row['scholarship']}</td>";
     }
     echo "
               <td>{$row['firstname']}</td>
               <td>{$row['lastname']}</td>
	  ";
     echo "<td>" . get_value('class', 'name', 'id', $row['current_class_id'], 
      $con) . "</td>";
     echo "</tr></table></td>";
     $sql="select sum(amount) as 'amount' from fee_class 
         where class_id={$row['current_class_id']}";
     $result2 = mysql_query($sql) or die(mysql_error());
     $row2 = mysql_fetch_array($result2);
     $amount_due += $row2['amount']; 
     $amount = $row2['amount']; //local copy of amount due
     
     //Fetch school fees record for student in that class/term/session
     if ($_REQUEST['class_id'] == 'all_classes') {
       $sql1="select * from student_fee where 
        session_id = {$_SESSION['session_id']}    
        and term_id = {$_REQUEST['term_id']}
	and student_id={$row['id']} order by date_of_payment";
     } else if ($_REQUEST['class_id'] == 'all_jss_classes') {
        $sql1="SELECT sf.amount, c.type, c.name, s.admission_number, 
         s.firstname, sf.date_of_payment, sf.teller_number, s.lastname, 
         s.current_class_id FROM student_fee sf
	 JOIN (class c, student s) ON ( s.current_class_id = c.id
	 AND sf.student_id = s.id )  
         WHERE sf.session_id = {$_SESSION['session_id']}
	 AND sf.term_id = {$_REQUEST['term_id']}
	 and sf.student_id={$row['id']} and c.type = 'jss' order by
	 sf.date_of_payment";
     } else if ($_REQUEST['class_id'] == 'all_sss_classes') {
       $sql1="SELECT sf.amount, c.type, c.name, s.admission_number, 
        s.firstname, sf.date_of_payment, sf.teller_number, s.lastname, 
        s.current_class_id FROM student_fee sf
        JOIN (class c, student s) ON ( s.current_class_id = c.id
        AND sf.student_id = s.id )  
        WHERE sf.session_id = {$_SESSION['session_id']}
        AND sf.term_id = {$_REQUEST['term_id']}
        and sf.student_id={$row['id']} and c.type = 'sss'
       order by sf.date_of_payment";
     } else {
      $sql1="select * from student_fee where 
       session_id={$_SESSION['session_id']} and term_id={$_REQUEST['term_id']}
       and class_id={$_REQUEST['class_id']} 
       and student_id={$row['id']} order by date_of_payment";
     }
     $result1 = mysql_query($sql1) or die(mysql_query() . "111");
     if (mysql_num_rows($result1) <= 0) {
       echo " <tr>
               <td>&nbsp;</td>
	           <td>&nbsp;</td>
	           <td>&nbsp;</td>
	           <td>&nbsp;</td>
	           <td>-</td>
               <td>-</td>
               <td>$amount</td>
               <td>0</td>
			   <td>0</td>
              </tr>
       ";
     } else {
       while ($row1 = mysql_fetch_array($result1)) { 
         $amount_paid += $row1['amount'];
		 $balance = $amount - $row1['amount'];
		 
         echo "
	      <tr>
	       <td>&nbsp;</td>
	       <td>&nbsp;</td>
	       <td>&nbsp;</td>
	       <td>&nbsp;</td>
	       <td>&nbsp;</td>
	       <td>{$row1['date_of_payment']}</td>
           <td>{$row1['teller_number']}</td>
           <td>" . number_format($amount, 2) . "</td>
           <td>" . number_format($row1['amount'], 2) . "</td>
		   <td>$balance</td>
	      </tr>";
         $amount -= $row1['amount']; 
       }
	   $total_balance += $balance;
     }
     echo "</table></td></tr>";
	 
   }
   echo "<tr><td>
     <table border='1' style='text-align:center; table-layout:fixed;'>
      <tr><td><h3>Total</h3></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><b>" . number_format($amount_due, 2) . "</b></td>
       <td><b>" . number_format($amount_paid, 2) . "</b></td>
	   <td><b>$total_balance</b></td>
      </tr>
     </table>
    </td>
   </tr>";
 exit;
 }
 ?> 
<table style='table-layout:fixed;'> 
 <tr class="class1">
  <td colspan='3'><h3>Generate Financial Record</h3></td>
 </tr>
 <form action="class_fee.php" method="post">
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
   <select name="class_id">
    <option value='all_classes'>All Classes</option>
    <option value='all_jss_classes'>All JSS Classes</option>
    <option value='all_sss_classes'>All SSS Classes</option>
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
 <tr>
  <td>
   <input name='action' type='submit' value='Generate'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
