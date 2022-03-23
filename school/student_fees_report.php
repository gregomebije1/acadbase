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

  $previous_sessid = $_SESSION['sessid'];
  
  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_SESSION['school_id']}/{$_REQUEST['session_id1']}_{$_REQUEST['class_id1']}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);

  $sql="SELECT sum(amount) as 'sum' FROM fee_class_{$_SESSION['sessid']} WHERE 
    session_id={$_REQUEST['session_id1']} and term_id={$_REQUEST['term_id1']} 
	and class_id={$_REQUEST['class_id1']} and school_id={$_SESSION['school_id']}";

  $result_x = mysqli_query($con, $sql) or die(mysqli_error($con));
  $rowx = mysqli_fetch_array($result_x);
  $amount_due = $rowx['sum'];
  
  $sql="select * from student s join student_temp_{$_SESSION['sessid']} st
    on s.id = st.student_id where st.class_id={$_REQUEST['class_id1']} 
	and s.school_id={$_SESSION['school_id']} and s.admission_number={$_REQUEST['admission_number']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
?>
 <form action='student_fees_report.php' method='post'>
  <table>
   <tr class='class1'>
    <td colspan='3' style='text-align:center;'><h3>
	<?php
	echo "Session: " . get_value('session', 'name', 'id', $_REQUEST['session_id1'], $con);
	echo " Term: " . get_value('term', 'name', 'id', $_REQUEST['term_id1'], $con);
	echo " Class: " . get_value('class', 'name', 'id', $_REQUEST['class_id1'], $con);
	?>
	</h3>
	</td>
   </tr>
   <tr class='class1'>
   <td colspan='3' style='text-align:center;'><h3>
	School Fees Report For 
	<?php echo "{$row['admission_number']} {$row['firstname']} {$row['lastname']}"; ?></h3></td>
   </tr>
   <tr>
    <td>
     <table border="1" width="100%" rules="rows">
      <tr style="background-color:silver">
       <td><b>Date</b></td>
       <td><b>Description</b></td>
       <td><b>Debit</b></td>
       <td><b>Credit</b></td>
       <td><b>Balance</b></td>
      </tr>
  <?php	
  
	echo "<tr>
	  <td>" . get_value('term', 'begin_date', 'id', $_SESSION['term_id'], $con) . "</td>
	  <td>School Fees</td>
	  <td>" . number_format($amount_due, 2) . "</td>
	  <td>&nbsp;</td>
	  <td>" . number_format($amount_due, 2) . "</td></tr>";
	  
    $sql="select * from student_fees_{$_SESSION['sessid']} where 
     session_id = {$_REQUEST['session_id1']}    
     and term_id = {$_REQUEST['term_id1']}
     and class_id = {$_REQUEST['class_id1']}
	 and school_id={$_SESSION['school_id']}
     and admission_number = {$_REQUEST['admission_number']}
	 and amount_paid != 0 order by id";
  
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
	    $amount_due = $amount_due - $row['amount_paid'];
	  
	    echo "<tr>
	     <td>{$row['date']}</td>
	     <td>Paid School Fees</td>
	     <td></td>
	     <td>" . number_format($row['amount_paid'], 2) . "</td>
	     <td>" . number_format($amount_due, 2) . "</td></tr>";
	  }
	}
	?>
  </table>
  </form>
  <?php 
  
  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_REQUEST['session_id1'], $_REQUEST['class_id1'], $con);
  
  $_SESSION['sessid'] = "$previous_sessid";
  }
  main_footer();?>