<?php
session_start();
if (!isset($_SESSION['uid']))
  header('Location: index.php');

error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";
require_once "backup_restore.inc";
//require_once "accounting/acc.inc";

$con = connect();

$user = array('Administrator','Accounts', 'Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
  print_header('List of Fees', 'fee.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

//Make sure that Session/Term/Class has been created and
 //that the session variables representing them have been set
check_session_variables('fee.php', $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {

  check($_REQUEST['id'], 'Please choose a fee to delete', 'fee.php');

  echo msg_box("Are you sure want to delete this fee?<br>
    Deleting this fee, will delete all financial records<br>
    attached to this fee",
    "fee.php?action=confirm_delete&id={$_REQUEST['id']}", 'Continue');
    exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action']
  == 'confirm_delete')) {

  check($_REQUEST['id'], 'Please choose a fee to delete', 'fee.php');

  $sql="delete from fee where id={$_REQUEST['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="delete from fee_class where fee_id={$_REQUEST['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));


  //Backup into files, for changes made
  save_to_file($_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['term_id'], $_SESSION['class_id']);


} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Fee')) {

  check($_REQUEST['name'], 'Please enter a Fee Name', 'fee.php?action=Add');

  $sql = "select * from fee where name='{$_REQUEST['name']}'
    and school_id={$_SESSION['school_id']}";
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    echo msg_box('Error: A fee with the same name already exist<br>
       Please choose another fee', 'fee.php?action=add', 'Back');
    exit;
  }

  $sql="insert into fee (name, school_id) values('{$_REQUEST['name']}',
   {$_SESSION['school_id']})";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $fee_id = mysqli_insert_id($con);

  $sql="select * from class where school_id={$_SESSION['school_id']}";
  $result =  mysqli_query($con, $sql) or die(mysqli_error($con));
  while ($row = mysqli_fetch_array($result)) {
    $sql="insert into fee_class(fee_id, session_id, term_id, class_id, school_id, amount) values
       ($fee_id, {$_SESSION['session_id']}, {$_SESSION['term_id']}, {$row['id']}, {$_SESSION['school_id']}, '0')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }

  //Backup into files, for changes made
  save_to_file($_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['term_id'], $_SESSION['class_id']);

} else if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'Update Fee')) {

  check($_REQUEST['name'], 'Please enter fee Name', 'fee.php');

  check($_REQUEST['id'], 'Please choose a fee to edit', 'fee.php');

  $sql="update fee set name='{$_REQUEST['name']}' where id={$_REQUEST['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Backup into files, for changes made
  save_to_file($_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['term_id'], $_SESSION['class_id']);

} else if (isset($_REQUEST['action']) && (($_REQUEST['action'] == 'Add')
  || ($_REQUEST['action'] == 'Edit'))) {

  if (($_REQUEST['action'] == 'Edit') && empty($_REQUEST['id']))  {
     echo msg_box('Please choose a fee to edit/view',
      'fee.php', 'Back');
     exit;
  }

  $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

  $sql = "select name from fee where id=$id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  ?>
  <table>
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Fee</h3></td>
   </tr>
   <form action="fee.php" method="post">
   <tr>
    <td>Fee Name</td>
    <td>
     <input type="text" name="name" value='<?php echo $row['name']; ?>'></td>
   </tr>
   <tr>
    <td>
    <?php
      if($_REQUEST['action'] == 'Edit') {
       echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
      }
      echo "<input name='action' type='submit' value='";
      echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
      echo " Fee'>";
    ?>
    <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <?
  exit;
}
?>
<div class='class1'>
<?php
  if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
     echo "
      <a href='fee.php?action=Add'>Add</a>|
      <a href='fee.php?action=Print'>Print</a>";
   }
  ?>
  <h3 class='sstyle1' style='display:inline;'>Fee</h3>
  </div>
  <table class='tablesorter'>
   <thead>
    <th>Name</th>
   </thead>
   <tbody>

   <?php
   $sql="select * from fee where school_id={$_SESSION['school_id']}";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while ($row = mysqli_fetch_array($result))
     echo "<tr><td style='class2'>
       <a href='fee.php?action=Edit&id={$row['id']}'>
      {$row['name']}</a></td></tr>";
   ?>
   </tbody>
  </table>

 <?php include_once "tablesorter_footer.inc"; ?>
<?php main_footer(); ?>
