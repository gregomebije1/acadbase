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

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {

  check($_REQUEST['id'], "Please choose a student", 'student.php');

  echo msg_box("Deleting a Student will delete all his Academic
    and Financial records",
   "student.php?action=confirm_delete&id={$_REQUEST['id']}",
    'Continue to Delete?');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

  check($_REQUEST['id'], "Please choose a student", 'student.php');
  $sql="select * from student where id={$_REQUEST['id']}
     and school_id={$_SESSION['school_id']}";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("Student does not exist in the database",
      'student.php', 'Back');
    exit;
  }
  $row = mysqli_fetch_array($result);
  delete_student($row['admission_number'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {
  $url = "student.php?action=Add";
  check($_REQUEST['admission_number'], 'Please enter Admission Number', $url);

  check($_REQUEST['firstname'], 'Please enter Firstname', $url);

  check($_REQUEST['lastname'], 'Please enter Lastname', $url);

  check($_REQUEST['class_id'], 'Please enter Class', $url);

  //Do not register the student if He/She has the same
  //admission number as someone else in his school
  $sql="select * from student where
     admission_number='{$_REQUEST['admission_number']}' and school_id={$_SESSION['school_id']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("There is already a student with the
       same admission number.<br>Please choose another admission number<br>",
      'student.php?action=Add', 'Back to adding student');
    exit;
  }

  $arr = array('passport_image');
  foreach($arr as $ar)
    if(!empty($_FILES[$ar]['name']))
      upload_file($ar, 'student.php?action=Add');

  //Insert the Student
  $sql = gen_insert_sql('student',array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $id = mysqli_insert_id($con);

  //Set the school for this Student
  $sql="update student set school_id={$_SESSION['school_id']} where id={$id}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Add a user for this student, so that He/She can access result online
  mt_srand(make_seed()); //Seed with microseconds
  $pincode = mt_rand();

  $sql="insert into user(name, passwd, firstname, lastname, school_id)
    values('{$_REQUEST['admission_number']}','{$pincode}',
    '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}',
    '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $user_id = mysqli_insert_id($con);

  //Add permission for this Student. 6 is code for Student Permission
  $sql="insert into user_permissions(uid,pid) values('{$user_id}','6')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Add student_temp_{$_SESSION['sessid']}
  $sql="insert into student_temp_{$_SESSION['sessid']} (student_id, class_id) values ({$id}, {$_REQUEST['class_id']})";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  check($_REQUEST['id'], "Please choose a student", 'student.php');

  check($_REQUEST['admission_number'], 'Please enter Admission Number', 'student.php');

  check($_REQUEST['firstname'], 'Please enter Firstname', 'student.php');

  check($_REQUEST['lastname'], 'Please enter Lastname', 'student.php');

  check($_REQUEST['class_id'], 'Please enter Class', 'student.php');

  $arr = array('passport_image');
  foreach($arr as $ar)
    if(!empty($_FILES[$ar]['name']))
     upload_file($ar, 'student.php?action=Add');

  //Update Students information
  $sql = gen_update_sql('student', $_REQUEST['id'], array('school_id'), $con);
  mysqli_query($con, $sql) or die(mysqli_error($con));

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

} else if (isset($_REQUEST['action']) &&
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a student to edit', 'student.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from student where id=$id";

  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';

  generate_form($_REQUEST['action'], 'student.php', $id, 'student', $row,
    $skip,$referer, " where school_id={$_SESSION['school_id']}", $con);
  exit;
}
?>
<div class='class1'>
<?php

  if((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
      || (!isset($_REQUEST['action']))) {
      echo "
      <a href='student.php?action=Add'>Add</a>|
      <a href='student.php?action=Print'>Print</a>";
  }
  echo "<h3 class='sstyle1'>Students</h3>";

  if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
    || (!isset($_REQUEST['action']))) {

  ?>
   <div class='sstyle2'>
    <form class='style4' name='form1' action='student.php' method='post' >
     Search
     <input type='text' name='search'>
     <input type='submit' name='action' value='Search'>
    </form>
   </div>

  <?php
  }

  //house, gender
  $skip = array('id', 'current_class_id', 'date_of_admission', 'class_id',
    'state_of_origin', 'parent_guardian_address',
	'parent_guardian_email', 'first_term_times_present', 'first_term_times_absent',
    'second_term_times_present', 'second_term_times_absent',
    'third_term_times_present', 'third_term_times_absent',
    'passport_image','school_id','any_other_information','scholarship');

  $sql="describe student";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (in_array($field[0], $skip))
      continue;
    $cols[] = $field[0];
  }
  echo "
  </div>
   <table class='tablesorter'>";
  $sql = "select s.id, s.admission_number, s.firstname, s.lastname, s.date_of_birth, s.gender,
    s.house, s.parent_guardian_name, s.parent_guardian_phone from student s join student_temp_{$_SESSION['sessid']} st
   on s.id = st.student_id where ";

  $sql2 = "";
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Search')) {
    $sql2 = " s.admission_number like '%{$_REQUEST['search']}%'
	     or s.firstname LIKE '%{$_REQUEST['search']}%'
	     or s.lastname LIKE '%{$_REQUEST['search']}%'
	     or s.date_of_birth LIKE '%{$_REQUEST['search']}%'
	     or s.state_of_origin LIKE '%{$_REQUEST['search']}%'
	     or s.any_other_information LIKE '%{$_REQUEST['search']}%'
		 or s.parent_guardian_name LIKE '%{$_REQUEST['search']}%'
		 or s.parent_guardian_address LIKE '%{$_REQUEST['search']}%'
		 or s.parent_guardian_email LIKE '%{$_REQUEST['search']}%'
		 or s.parent_guardian_phone LIKE '%{$_REQUEST['search']}%'
	     or s.house LIKE '%{$_REQUEST['search']}%'
	     or s.gender LIKE '%{$_REQUEST['search']}%'";
  }
  if (!empty($sql2))
    $sql .= " $sql2 ";
  else
    $sql .= " st.class_id != 0 ";

  $sql .= " and (st.class_id={$_SESSION['class_id']} and
    s.school_id={$_SESSION['school_id']}) order by s.admission_number";

  gen_list('student', 'student.php', 'admission_number',
    $cols, $skip, $sql, $con);

  echo '</table>';
  require_once "tablesorter_footer.inc";
  main_footer();
?>
