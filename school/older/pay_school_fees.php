<?
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

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Post')) {
   if (empty($_REQUEST['teller_number'])) {
     echo msg_box('Please enter the teller number', 
     'pay_school_fees.php', 'Back');
     exit;
   } 
   $amount_remaining = get_all_fees($_REQUEST['class_id']) - 
    get_amount_paid($_SESSION['session_id'], $_REQUEST['term_id'], 
     $_REQUEST['class_id'], $_REQUEST['student_id']);

   if ($_REQUEST['amount'] > $amount_remaining) {
     echo msg_box('The amount entered is greater than the remaining 
      amount of fees to be paid', 'pay_school_fees.php', 'Back');
     exit;
   }
   $sql="select * from student where id={$_REQUEST['student_id']}";
   $result = mysql_query($sql) or die(mysql_error());
   $row = mysql_fetch_array($result);
   if ($row['scholarship'] == 'Yes') {
     echo msg_box('This student is currently on a scholarship', 
	  'pay_school_fees.php', 'Back');
	 exit;
   }
   $sql="select * from student_fee where session_id={$_SESSION['session_id']}
    and term_id={$_REQUEST['term_id']} and class_id={$_REQUEST['class_id']}
    and student_id={$_REQUEST['student_id']} and teller_number='{$_REQUEST['teller_number']}'";
   if (mysql_num_rows(mysql_query($sql)) > 0) {
     echo msg_box("A Payment has already been recorded <br>
	  with the teller number {$_REQUEST['teller_number']} in the database
      for " . get_value('session', 'name', 'id', $_SESSION['session_id'], $con)
      . " Session, " . 
      get_value('term', 'name', 'id', $_REQUEST['term_id'], $con)
      . " Term for " . 
      get_value('student', 'firstname', 'id', $_REQUEST['student_id'], $con)
	  . "<br> Use another teller number", 'pay_school_fees.php', 'Back');
     exit;
   }
   $sql = "insert into student_fee(session_id, term_id, class_id, 
     student_id, date_of_payment, teller_number, amount) 
     values({$_SESSION['session_id']}, 
     {$_REQUEST['term_id']}, {$_REQUEST['class_id']}, 
     {$_REQUEST['student_id']}, '{$_REQUEST['date']}', 
     '{$_REQUEST['teller_number']}', 
    '{$_REQUEST['amount']}')";
   $result = mysql_query($sql) or die(mysql_error());
   echo msg_box('Successfully Posted', 
     "student_fee.php?action=Generate&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}&student_id={$_REQUEST['student_id']}", 
       'Continue');
   exit;
} 
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4">
     <h3>Pay School Fees</h3>
    </td>
   </tr>
   <form name='form1' action="pay_school_fees.php" method="post">
   <tr>
    <td>Session</td>
    <td>
    <?php 
     echo get_value('session', 'name', 'id', $_SESSION['session_id'], $con);
     echo "<input type='hidden' name='session_id' 
       value='{$_SESSION['session_id']}'>";
     echo "</td></tr><tr><td>Term</td><td>";
     echo "<select name='term_id'>";
     $result = mysql_query("select * from term where session_id={$_SESSION['session_id']}") or die(mysql_error());
     while ($row = mysql_fetch_array($result)) {
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     echo "</select>";
    ?>
   </td>
   <tr>
    <td>Date</td>
    <td>
     <input type="text" name="date" value='<?php echo date('Y-m-d'); ?>'
      maxlength='10' size='10'>
    </td>
   </tr>
   <tr>
    <td>Teller Number</td>
    <td><input type='text' name='teller_number'></td>
   </tr>
   <tr>
    <td>Class</td>
    <td><select name='class_id' onchange='get_students();'>
      <option value='0'></option>
     <?php
     $result = mysql_query("select * from class") or die(mysql_error());
     while ($row = mysql_fetch_array($result)) {
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
     </select>
    </td>
   <tr><td>Name of Student</td><td><div id='students'></div></td></tr> 
   <tr><td>Fees to be paid</td><td><div id='fees' style='color:red;'></div></td></tr>
   <tr>
    <td>Amount</td>
    <td><input type="text" name='amount'></td>
   </tr>
   <tr>
    <td>
     <input name="action" type="submit" value="Post">
     <input name="action" type="submit" value="Cancel"> 
    </td>
   </tr>
  </table>
  <? main_footer(); ?>
