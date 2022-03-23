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
 || user_type($_SESSION['uid'], 'Exams', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Non Academic', 'non_academic.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Non Academic Skill",
	  'non_academic.php', 'Back');
       exit;
    }
    echo msg_box("Are you sure you want to delete " . 
     get_value('non_academic', 'name', 'id', $_REQUEST['id'], $con)
     . " ?" , "non_academic.php?action=confirm_delete&id={$_REQUEST['id']}", 
     'Continue to Delete');
     exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Non Academic Skill", 'non_acadmic.php', 'Back');
      exit;
    }
    $sql="select * from non_academic where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("Non Academic Skill does not exist in the database",
 	  'non_academic.php', 'OK');
      exit;
    }
    $sql="delete from non_academic where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
	
    echo msg_box("Non Academic Skill has been deleted", 
	'non_academic.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Non Academic')) {
    if (empty($_REQUEST['name'])) {
      echo msg_box("Please fill out the form", 'non_academic.php?action=Add', 'Back');
      exit;
    }
    $sql = "select * from non_academic where 
      name='{$_REQUEST['name']}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      echo msg_box("There is already another Non Academic skill
	   with the same name<b>
       Please choose another Name", 'non_academic.php?action=Add', 'Back');
      exit;
    }
    $sql="insert into non_academic(name)
      values('{$_REQUEST['name']}')";
    $result = mysql_query($sql) or die(mysql_error());

    echo msg_box("{$_REQUEST['name']} successfully added", 
      'non_academic.php?action=Add', 'Back');
     exit;
 } elseif (isset($_REQUEST['action']) && 
     (($_REQUEST['action'] == 'Add') 
     || ($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View'))) {

   if ($_REQUEST['action'] != 'Add') {
     if (empty($_REQUEST['id'])) {
       echo msg_box("Please choose a Non Academic entry", 'non_academic.php', 'Back');
       exit;
     }
    }
    $id = empty($_REQUEST['id']) ? '0' : $_REQUEST['id'];
    $sql="select * from non_academic where id = $id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $av = array();

    $name =  $row['name'] ? $row['name'] : "";
    $av['name'] = $name;
    ?>
    <table> 
     <tr class='class1'>
      <td colspan='3'><h3><?php echo $_REQUEST['action']; ?> Non Academic</h3></td>
     </tr>
     <form name='form1' action="non_academic.php" method="post">
     <?php
     if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) {
         echo tr(array('Name', textfield('name', 'name','value',
           $name, 'readonly', 'readonly')));
         unset($av['name']);
     } 
      foreach($av as $name => $value) 
         echo tr(array($name, textfield('name', $name, 'value', $value)));
       unset($av); 
     echo "
    <tr>
     <td>
     ";
     if ($_REQUEST['action'] != 'View') {
       if($_REQUEST['action'] == 'Edit') { 
         echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
       }
       echo "<input name='action' type='submit' value='"; 
       echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
       echo " Non Academic'>";
     }
     ?>
     </td>
     <td><input name="action" type="submit" value="Cancel"></td>
     </form>
    </tr>
   </table>
   <?php
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
     <form name='form1' action='non_academic.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
      <option value='Add'>Add</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
     </td>
     ";
      }
    ?>
    <td colspan='5' style='text-align:center;'><h3>Non Academic</h3></td>
   </tr>
   <tr>
    <th style='width:1em;'></th>
    <th>Name</th>
   </tr>
   <?php
   $sql="select * from non_academic order by id";
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     echo "
   <tr>
    <td><input type='radio' name='id' value='{$row['id']}'></td>
    <td>{$row['name']}</td
   </tr>";
   }
   echo "</form></table>";
   main_footer();
  } 
?>
