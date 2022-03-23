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

$user = array('Administrator','Proprietor','Accounts');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
}
main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

$extra_caution_sql = " session_id={$_SESSION['session_id']} and term_id={$_SESSION['term_id']} and class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";

	//Make sure that Session/Term/Class has been created and
 //that the session variables representing them have been set
check_session_variables('enter_fees.php', $con);

$sql="SELECT sum(amount) as 'sum' FROM fee_class_{$_SESSION['sessid']} WHERE $extra_caution_sql";
$result_x = mysqli_query($con, $sql) or die(mysqli_error($con));
$rowx = mysqli_fetch_array($result_x);
$amount_due = $rowx['sum'];

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (!isset($_REQUEST['admission_number'])) {
    echo msg_box("Please choose a Student's Payment to delete",
      'enter_fees.php', 'Back');
  }
  $sql="delete from student_fees_{$_SESSION['sessid']} where admission_number={$_REQUEST['admission_number']} and $extra_caution_sql";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'],$con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Save')) {
   $sql="select * from student s join student_temp_{$_SESSION['sessid']} st on
     s.id = st.student_id where st.class_id={$_SESSION['class_id']}";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   if (mysqli_num_rows($result) <= 0) {
     echo msg_box("No Student(s) exist for this Class",'enter_fees.php', 'Back');
     exit;
   }
   while ($row = mysqli_fetch_array($result)) {
     $sql="select * from student_fees_{$_SESSION['sessid']}
       where admission_number = {$row['admission_number']}
       and $extra_caution_sql order by id";

     $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
     while($row1 = mysqli_fetch_array($result1)) {

	   if (isset($_REQUEST["{$row['admission_number']}_{$row1['id']}_amount_paid"])) {

         $amount_paid = $_REQUEST["{$row['admission_number']}_{$row1['id']}_amount_paid"];
		 $date = $_REQUEST["{$row['admission_number']}_{$row1['id']}_date"];
	     if ((!is_numeric($amount_paid)) || ($amount_paid == 0))
           $sql="delete from student_fees_{$_SESSION['sessid']} where id={$row1['id']}"; //This is safe
         else {
		   $sql="select sum(amount_paid) as 'amount' from student_fees_{$_SESSION['sessid']}
             where admission_number = {$row['admission_number']}
             and $extra_caution_sql order by id";
	       $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
	       $row2 = mysqli_fetch_array($result2);

		   //Only update if total amount paid is less than amount_due
		   if ($row2['amount'] < $amount_due) {
		     $sql="update student_fees_{$_SESSION['sessid']} set amount_paid='$amount_paid', date='{$date}' where id= {$row1['id']}";
		   }
         }
		 mysqli_query($con, $sql) or die(mysqli_error($con));
	   }
     }
   }
   save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'],$con);
}
//	exit;
?>
  <form action='enter_fees.php' method='post'>
   <table>
    <tr class='class1'>
     <td colspan='3'><h3>Process Fees</h3></td>
    </tr>
	<tr>
    <td colspan='3' class='message'>
     Please leave Amount Paid as 0 if Student is not paying School Fees.</td>
   </tr>
   <tr>
    <td>
     <table border='1' valign='top'
        style='table-layout:row; border-spacing:0em;
        border-collapse:collapse; width:100%;'>
      <tr>
       <th>Student</th>
       <th>Date</th>
       <th>School Fees</th>
       <th>Amount</th>
       <th>Amount Outstanding</th>
      </tr>
   <?php
   //Delete any previous entry that has amount_paid = 0
   $sql="delete from student_fees_{$_SESSION['sessid']} where amount_paid = 0 and $extra_caution_sql";
   mysqli_query($con, $sql) or die(mysqli_error($con));

   $sql="select * from student s join student_temp_{$_SESSION['sessid']} st
     on s.id = st.student_id where st.class_id={$_SESSION['class_id']} order by admission_number";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   if (mysqli_num_rows($result) <= 0) {
     echo msg_box("No Student(s) exist for this Class",'enter_fees.php', 'Back');
     exit;
   }

   while ($row = mysqli_fetch_array($result)) {

     $amount_paid_name;
     $amount_paid_value = 0;
     $amount_outstanding = 0;
     $sql="select sum(amount_paid) as 'amount' from student_fees_{$_SESSION['sessid']}
       where admission_number = {$row['admission_number']}
       and $extra_caution_sql order by id";
	 $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
	 $row1 = mysqli_fetch_array($result1);

     $sql="insert into student_fees_{$_SESSION['sessid']}(session_id, term_id, class_id,
         admission_number, date, amount_paid, school_id)
         values({$_SESSION['session_id']}, {$_SESSION['term_id']},
         {$_SESSION['class_id']}, '{$row['admission_number']}', '". date('Y-m-d') . "', '0',
         {$_SESSION['school_id']})";

     mysqli_query($con, $sql) or die(mysqli_error($con));
     $id = mysqli_insert_id($con);
     $amount_paid_name = "{$row['admission_number']}_{$id}_amount_paid";
     $amount_paid_value = '0';
     $amount_outstanding = $amount_due - $row1['amount'];
	 $date = "{$row['admission_number']}_{$id}_date";

     echo "
       <tr>
        <td><a href='student_fees_report.php?admission_number={$row['admission_number']}&action=Generate&session_id1={$_SESSION['session_id']}&term_id1={$_SESSION['term_id']}&class_id1={$_SESSION['class_id']}'>{$row['admission_number']} {$row['firstname']} {$row['lastname']}</a></td>
        <td><input type='text' name='{$date}' value='" . date('Y-m-d') . "'></td>
        <td>$amount_due</td>
        <td><input type='text' name='$amount_paid_name'
          value='$amount_paid_value' /></td>
	    <td>$amount_outstanding<a href='enter_fees.php?action=Delete&admission_number={$row['admission_number']}'>Void</a></td>
		</tr>";
   }
   ?>
   </table></td></tr>
    <tr>
     <td>
      <input type='submit' name='action' value='Save'>
      <!--<input type='submit' name='action' value='Delete'>-->
     </td>
    </form>
    </tr>
    </table>
<?php
main_footer();
?>
