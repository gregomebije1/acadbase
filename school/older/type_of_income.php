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
  || user_type($_SESSION['uid'], 'Accounts', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Type of Income','type_of_income.php','Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a type of income", 
      'type_of_expenses.php', 'Back');
    exit;
  }
  $sql="select * from income where 
    type_of_income_id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) > 0) {
    echo msg_box("Deletion denied<br>
     There are income still tired to this type of income<br>
     Delete those income before you can delete this type of income", 
     'type_of_income.php', 'Back');
    exit;
  }
  echo msg_box("***WARNING***<br>
   Are you sure you want to delete " . 
   get_value('type_of_income', 'name', 'id', $_REQUEST['id'], $con)
   . " Type of Income?" , 
   "type_of_income.php?action=confirm_delete&id={$_REQUEST['id']}", 
   'Continue to Delete');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  if (empty($_REQUEST['id'])) {
   echo msg_box("Please choose a type of income", 'type_of_income.php', 'Back');
   exit;
  }
  $sql="select * from type_of_income where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("This type of income does not exist in the database",
     'type_of_income.php', 'OK');
    exit;
  }
  $sql="delete from type_of_income where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  
  echo msg_box("Type of income has been deleted", 'type_of_income.php', 'OK');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action']=='Add Type Of Income')) {
  if (empty($_REQUEST['name']))  {
    echo msg_box('Please enter Type of Income Name', 
      'type_of_income.php?action=Form', 'Back');
    exit;
  }
  $sql="select * from type_of_income where name='{$_REQUEST['name']}'";
  $result = mysql_query($sql) or die(mysql_errror());
  $row = mysql_fetch_array($result);
  if (mysql_num_rows($result) > 0) {
    echo msg_box("There is already an existing type of income 
     with the same name as '{$_REQUEST['name']}'<br>
     Please choose another name", 'type_of_income.php', 'Back');
    exit;
  }
  $sql="insert into type_of_income (name) values('{$_REQUEST['name']}')";
  mysql_query($sql) or die(mysql_error());
  echo msg_box("Successfully added", 'type_of_income.php', 'OK');
  exit;
} else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Type Of Income')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box('Please choose a Type of Income','type_of_income.php', 'Back');
  }
  $sql="select * from type_of_income where name='{$_REQUEST['name']}'";
  $result = mysql_query($sql) or die(mysql_errror());
  if (mysql_num_rows($result) > 0) {
    echo msg_box("There is already an existing type of income 
     with the same name as '{$_REQUEST['name']}'<br>
     Please choose another name", 'type_of_income.php', 'Back');
    exit;
  }
  $sql="select * from type_of_income where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("There is no type of income with the name
     '{$_REQUEST['name']}'", 'type_of_expenses.php','Back');
    exit;
  }
  $sql="update type_of_income set name='{$_REQUEST['name']}'
    where id={$_REQUEST['id']}";
  mysql_query($sql) or die(mysql_error());
  echo msg_box("Successfully changed", 'type_of_income.php', 'OK');
  exit;
} else if (isset($_REQUEST['action']) && 
  (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
   ($_REQUEST['action'] == 'View'))) {
  if ($_REQUEST['action'] != 'Add') {
    if (!isset($_REQUEST['id'])) {
     echo msg_box("Please choose a type of income", 
      'type_of_expenses.php', 'Back');
     exit;
    }
    $sql = "select name from type_of_income where id={$_REQUEST['id']}";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $name=$row['name'];
  } else {
    $name="";
  } 
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4">
     <h3><?php echo $_REQUEST['action'];?> Type of Income</h3></td>
   </tr>
   <form action="type_of_income.php" method="post">
   <tr>
    <td>Name</td>
    <td>
     <input type="text" name="name" value='<?php echo $name; ?>'></td>
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
      echo " Type Of Income'>";
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
    <form name='form1' action='type_of_income.php' method='post'>
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
    <td colspan='7' style='text-align:center;'><h3>Type Of Income</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Name</th>
   </tr>
   <?
   $result = mysql_query("select * from type_of_income", $con);
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
