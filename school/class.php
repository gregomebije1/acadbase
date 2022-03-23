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

$user = array('Administrator','Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

$extra_caution_sql = "school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Class List', 'class.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  check_session_variables('class.php', $con);

  if ($_REQUEST['id'] == $_SESSION['class_id']) {
    msg_box("You cannot delete Current Class", 'class.php', 'Back');
	exit;
  }
  check($_REQUEST['id'], 'Please choose a class', 'class.php', 'Back');

  $msg = "Deletion denied<br>They are students currently
     allocated to this class";

  $sql="select c.id from class c join student s on c.id = s.class_id
    where c.id={$_REQUEST['id']} and c.$extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, $url, $back);
    exit;
  }
  $sql="select * from class where id={$_REQUEST['id']}";
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    echo msg_box("All Student's academic and financial records tied to this Class will be deleted<br>
      Are you sure you still want to delete " .
	  get_value('class', 'name', 'id', $_REQUEST['id'], $con) . "?",
	  "class.php?action=confirm_delete&id={$_REQUEST['id']}",
	 'Continue to Delete');
    exit;
  }
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {

  check_session_variables('class.php', $con);

  if ($_REQUEST['id'] == $_SESSION['class_id']) {
    msg_box("You cannot delete Current Class", 'class.php', 'Back');
	exit;
  }
  check($_REQUEST['id'], 'Please choose a class', 'class.php', 'Back');

  $msg = "Deletion denied<br>They are students currently
     allocated to this class";

  $sql="select c.id from class c join student s on c.id = s.class_id
    where c.id={$_REQUEST['id']} and c.$extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, $url, $back);
    exit;
  }
  $sql="select * from class where id={$_REQUEST['id']}";
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    $file_name = "data/{$_SESSION['school_id']}/{$_SESSION['session_id']}_{$_REQUEST['id']}.sql";
    unlink($file_name);

    $sql="delete from class where id={$_REQUEST['id']} and $extra_caution_sql";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  }
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['name'], 'Please enter Class Name', 'class.php?action=Add');

  $msg = "{$_REQUEST['name']} class already exists in the database.
   Please choose another name";

  $sql="select * from class where name='{$_REQUEST['name']}' and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box($msg, "class.php?action=Edit&id={$_REQUEST['id']}", 'Continue', $con);
    exit;
  }

  $sql = gen_update_sql('class', $_REQUEST['id'], array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));

}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {

  check($_REQUEST['name'],'Please enter Class Name', 'class.php?action=Add');

  $sql="select * from class where name='{$_REQUEST['name']}'
    and $extra_caution_sql";

  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    echo msg_box("{$_REQUEST['name']} class already exists in the database.
     Please choose another name", 'class.php?action=Add', 'Back');
    exit;
  }
  $sql = gen_insert_sql('class',array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_id1 = mysqli_insert_id($con);

  $sql="update class set school_id={$_SESSION['school_id']} where id={$class_id1}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $previous_sessid = $_SESSION['sessid'];
  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_SESSION['school_id']}/{$_SESSION['session_id']}_{$class_id1}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);

  $sql="insert into fee_class_{$_SESSION['sessid']}(session_id, term_id, class_id, school_id, amount) values
       ({$_SESSION['session_id']}, {$_SESSION['term_id']}, {$class_id1}, {$_SESSION['school_id']}, '0')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $class_id1, $con);
  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $class_id1, $con);

  $_SESSION['sessid'] = "$previous_sessid";

  if (isset($_REQUEST['REFERER']))
    my_redirect($_REQUEST['REFERER'], '');

} else if (isset($_REQUEST['action']) &&
  (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a class to Edit', 'class.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $sql = "select * from class where id=$id";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';
  generate_form($_REQUEST['action'],'class.php',$id,'class',$row,$skip,$referer, " where school_id={$_SESSION['school_id']}", $con);
  exit;
}

check_session_variables('class.php', $con);

?>
<div class='class1'>
<?php
   if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
     echo "
      <a href='class.php?action=Add'>Add</a>|
      <a href='class.php?action=Print'>Print</a>";
   }
  ?>
  <h3 class='sstyle1' style='display:inline;'>Class</h3>
  </div>

  <?php
   $skip = array('id', 'school_id');

  $sql="describe class";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (in_array($field[0], $skip))
      continue;
    $cols[] = $field[0];
  }
  $sql="select * from class where school_id={$_SESSION['school_id']} order by id";
  ?>
  <table class='tablesorter'>
  <?php
   gen_list('class', 'class.php', 'name', $cols, $skip, $sql, $con);
  ?>
  </table>

<?php
require_once "tablesorter_footer.inc";
main_footer();
?>
