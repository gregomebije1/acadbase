<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once 'ui.inc';
require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();

$user = array('Administrator','Proprietor', 'Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);

//Make sure that Session/Term/Class has been created and
 //that the session variables representing them have been set
 check_session_variables('report_card.php', $con);

if (isset($_POST['action']) && ($_POST['action'] == 'Submit')) {

  check($_POST['student_name'], 'Please enter a Student\'s Name',
    'academic_history.php', 'Back');

  //Save previous sessid
  $previous_sessid = $_SESSION['sessid'];

  $admission_number = get_admission_number(htmlentities($_REQUEST['student_name'], ENT_QUOTES));
  /*** Get all the Sessions/Terms from this school ***/
  $sql="select session.id as 'sid',school.id as 'school_id', session.name as 'sname', class.id as 'cid', class.name as 'cname' from school join (session, class) on (school.id = session.school_id and school.id = class.school_id) where school.id = {$_SESSION['school_id']}";

  $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
  $found = False;

  while ($row2 = mysqli_fetch_array($result2)) {
    $_SESSION['sessid'] = mt_rand();
	$file_name = "data/{$_SESSION['school_id']}/{$row2['sid']}_{$row2['cid']}.sql";
	open_session($_SESSION['sessid'],  $file_name, $con);

	/*** Get Student's result for this Session/Term/Class ***/
	$sql="select * from term where session_id={$row2['sid']}";
	$result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($row3 = mysqli_fetch_array($result3)) {
	  $sql = "select * from student_subject_{$_SESSION['sessid']} where session_id={$row2['sid']}
        and term_id={$row3['id']} and class_id={$row2['cid']} and admission_number='$admission_number'";

      if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
        $found = True;
        $url = "display_result.php?action=Submit&school_id={$_SESSION['school_id']}&admission_number={$admission_number}&session_id={$row2['sid']}&term_id={$row3['id']}&class_id={$row2['cid']}&from=academic_history.php";

        echo "Result is available for <a href='$url'> {$row2['sname']} Session {$row3['name']} Term, Class {$row2['cname']} </a><br><br>";
      }
	}
	close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $row2['sid'], $row2['cid'], $con);
  }
  if (!$found)
    echo "No Result available";

  //Restore our previous environment
  $_SESSION['sessid'] = "$previous_sessid";

  exit;
}
require_once "choose_student_ui.php";
choose_student_ui("Academic History", "academic_history.php", $con);
?>
