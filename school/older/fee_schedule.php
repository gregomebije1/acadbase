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
  print_header('Fee Schedule', 'fee_schedule.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) &&
   ($_REQUEST['action'] == 'Update Fee Schedule')) {
   
   if (!isset($_REQUEST['class_id'])) {
	  echo msg_box("Please choose a fee", 'fee_schedule.php', 'Back');
	  exit;
	}
	$sql="select * from fee_class where class_id = {$_REQUEST['class_id']}";
	//echo "$sql<br>";
	$result = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) { 
	  $amount = "amount_" . $row['id'];
	  $sql="update fee_class set amount='{$_REQUEST[$amount]}'
        where id={$row['id']} and class_id={$_REQUEST['class_id']}";
		//echo "$sql<br>";
	  mysql_query($sql) or die(mysql_error());
	}
    echo msg_box('Fee schedule successfully updated', 'fee_schedule.php', 
	 'Continue');
	exit;
  } else if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Edit')) {
    if (!isset($_REQUEST['class_id'])) {
	  echo msg_box("Please choose a class", 'fee_schedule.php', 'Back');
	  exit;
	}
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Fee</h3></td>
   </tr>
   <form action="fee_schedule.php" method="post">
   <tr>
    <td>Class</td>
    <td><input type='text' name='class' value='
    <?php
     echo get_value("class", "name", "id", $_REQUEST['class_id'], $con);
     echo "'>
       <input type='hidden' name='class_id' 
        value='{$_REQUEST['class_id']}'></td></tr>";
  
     $sql = "select f.name, fc.amount, fc.id from fee_class fc join fee f
      on f.id = fc.fee_id where fc.class_id={$_REQUEST['class_id']}";
     $result = mysql_query($sql) or die(mysql_error());
     while($row = mysql_fetch_array($result)) {
       echo "<tr>
        <td>{$row['name']}</td>
        <td>
         <input type='text' name='amount_{$row['id']}' value='{$row['amount']}'>
        </td>
       </tr>
       ";
     }
    ?>
   <tr>
    <td>
     <input name="action" type="submit" value="Update Fee Schedule">
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
    <form name='form1' action='fee_schedule.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
      <option value='Edit'>Edit</option>
      <option value='Print'>Print</option>
     </select>
    </td>
     ";
    }
   ?>
    <td colspan='7' style='text-align:center;'><h3>Fee Schedule</h3></td>
   </tr>
   <tr>
    <th>&nbsp;</th>
    <th>Class</th>
   <?
   $result = mysql_query("select * from fee order by id") or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     echo "<th>{$row['name']}</th>";
   }
   echo "</tr>";
   $sql="select * from class order by id";
   $result = mysql_query($sql);
   while($row = mysql_fetch_array($result)) {
     echo "<tr>
      <td><input type='radio' name='class_id' value='{$row['id']}'></td>
      <td>{$row['name']}</td>";

     $sql="select f.id, c.name, fc.amount from 
       fee_class fc join (fee f, class c) on 
       (fc.fee_id = f.id and fc.class_id = c.id)
	   where fc.class_id = {$row['id']} order by f.id";
   
     $result2 = mysql_query($sql);
     while ($row2 = mysql_fetch_array($result2)) {
       echo "<td>{$row2['amount']}</td>";
     }
     echo "</tr>";
   }
    echo '</form></table>';
    main_footer();
  }
?>
