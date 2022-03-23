<?php
session_start();
if (!isset($_SESSION['uid'])) {
  header('Location: index.php');
  exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";
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
  print_header('List of Terms', 'term.php', 'Back to Main Menu', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  check($_REQUEST['id'], "Please choose a term", 'term.php');

  if ($_REQUEST['id'] == $_SESSION['term_id']) {
    echo msg_box("Deletion denied<br>
      You are currently logged in to the " .
      get_value('term', 'name', 'id', $_REQUEST['id'], $con)
      . " Term <br> Log using a different session/term before deleting
      this Term", 'term.php', 'Back');
     exit;
  }

  //Allow the admin to delete Term, but warn of the
  //consequences
  $sql="select * from student_subject_{$_SESSION['sessid']} where term_id={$_REQUEST['id']}
    and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("***WARNING***<br>
      Deleting this term will delete all students academic
      and financial records still tired to this Term<br>
      Are you sure you want to delete " .
     get_value('term', 'name', 'id', $_REQUEST['id'], $con)
    . " Term?" ,
    "term.php?action=confirm_delete&id={$_REQUEST['id']}",
    'Continue to Delete');
   exit;
  } else {
    echo msg_box("***WARNING***<br>
      Are you sure you want to delete " .
      get_value('term', 'name', 'id', $_REQUEST['id'], $con)
     . " Term?" ,
     "term.php?action=confirm_delete&id={$_REQUEST['id']}",
     'Continue to Delete');
     exit;
  }
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  check($_REQUEST['id'], "Please choose a Term", 'term.php');

  $sql="select * from term where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("Term does not exist in the database", 'term.php', 'OK');
    exit;
  }

  $sql="delete from term where id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from fee_class_{$_SESSION['sessid']} where term_id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from student_subject_{$_SESSION['sessid']} where term_id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from student_comment_{$_SESSION['sessid']} where term_id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from student_non_academic_{$_SESSION['sessid']} where term_id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from student_fees_{$_SESSION['sessid']} where term_id={$_REQUEST['id']} and $extra_caution_sql";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Insert')) {
  check($_REQUEST['name'], 'Please enter Term Name', 'term.php?action=Add');
  /*
  if (!is_numeric($_REQUEST['times_school_open'])) {
    echo msg_box('Please enter a correct number
      for the number of times school has been open',
      'term.php?action=Add', 'Back');
    exit;
  }
  */
  check($_REQUEST['begin_date'],'Please enter Begin Date',
    'term.php?action=Add');

  check($_REQUEST['end_date'], 'Please enter End Date',
    'term.php?action=Add');

  $sql="select * from term where name='{$_REQUEST['name']}'
     and begin_date='{$_REQUEST['begin_date']}'
     and end_date ='{$_REQUEST['end_date']}'
     and session_id = '{$_REQUEST['session_id']}' and $extra_caution_sql";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("This term already exist.", 'term.php?action=Add', 'Back');
    exit;
  }

  $sql = gen_insert_sql('term',array('school_id'),$con);
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $id = mysqli_insert_id($con);

  $sql="update term set school_id={$_SESSION['school_id']} where id={$id}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  if (isset($_REQUEST['REFERER']))
    my_redirect($_REQUEST['REFERER'], '');

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['name'],'Please enter Term Name', 'term.php');

  /*
  if (!is_numeric($_REQUEST['times_school_open'])) {
    echo msg_box('Please enter a correct number
      for the number of times school has been open',
      'term.php', 'Back');
    exit;
  }
  */
  $sql="update term set name='{$_REQUEST['name']}',
    begin_date='{$_REQUEST['begin_date']}',
    end_date='{$_REQUEST['end_date']}', session_id={$_REQUEST['session_id']},
    times_school_open='{$_REQUEST['times_school_open']}'
    where id={$_REQUEST['id']}  and $extra_caution_sql";
  mysqli_query($con, $sql) or die(mysqli_error($con));

} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Edit')) {

  if (($_REQUEST['action'] == 'Edit') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a term to edit', 'term.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] == 'Edit') && isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
  else
    $id = 0;

  $result = mysqli_query($con, "select * from term where id=$id
   and $extra_caution_sql") or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);

  $skip = array("id", "school_id");
  $referer = isset($_REQUEST['REFERER']) ? $_REQUEST['REFERER'] : '';

  generate_form($_REQUEST['action'],'term.php',$id,'term',$row,$skip,
    $referer, " where school_id={$_SESSION['school_id']}",$con);
  exit;
}
?>
<div class='class1'>

<?php
if ($_SESSION['age'] > 0) {
  if(isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print')
   || (!isset($_REQUEST['action']))) {

  //The user must have subscribed
      echo "
      <a href='term.php?action=Print'>Print</a>";
  }
}
?>
 <h3 class='sstyle1'>Term</h3>
</div>
<table>

<?php
$skip = array('id', 'school_id');

$sql="describe term";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($field = mysqli_fetch_array($result)) {
  if (in_array($field[0], $skip))
    continue;
   $cols[] = $field[0];
}
?>
<table class='tablesorter'>

<?php
  $sql = "select * from term where school_id={$_SESSION['school_id']} order by id";
  gen_list('term', 'term.php', 'name', $cols, $skip, $sql, $con);
?>
</table>
<?php
 require_once "tablesorter_footer.inc";
 main_footer();
?>
