<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "school.inc";
require_once "backup_restore.inc";

$con = connect();

$user = array('Administrator','Proprietor', 'Records');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Student List', 'student.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

//Make sure that Session/Term/Class has been created and
//that the session variables representing them have been set
check_session_variables('student.php', $con);

$extra_caution_sql = "class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  check($_REQUEST['id'], "Please choose a student", 'attendance.php');

  //Update Students information
  $sql = gen_update_sql("student_temp_{$_SESSION['sessid']}", $_REQUEST['id'], array('class_id', 'student_id'), $con);
  mysqli_query($con, $sql) or die(mysqli_error($con));

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Edit')) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a Student\'s attendance to edit', 'attendance.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from student_temp_{$_SESSION['sessid']} where id=$id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $sql="select * from student s join student_temp_{$_SESSION['sessid']} st on
   st.student_id = s.id where st.id={$id}";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row1 = mysqli_fetch_array($result1);
  $name = "{$row1['admission_number']} {$row1['firstname']} {$row1['lastname']}";

  $skip = array("id", "class_id", "student_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';

  generate_form('Edit Only', 'attendance.php', $id, "student_temp_{$_SESSION['sessid']}", $row,
    $skip,$referer, " ", $con, "Editing attendance for $name");
  exit;
}
?>
<div class='class1'>
<?php

  if((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
      || (!isset($_REQUEST['action']))) {
      echo "<a href='attendance.php?action=Print'>Print</a>";
  }
  echo "<h3 class='sstyle1'>Student's Attendance</h3>";



  //house, gender
  $skip = array('id', 'class_id');

  $sql="describe student_temp_{$_SESSION['sessid']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (in_array($field[0], $skip))
      continue;
    $cols[] = $field[0];
  }
  echo "
  </div>
   <table class='tablesorter'>";
  $sql = "select * from student_temp_{$_SESSION['sessid']} where class_id={$_SESSION['class_id']}";

  gen_list("student_temp_{$_SESSION['sessid']}", 'attendance.php',
   'student_id', $cols, $skip, $sql, $con);

  echo '</table>';
  require_once "tablesorter_footer.inc";
  main_footer();
?>
