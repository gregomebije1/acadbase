<?
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
  || user_type($_SESSION['uid'], 'Accounts', $con)
  || user_type($_SESSION['uid'], 'Expenditure', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Type of Expenses','type_of_expenses.php','',$con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a type of expense", 'type_of_expenses.php', 'Back');
	  exit;
	}
	
	$sql="select * from expenses where 
	 type_of_expenses_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("Deletion denied<br>
	    There are expenses still tired to this type of expense<br>
		Delete those expenses before you can delete this type of expense", 
		'type_of_expenses.php', 'Back');
	  exit;
	}
	
	 echo msg_box("***WARNING***<br>
	   Are you sure you want to delete " . 
	   get_value('type_of_expenses', 'name', 'id', $_REQUEST['id'], $con)
	   . " Type of Expenses?" , 
	   "type_of_expenses.php?action=confirm_delete&id={$_REQUEST['id']}", 
	   'Continue to Delete');
	   exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a type of expense", 'type_of_expenses.php', 'Back');
	  exit;
	}
	$sql="select * from type_of_expenses where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("Type of Expenses does not exist in the database", 'type_of_expenses.php', 'OK');
	  exit;
	}
	$sql="delete from type_of_expenses where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Type of expense has been deleted", 'type_of_expenses.php', 'OK');
	exit;
  }
  
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Type Of Expenses')) {
    if (empty($_REQUEST['name']))  {
       echo msg_box('Please enter Type of Expense Name', 
        'type_of_expenses.php?action=Form', 'Back');
       exit;
    }
    
	$sql="select * from type_of_expenses where name='{$_REQUEST['name']}'";
	$result = mysql_query($sql) or die(mysql_errror());
	$row = mysql_fetch_array($result);
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("There is already an existing type of expense 
	   with the same name as '{$_REQUEST['name']}'<br>
	   Please choose another name", 'type_of_expenses.php', 'Back');
	  exit;
	}
    $sql="insert into type_of_expenses (name)
      values('{$_REQUEST['name']}')";
    //echo "$sql<br>";
    mysql_query($sql) or die(mysql_error());
	echo msg_box("Successfully added", 'type_of_expenses.php', 'OK');
	exit;

  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Type Of Expenses')) {
	if (empty($_REQUEST['id'])) {
	  echo msg_box('Please choose a Type of Expense', 'type_of_expenses.php', 'Back');
	}
	$sql="select * from type_of_expenses where name='{$_REQUEST['name']}'";
	$result = mysql_query($sql) or die(mysql_errror());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("There is already an existing type of expense
	   with the same name as '{$_REQUEST['name']}'<br>
	   Please choose another name", 'type_of_expenses.php', 'Back');
	  exit;
	}
	$sql="select * from type_of_expenses where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("There is no type of expense with the name
	   '{$_REQUEST['name']}'", 'type_of_expenses.php','Back');
	  exit;
	}
	$sql="update type_of_expenses set name='{$_REQUEST['name']}'
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
    echo msg_box("Successfully changed", 'type_of_expenses.php', 'OK');
	exit;
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {
   if ($_REQUEST['action'] != 'Add') {
     if (!isset($_REQUEST['id'])) {
	   echo msg_box("Please choose a type of expense", 'type_of_expenses.php', 'Back');
	   exit;
	  }
     
     $sql = "select name from type_of_expenses where id={$_REQUEST['id']}";
     $result = mysql_query($sql);
     $row = mysql_fetch_array($result);
     $name=$row['name'];
   } else {
     $name="";
   } 
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Type of Expenses</h3></td>
   </tr>
   <form action="type_of_expenses.php" method="post">
   <tr>
    <td>Name</td>
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
      echo " Type Of Expenses'>";
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
  <table>
   <tr class='class1'>
   <?php 
   if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
         echo "<td></td>";
   } else {
      echo "<td> 
   <form name='form1' action='type_of_expenses.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
      <option value='Add'>Add</option>
      <option value='View'>View</option>
      <option value='Edit'>Edit</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
    </td>
   ";
   }
   ?>
    <td colspan='7' style='text-align:center;'><h3>Type Of Expenses</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Name</th>
   </tr>
   <?
   $result = mysql_query("select * from type_of_expenses", $con);
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
