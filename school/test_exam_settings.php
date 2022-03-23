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
  || user_type($_SESSION['uid'], 'Exams', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) &&
  ($_REQUEST['action'] == 'Update')) {

  if ((!is_numeric($_REQUEST['test'])) || (!is_numeric($_REQUEST['exam']))) {
    echo msg_box("Please enter numbers for
    Test and Exam Settings", "test_exam_settings.php", "Back");
   exit;
  }
  if (empty($_REQUEST['test']) || empty($_REQUEST['exam'])) {
    echo msg_box("Please make sure you enter correct values for
    Test and Exam Settings", "test_exam_settings.php", "Back");
   exit;
  } else {
    $result = mysqli_query($con, "select * from test_exam_settings where id=1");
    if(mysqli_num_rows($result) > 0) {
      $sql="UPDATE test_exam_settings set test='{$_REQUEST['test']}',
       exam = '{$_REQUEST['exam']}' where id=1";
      mysqli_query($con, $sql);
    } else {
      $sql="INSERT INTO test_exam_settings (test, exam)
           VALUES('{$_REQUEST['test']}', '{$_REQUEST['exam']}')";
        mysqli_query($con, $sql);
    }
  }
}

$result = mysqli_query($con, "SELECT * FROM test_exam_settings");
$row = mysqli_fetch_array($result);
?>
  <form action='test_exam_settings.php' method='post' name='form1'>
  <table>
   <tr class='class1'>
    <td colspan="4"><h3>Test Exam Settings</h3></td>
   </tr>
      <tr>
       <td>Test</td>
    <td><input type="text" name="test" size="2"
     maxlength='2' value="<?=$row['test']?>">%</td>
      </tr>
      <tr>
       <td>Exam</td>
        <td><input type="text" name="exam" size="2"
      maxlength='2' value="<?=$row['exam']?>">%
        </td>
      </tr>
      <tr>
       <td><input type="submit" name="action" value="Update"></td>
      </tr>
     </form>
    </table>
<?
  main_footer();
?>
