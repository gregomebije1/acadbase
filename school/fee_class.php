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

$user = array('Administrator','Accounts', 'Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
} 

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);


if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  $sql="update fee_class_{$_SESSION['sessid']} set amount='{$_REQUEST['amount']}'
      where school_id={$_SESSION['school_id']}
	  and session_id={$_SESSION['session_id']} 
	  and term_id={$_SESSION['term_id']} 
	  and class_id={$_SESSION['class_id']}";
  
  mysqli_query($con, $sql) or die(mysqli_error($con));
  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'],$con);
}
?>
<table> 
<tr class="class1">
<td colspan='2'><h3>Specify School Fees for this Class</h3></td>
</tr>
<form action="fee_class.php" method="post">
<tr>
<td>Amount</td>
<?php  
  $sql = "select * from fee_class_{$_SESSION['sessid']} where 
   school_id={$_SESSION['school_id']} 
   and session_id={$_SESSION['session_id']} 
   and term_id={$_SESSION['term_id']} 
   and class_id={$_SESSION['class_id']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  echo "
   <td>
	 <input type='text' name='amount' value='{$row['amount']}'>
	</td>
   </tr>";
?>
<tr>
<td>&nbsp;</td>
<td>
 <input name="action" type="submit" value="Update">
</td>
</tr>
</table>
<?php main_footer(); ?>