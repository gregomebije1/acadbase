<?php
session_start();
if (!isset($_SESSION['uid'])) {
  header('Location: index.php');
  exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "school.inc";

$con = connect();

$user = array('Administrator','Proprietor', 'Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Subject List', 'subject.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

$extra_caution_sql = " school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {

  check($_REQUEST['id'], "Please choose a subjects", 'subject.php');

  //Delete subject if there is no student registered for it
  $sql="select s.id from subject s join student_subject_{$_SESSION['sessid']} ss
    on s.id = ss.subject_id where s.id={$_REQUEST['id']}
    and ss.school_id={$_SESSION['school_id']} ";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("***WARNING***<br>
      Deleting this subject will delete all students academic
      records still tired to this Subject<br>
      Are you sure you want to delete " .
      REQUEST_value('subject', 'name', 'id', $_REQUEST['id'], $con) . "?",
      "subject.php?action=confirm_delete&id={$_REQUEST['id']}",
      'Continue to Delete');
    exit;
  } else {
    echo msg_box("***WARNING***<br>
      Are you sure you want to delete " .
      get_value('subject', 'name', 'id', $_REQUEST['id'], $con) . "?",
      "subject.php?action=confirm_delete&id={$_REQUEST['id']}",
      'Continue to Delete');
      exit;
  }
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  check($_REQUEST['id'], "Please choose a subject", "subject.php");

  //Check if the subject exists
  $sql="select * from subject where id={$_REQUEST['id']}
    and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("Subject does not exist in the database", 'subject.php', 'OK');
	exit;
  }

  //If exist, delete from subject
  $sql="delete from subject where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  //Delete this subject from all Student's record
  $sql="delete from student_subject_{$_SESSION['sessid']} where subject_id={$_REQUEST['id']}
    and $extra_caution_sql";
  mysqli_query($con, $sql) or die(mysqli_error($con));


} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['id'], 'Please choose a Subject', "subject.php?action=Edit&id={$_REQUEST['id']}", 'Back');

  check($_REQUEST['name'], 'Please enter a Subject', "subject.php?action=Edit&id={$_REQUEST['id']}", 'Back');

  $sql="update subject set name='{$_REQUEST['name']}', class_type_id='{$_REQUEST['class_type_id']}'
  where id={$_REQUEST['id']} and $extra_caution_sql";

  mysqli_query($con, $sql) or die(mysqli_error($con));

} if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {
  check($_REQUEST['name'], 'Please enter a subject', 'subject.php?action=Add');

  $sql="SELECT * FROM subject WHERE name ='{$_REQUEST['name']}'
   and class_type_id = '{$_REQUEST['class_type_id']}' and $extra_caution_sql";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if(mysqli_num_rows($result) > 0) {
    echo msg_box("This subject already exists",
      'subject.php?action=Add', 'Back');
  } else {
    $sql = gen_insert_sql('subject',array('school_id'),$con);
    mysqli_query($con, $sql) or die(mysqli_error($con));
    $subject_id = mysqli_insert_id($con);

    $sql="update subject set school_id={$_SESSION['school_id']}
      where id={$subject_id}";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }
} elseif (isset($_REQUEST['action']) && (($_REQUEST['action'] == 'Add')
 || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))) {
    echo msg_box('Please choose a Subject', 'subject.php', 'Back');
    exit;
  }

  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  //subjects cannot be edited
  $result = mysqli_query($con, "select * from subject where id=$id")
   or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';

  generate_form($_REQUEST['action'],'subject.php',$id,'subject',$row,$skip,
    $referer, " where school_id={$_SESSION['school_id']}",$con);

  exit;
}
?>
<div class='class1'>
 <?php
    if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
      || (!isset($_REQUEST['action']))) {
      echo "
        <a href='subject.php?action=Add'>Add</a>|
        <a href='subject.php?action=Print'>Print</a>";
  }
  ?>
  <h3 class='sstyle1' style='display:inline;'>Subject</h3>
  </div>

 <table class='subject'>
 <thead>
 <tr>

 <?php

  $class_type = array();
  $sql="select * from class_type where $extra_caution_sql order by id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    //echo "<th colspan='2' style='text-align:center;'>
	echo "<th style='text-align:left;'>
     {$row['description']}</th>";
    $class_type[$row['id']] = $row['name'];
  }
 ?>
 </tr>
 </thead>
 <tbody>
 <tr>
 <?php
  foreach($class_type as $id => $name) {
    echo"
	 <td style='vertical-align:top;'>
	  <div style='text-align:left;'>
   ";
   $sql="select * from subject where $extra_caution_sql
     and class_type_id = $id  order by id";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while($row = mysqli_fetch_array($result)) {
	echo "<a href='subject.php?action=Edit&id={$row['id']}'>{$row['name']}</a><br/>";
   }
   echo "</div></td>";
 }
 echo "</tr></tbody></table>";
 main_footer();
?>
