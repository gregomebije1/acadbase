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
check_session_variables('grade_settings.php', $con);

if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
  print_header('Grade Settings', 'grade_settings.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {

   check($_POST['name'], 'Please enter a Grade Settings', "grade_settings.php", 'Back');

   check($_POST['low'], 'Please enter a low range', "grade_settings.php", 'Back');

   check($_POST['high'], 'Please enter a low range', "grade_settings.php", 'Back');

   $sql = "select * from grade_settings where name='{$_REQUEST['name']}'";
   if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
     echo msg_box('Error: A grade with the same name already exist<br>
       Please choose another Grade', 'exam_settings.php?action=add', 'Back');
     exit;
   }

   $sql="insert into grade_settings (name, low, high, school_id)
	values('{$_REQUEST['name']}', '{$_REQUEST['low']}', '{$_REQUEST['high']}', {$_SESSION['school_id']})";
   mysqli_query($con, $sql) or die(mysqli_error($con));

   echo msg_box('Grade successfully added', 'grade_settings.php', 'Continue');
   exit;

} else if (isset($_POST['action']) && ($_POST['action'] == 'Update')) {

  check($_POST['id'], 'Please choose a Grade Setting', "grade_settings.php?action=Edit&id={$_POST['id']}", 'Back');

  check($_POST['name'], 'Please enter a Grade Settings', "grade_settings.php?action=Edit&id={$_POST['id']}", 'Back');

  check($_POST['low'], 'Please enter a low range', "grade_settings.php?action=Edit&id={$_POST['id']}", 'Back');

  check($_POST['high'], 'Please enter a low range', "grade_settings.php?action=Edit&id={$_POST['id']}", 'Back');

  $sql="update grade_settings set name='{$_POST['name']}',
	 low='{$_POST['low']}', high='{$_POST['high']}'
     where id={$_POST['id']} and $extra_caution_sql";
    mysqli_query($con, $sql) or die(mysqli_error($con));

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  check($_REQUEST['id'], 'Please choose a Grade Setting', 'grade_settings.php', 'Back');

  echo msg_box("Are you sure want to delete this Grade?<br>",
     "grade_settings.php?action=confirm_delete&id={$_REQUEST['id']}", 'Continue');
  exit;

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

    check($_REQUEST['id'], 'Please choose a Grade Setting', 'grade_settings.php', 'Back');

    $sql="delete from grade_settings where id={$_REQUEST['id']} and $extra_caution_sql";
    mysqli_query($con, $sql) or die(mysqli_error($con));

} else if (isset($_REQUEST['action']) &&
  (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

   if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a Grade Settings to Edit',
	  'grade_settings.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from grade_settings where id=$id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';
  generate_form($_REQUEST['action'], 'grade_settings.php', $id, 'grade_settings',
    $row, $skip, $referer, " where school_id={$_SESSION['school_id']}", $con);
  exit;
 }
?>
<div class='class1'>
<?php
  if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
     echo "
      <a href='grade_settings.php?action=Add'>Add</a>|
      <a href='grade_settings.php?action=Print'>Print</a>";
  }
 ?>
 <h3 class='sstyle1' style='display:inline;'>Grade Settings</h3>
</div>

<table class='tablesorter'>
 <thead>
  <tr>
   <th>Name</th>
   <th>Lowest Range</th>
   <th>Highest Range</th>
  </tr>
 </thead>
 <tbody>

<?php
 $result = mysqli_query($con, "select * from grade_settings where $extra_caution_sql order by name") or die(mysqli_error($con));
 while($row = mysqli_fetch_array($result)) {
  echo "
    <tr>
     <td><a href='grade_settings.php?action=Edit&id={$row['id']}'>{$row['name']}</a></td>
	 <td>&ge;{$row['low']}</td>
	 <td>&le;{$row['high']}</td>
    </tr>";
 }
 ?>
  </tbody>
</table>
<?php
require_once "tablesorter_footer.inc";
main_footer();
?>
