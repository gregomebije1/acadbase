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

$user = array('Administrator','Proprietor','Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

$extra_caution_sql = "school_id={$_SESSION['school_id']}";

//Make sure that Session/Term/Class has been created and
//that the session variables representing them have been set
check_session_variables('non_academic.php', $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Non Academic', 'non_academic.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {

  check($_REQUEST['id'], 'Please choose a Non Academic Skill', 'non_academic.php', 'Back');

  echo msg_box("Deleting this Non Academic Setting will delete
   any Student academic record tired to this setting<br>
   Are you sure you want to delete " .
     REQUEST_value('non_academic', 'name', 'id', $_REQUEST['id'], $con)
     . " ?" , "non_academic.php?action=confirm_delete&id={$_REQUEST['id']}",
     'Continue to Delete');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

  check($_REQUEST['id'], 'Please choose a Non Academic Skill', 'non_academic.php', 'Back');

  $sql="select * from non_academic where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("Non Academic Skill does not exist in the database",
 	  'non_academic.php', 'Back');
    exit;
  }

  //Delete the non academic setting
  $sql="delete from non_academic where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  //Delete non academic settings from all students record
  $sql="delete from student_non_academic where non_academic_id={$_REQUEST['id']}
    and $extra_caution_sql";
  mysqli_query($con, $sql) or die(mysqli_error($con));
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['id'], 'Please choose a Non Academic Skill', 'non_academic.php', 'Back');

  check($_REQUEST['name'], 'Please enter a Non-Academic Skill', 'non_academic.php', 'Back');

  $msg = "{$_REQUEST['name']} Non Academic already exists in the database.
   Please choose another name";

  $sql="select * from non_academic where name='{$_REQUEST['name']}' and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, "class.php?action=Edit&id={$_REQUEST['id']}", 'Continue', $con);
    exit;
  }

  $sql = gen_update_sql('non_academic', $_REQUEST['id'], array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));

}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {

  check($_REQUEST['name'], 'Please enter a Non-Academic Skill', 'non_academic.php', 'Back');

  $sql = "select * from non_academic where
      name='{$_REQUEST['name']}' and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("There is already another Non Academic skill
	   with the same name<b>
       Please choose another Name", 'non_academic.php?action=Add', 'Back');
    exit;
  }
  $sql="insert into non_academic(name, school_id)
      values('{$_REQUEST['name']}', {$_SESSION['school_id']})";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));


} else if (isset($_REQUEST['action']) &&
  (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

   if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a Non-Academic Settings to Edit',
	  'non_academic.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from non_academic where id=$id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';
  generate_form($_REQUEST['action'], 'non_academic.php', $id, 'non_academic',
    $row, $skip, $referer, " where school_id={$_SESSION['school_id']}", $con);
  exit;
}

?>
<div class='class1'>
<?php
  if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
     echo "
      <a href='non_academic.php?action=Add'>Add</a>|
      <a href='non_academic.php?action=Print'>Print</a>";
  }
 ?>
 <h3 class='sstyle1' style='display:inline;'>Non Academic</h3>
</div>

<table class='tablesorter'>
 <thead>
  <tr>
   <th>Name</th>
  </tr>
 </thead>
 <tbody>

<?php
 $sql="select * from non_academic where $extra_caution_sql order by id";
 $result = mysqli_query($con, $sql) or die(mysqli_error($con));
 while ($row = mysqli_fetch_array($result)) {
  echo "
   <tr>
    <td><a href='non_academic.php?action=Edit&id={$row['id']}'>{$row['name']}</a></td>
   </tr>";
}
?>
 </tbody>
</table>
<?php
require_once "tablesorter_footer.inc";
main_footer();
?>
