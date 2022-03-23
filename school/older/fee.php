<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";

$con = connect();

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || user_type($_SESSION['uid'], 'Accounts', $con))) {
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
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Fee')) {
    if (empty($_REQUEST['name']) || (!is_string($_REQUEST['name'])))  {
       echo msg_box('Please enter a correct fee Name', 
        'fee.php?action=Add', 'Back');
       exit;
    }
    $sql = "select * from fee where name='{$_REQUEST['name']}'";
    if (mysql_num_rows(mysql_query($sql)) > 0) {
      echo msg_box('Error: A fee with the same name already exist<br>
       Please choose another fee', 'fee.php?action=add', 'Back');
      exit;
    }
    $sql="insert into fee (name) values('{$_REQUEST['name']}')";
    mysql_query($sql) or die(mysql_error());

    $fee_id = mysql_insert_id();
    $result =  mysql_query("select * from class") or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {
      $sql="insert into fee_class(fee_id, class_id, amount) values 
       ($fee_id, {$row['id']}, '0')";
      mysql_query($sql) or die(mysql_error());
    }
	echo msg_box('Fee successfully added', 'fee.php', 'Continue');
	exit;
  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Fee')) {

    if (empty($_REQUEST['name']) || (!is_string($_REQUEST['name'])))  {
       echo msg_box('Please enter a correct fee Name', 
        'fee.php', 'Back');
       exit;
    }
    if (empty($_REQUEST['id']))  {
       echo msg_box('Please choose a fee to edit', 
        'fee.php', 'Back');
       exit;
    }
    $sql="update fee set name='{$_REQUEST['name']}' 
     where id={$_REQUEST['id']}";
	
    mysql_query($sql) or die(mysql_error());
	echo msg_box('Fee successfully Updated', 'fee.php', 'Continue');
	exit;

  } else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    echo msg_box("Are you sure want to delete this fee?<br>", 
     "fee.php?action=confirm_delete&id={$_REQUEST['id']}", 'Continue');
    exit;
  } else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 
    'confirm_delete')) {

    $sql="delete from fee where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
	
	$sql="delete from fee_class where fee_id={$_REQUEST['id']}";
	mysql_query($sql) or die(mysql_error());
	
	echo msg_box('Fee Deleted', 'fee.php', 'Continue');
	exit;
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {

    if (($_REQUEST['action'] != 'Add') && empty($_REQUEST['id']))  {
       echo msg_box('Please choose a fee to edit/view', 
        'fee.php', 'Back');
       exit;
    }

   if (($_REQUEST['action'] != 'Add') && isset($_REQUEST['id'])){
     $sql = "select name from fee where id={$_REQUEST['id']}";
     $result = mysql_query($sql) or die(mysql_error());
     $row = mysql_fetch_array($result);
     $name=$row['name'];
   } else {
     $name="";
   }
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Fee</h3></td>
   </tr>
   <form action="fee.php" method="post">
   <tr>
    <td>Fee Name</td>
    <td>
     <input type="text" name="name" 
     value='<?php echo $name; ?>'></td>
   </tr>
   <tr>
    <td>
    <?php  
    if ($_REQUEST['action'] != 'View') {
      if($_REQUEST['action'] == 'Edit') { 
       echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
      }
      echo "<input name='action' type='submit' value='"; 
      echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
      echo " Fee'>";
    }
    ?>
    <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <?
  exit;
  } 
  if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Cancel')
   || ($_REQUEST['action'] == 'Print')) {
  ?>
  <table border='1'>
   <tr class='class1'>
   <?php 
   if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
      echo "<td></td>";
    } else {
      echo "<td>
    <form name='form1' action='fee.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
      <option value='Add'>Add</option>
      <option value='Edit'>Edit</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
    </td>
     ";
    }
   ?>
    <td colspan='7'><table align='center'><tr class='class1'><td><h3>Fee</h3></td></tr></table></td>
   </tr>
   <tr>
    <th style='width:1em;'>&nbsp;</th>
    <th colspan='7' style='width:7em;'>Name</th>
   </tr>
   <?php
   $result = mysql_query("select * from fee") or die(mysql_error());
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td><input type='radio' name='id' value='<?=$row['id']?>'></td>
     <td><?=$row['name']?></td>
    </tr>
    <?
    }
    echo '</form></table>';
    main_footer();
  }
?>
