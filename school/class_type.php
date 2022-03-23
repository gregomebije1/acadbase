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

/***Only allow the right person to login***/
$user = array('Administrator','Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

$extra_caution_sql = "school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Class List', 'class_type.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {

  check($_REQUEST['id'],'Please choose a class type', 'class_type.php', 'Back');

  /*** Check if there are students who are part of any class
   ** that is of this Class type
   ***/
  $sql="select c.id from class c join (student s, class_type ct)
   on (c.id = s.class_id  and ct.id = c.class_type_id)
    where ct.id={$_REQUEST['id']} and c.$extra_caution_sql";

  /*** The message will shall display ***/
  $msg = "Deletion denied<br>They are students currently
     allocated to this Class Type";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, $url, $back);
    exit;
  } else {
    /***Ok, No Student was found. Lets proceed to delete, but warn the User**/
    echo msg_box("Deleting this Class Type will delete Student(s)
     previous Academic and Financial records still tired to this Class Type<br>
     Are you sure you still want to delete " .
     get_value('class_type', 'name', 'id', $_REQUEST['id'], $con) . "?",
     "class_type.php?action=confirm_delete&id={$_REQUEST['id']}",
     'Continue to Delete');
    exit;
  }
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

  check($_REQUEST['id'],'Please choose a class type', 'class_type.php', 'Back');

  /*** Check if there are students who are part of any class
   ** that is of this Class type
   ***/
  $sql="select c.id from class c join (student s, class_type ct)
   on (c.id = s.class_id  and ct.id = c.class_type_id)
    where ct.id={$_REQUEST['id']} and c.$extra_caution_sql";

  $msg = "Deletion denied<br>They are students currently
     allocated to this Class Type";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, $url, $back);
    exit;
  } else {
    /***For each class of this Class Type***/
    $sql="select * from class where class_type_id={$_REQUEST['id']}";
    $result1 = mysqli_query($con, $result1) or die(mysqli_error($con));
    while($row1 = mysqli_fetch_array($result1)) {

	  //Delete Student Subject
	  $sql="delete from student_subject where class_id={$row1['id']} and $extra_caution_sql";
      mysqli_query($con, $sql) or die(mysqli_error($con));

	  $sql="delete from student_comment where class_id={$row1['id']} and $extra_caution_sql";
      mysqli_query($con, $sql) or die(mysqli_error($con));

     $sql="delete from student_non_academic where class_id={$row1['id']}  and $extra_caution_sql";
     mysqli_query($con, $sql) or die(mysqli_error($con));

	 $sql="delete from student_fees where class_id={$row1['id']} and $extra_caution_sql";
     mysqli_query($con, $sql) or die(mysqli_error($con));

      /***Delete all fees tired to this class***/
      $sql="delete from fee_class where class_id={$row1['id']}
        and $extra_caution_sql";
      $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

      /***You can now delete this Class ***/
      $sql="delete from class where id={$row1['id']} and $extra_caution_sql";
      $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
    }
    /***You can now delete this Class Type***/
    $sql="delete from class_type where id={$_REQUEST['id']}
     and $extra_caution_sql";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  }
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['name'], 'Please enter name for this Class Type',
    'class_type.php?action=Add');

  check($_REQUEST['description'],
    'Please enter a description', 'class_type.php?action=Add');

  $msg = "{$_REQUEST['name']} Class Type already exists in the database.
   Please choose another name";

  $sql="select * from class_type where name='{$_REQUEST['name']}'
    and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, "class_type.php?action=Edit&id={$_REQUEST['id']}",
      'Continue', $con);
    exit;
  }

  $sql = gen_update_sql('class_type', $_REQUEST['id'], array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));

}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {

  check($_REQUEST['name'], 'Please enter name for this Class Type',
    'class_type.php?action=Add');

  check($_REQUEST['description'],
    'Please enter a description', 'class_type.php?action=Add');

  $sql="select * from class_type where name='{$_REQUEST['name']}'
    and $extra_caution_sql";

  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
   echo msg_box("{$_REQUEST['name']} Class Type already exists in the database.
     Please choose another name", 'class_type.php?action=Add', 'Back');
    exit;
  }
  $sql = gen_insert_sql('class_type', array('school_id'), $con);
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_type_id = mysqli_insert_id($con);

  $sql="update class_type set school_id={$_SESSION['school_id']}
    where id={$class_type_id}";
  mysqli_query($con, $sql) or die(mysqli_error($con));


  $sql="insert into subject(name, class_type_id, school_id)
   value('Mathematics', '$class_type_id', '{$_SESSION['school_id']}'),
   ('English', '$class_type_id', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  if (isset($_REQUEST['REFERER']))
    my_redirect($_REQUEST['REFERER'], '');

} else if (isset($_REQUEST['action']) &&
  (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a Class type to Edit',
      'class_type.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from class_type where id=$id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';

  generate_form($_REQUEST['action'], 'class_type.php', $id, 'class_type',
    $row, $skip, $referer, " where school_id={$_SESSION['school_id']}", $con);    exit;
}

?>
<div class='class1'>
<?php
   if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
     echo "
      <a href='class_type.php?action=Add'>Add</a>|
      <a href='class_type.php?action=Print'>Print</a>";
   }
  ?>
  <h3 class='sstyle1' style='display:inline;'>Class Type</h3>
  </div>

  <?php
   $skip = array('id', 'school_id');

  $sql="describe class_type";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (in_array($field[0], $skip))
      continue;
    $cols[] = $field[0];
  }
  $sql="select * from class_type where school_id={$_SESSION['school_id']}";
  ?>
  <table class='tablesorter'>
  <?php
   gen_list('class_type', 'class_type.php', 'name', $cols, $skip, $sql, $con);
  ?>
  </table>
<?php
require_once "tablesorter_footer.inc";
main_footer();
?>
