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

$user = array('Administrator','Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
$extra_caution_sql="school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
 print_header('Session List', 'session.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  check($_REQUEST['id'], "Please choose a session", 'session.php');

  //Cannot delete the current session
  if ($_REQUEST['id'] == $_SESSION['session_id']) {
    echo msg_box("Deletion denied<br>
      You are currently logged in to the " .
      get_value('session', 'name', 'id', $_REQUEST['id'], $con)
      . " Session <br> Log out before deleting the session",
      'session.php', 'Back');
    exit;
  }

  //Check if Terms are still tied to this session
  $sql="select * from term where session_id={$_REQUEST['id']}
     and $extra_caution_sql";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   if (mysqli_num_rows($result) > 0) {
     echo msg_box("Deletion denied<br>
      There are terms still tired to this session<br>
      Delete those terms before you can delete this session",
     'session.php', 'Back');
    exit;
   }
    echo msg_box("***WARNING***<br>
	   Are you sure you want to delete " .
	   get_value('session', 'name', 'id', $_REQUEST['id'], $con)
	   . " Session?" ,
	   "session.php?action=confirm_delete&id={$_REQUEST['id']}",
	   'Continue to Delete');
	exit;
  }

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

  check($_REQUEST['id'], "Please choose a sesion", 'session.php');

  $sql="select * from session where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("Session does not exist in the database", 'session.php', 'OK');
    exit;
  }
  while($row = mysqli_fetch_array($result)) {
    //student_subject and the rest have been previously deleted when term was deleted
    $sql="delete from term where session_id={$row['id']}";
	mysqli_query($con, $sql) or die(mysqli_error($con));
  }
  $sql="delete from session where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="select * from class where $extra_caution_sql";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result)) {
    unlink("data/{$_SESSION['school_id']}/{$_REQUEST['id']}_{$row['id']}.sql");
  }
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {
  check($_REQUEST['name'], 'Please enter Session Name', 'session.php?action=Form');
  check($_REQUEST['begin_date'], 'Please enter Begin Date', 'session.php?action=Form');
  check($_REQUEST['begin_date'], 'Please enter End Date', 'session.php?action=Form');

  $sql="select * from session where name='{$_REQUEST['name']}' and $extra_caution_sql";
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    echo msg_box("There is already a session with the same name<br>
	 Please choose another name", 'session.php?action=Add', 'Back');
	exit;
  }
  $sql = gen_insert_sql('session',array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $session_id1 = mysqli_insert_id($con);

  $sql="update session set school_id={$_SESSION['school_id']} where id={$session_id1}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Close current session
  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

  $arr = array('First', 'Second', 'Third');
  foreach($arr as $term) {
    $sql="insert into term(name, begin_date, end_date, session_id, times_school_open, school_id) value
	  ('{$term}', '{$_POST['begin_date']}', '{$_POST['end_date']}', $session_id1, '0', '{$_SESSION['school_id']}')";
	mysqli_query($con, $sql) or die(mysqli_error($con));
	$term_id1 = mysqli_insert_id($con);

	//For each class create a dump
	$sql = "select * from class where school_id={$_SESSION['school_id']}";
    $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
    while($row3 = mysqli_fetch_array($result3)) {
	  $_SESSION['sessid'] = mt_rand();
	  $file_name = "data/{$_SESSION['school_id']}/{$session_id1}_{$row3['id']}.sql";
      open_session($_SESSION['sessid'], $file_name, $con);

	  $sql="insert into fee_class_{$_SESSION['sessid']}(session_id, term_id, class_id, school_id, amount) values
       ({$session_id1}, {$term_id1}, {$row3['id']}, {$_SESSION['school_id']}, '0')";
	  mysqli_query($con, $sql) or die(mysqli_error($con));

      save_session($_SESSION['sessid'], $_SESSION['school_id'], $session_id1, $row3['id'], $con);
	  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $session_id1, $row3['id'], $con);
    }
  }

  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_SESSION['school_id']}/{$_SESSION['session_id']}_{$_SESSION['class_id']}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);

  if (isset($_REQUEST['REFERER']))
    my_redirect($_REQUEST['REFERER'], ' ');

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['id'], 'Please choose a session', 'session.php');

  $sql="select * from session where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("There is no session with the name' {$_REQUEST['name']}'", 'session.php','Back');
	exit;
  }
  $sql="update session set name='{$_REQUEST['name']}',
    begin_date='{$_REQUEST['begin_date']}', end_date='{$_REQUEST['end_date']}'
     where id={$_REQUEST['id']} and $extra_caution_sql";
   mysqli_query($con, $sql) or die(mysqli_error($con));

} else if (isset($_REQUEST['action']) &&
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a session to edit', 'session.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from session where id=$id and $extra_caution_sql";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';
  generate_form($_REQUEST['action'],'session.php',$id,'session',$row,$skip, $referer, " where school_id={$_SESSION['school_id']}", $con);
  exit;

  }

?>
<div class='class1'>

<?php
//Must subscribe before user can Add and Print
if(isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print')
   || (!isset($_REQUEST['action']))) {
  echo "
    <a href='session.php?action=Add'>Add</a>|
    <a href='session.php?action=Print'>Print</a>";
}

?>
 <h3 class='sstyle1'>Session</h3>
</div>
<?php
$skip = array('id', 'school_id');

$sql="describe session";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($field = mysqli_fetch_array($result)) {
  if (in_array($field[0], $skip))
    continue;
   $cols[] = $field[0];
}
?>
<table class='tablesorter'>

<?php
 $sql="select * from session where school_id={$_SESSION['school_id']} order by id";

 gen_list('session', 'session.php', 'name', $cols, $skip, $sql, $con);
?>
 </table>
<?php
require_once "tablesorter_footer.inc";
main_footer(); ?>
