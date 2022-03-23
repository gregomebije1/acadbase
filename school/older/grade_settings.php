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

if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit; 
}  
if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
  print_header('Grade Settings', 'grade_settings.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Grade Settings')) {
    if (empty($_REQUEST['name']) || (!is_string($_REQUEST['name'])))  {
       echo msg_box('Please enter a correct Grade Name', 
        'grade_settings.php?action=Add', 'Back');
       exit;
    }
	if (!is_numeric($_REQUEST['low']))  {
       echo msg_box('Please enter a low range', 
        'grade_settings.php?action=Add', 'Back');
       exit;
    }
	if (!is_numeric($_REQUEST['high']))  {
       echo msg_box('Please enter a high range', 
        'grade_settings.php?action=Add', 'Back');
       exit;
    }
    $sql = "select * from grade_settings where name='{$_REQUEST['name']}'";
    if (mysql_num_rows(mysql_query($sql)) > 0) {
      echo msg_box('Error: A grade with the same name already exist<br>
       Please choose another Grade', 'exam_settings.php?action=add', 'Back');
      exit;
    }
    $sql="insert into grade_settings (name, low, high) 
	values('{$_REQUEST['name']}', '{$_REQUEST['low']}', '{$_REQUEST['high']}')";
    mysql_query($sql) or die(mysql_error());
	echo msg_box('Grade successfully added', 'grade_settings.php', 'Continue');
	exit;
  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Grade Settings')) {

	if (empty($_REQUEST['id']))  {
       echo msg_box('Please choose a Grade to edit', 
        'grade_settings.php', 'Back');
       exit;
    }
    if (empty($_REQUEST['name']) || (!is_string($_REQUEST['name'])))  {
       echo msg_box('Please enter a correct Grade Name', 
        "grade_settings.php?action=Edit&id={$_REQUEST['id']}", 'Back');
       exit;
    }
	if (empty($_REQUEST['low']) || (!is_numeric($_REQUEST['low'])))  {
       echo msg_box('Please enter a low range', 
        "grade_settings.php?action=Edit&id={$_REQUEST['id']}", 'Back');
       exit;
    }
	if (empty($_REQUEST['high']) || (!is_numeric($_REQUEST['high'])))  {
       echo msg_box('Please enter a high range', 
        "grade_settings.php?action=Edit&id={$_REQUEST['id']}", 'Back');
       exit;
    } 
    $sql="update grade_settings set name='{$_REQUEST['name']}',
	 low='{$_REQUEST['low']}', high='{$_REQUEST['high']}'
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
	echo msg_box('Grade successfully Updated', 'grade_settings.php', 'Continue');
    exit;
  } else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id']))  {
       echo msg_box('Please choose a Grade to delete', 
        'grade_settings.php', 'Back');
       exit;
    }
    echo msg_box("Are you sure want to delete this Grade?<br>", 
     "grade_settings.php?action=confirm_delete&id={$_REQUEST['id']}", 'Continue');
    exit;
  } else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 
    'confirm_delete')) {
    if (empty($_REQUEST['id']))  {
       echo msg_box('Please choose a Grade to delete', 
        'grade_settings.php', 'Back');
       exit;
    }
    $sql="delete from grade_settings where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
    echo msg_box("Grade Deleted", 'grade_settings.php', 'Continue');
	exit;
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {

    if (($_REQUEST['action'] != 'Add') && empty($_REQUEST['id']))  {
       echo msg_box('Please choose a Grade to Edit/View', 
        'grade_settings.php', 'Back');
       exit;
    }

   if (($_REQUEST['action'] != 'Add') && isset($_REQUEST['id'])){
     $sql = "select * from grade_settings where id={$_REQUEST['id']}";
     $result = mysql_query($sql) or die(mysql_error());
     $row = mysql_fetch_array($result);
     $name=$row['name'];
	 $low = $row['low'];
	 $high = $row['high'];
   } else {
     $name="";
	 $low = "";
	 $high = "";
   }
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Grade Settings</h3></td>
   </tr>
   <form action="grade_settings.php" method="post">
   <tr>
    <td>Grade</td>
    <td>&nbsp;&nbsp;
     <input type="text" name="name" size='3' maxlength='3'
	  value='<?php echo $name; ?>'></td>
   </tr>
   <tr>
    <td>Lowest Range</td>
    <td>&ge;
     <input type="text" name="low" size='3' maxlength='3' 
	  value='<?php echo $low; ?>'></td>
   </tr>
   <tr>
    <td>Highest Range</td>
    <td>&le;
     <input type="text" name="high" size='3' maxlength='3'
	  value='<?php echo $high; ?>'></td>
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
      echo " Grade Settings'>";
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
    <form name='form1' action='grade_settings.php' method='post'>
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
    <td colspan='9' style='text-align:center;'><h3>Grade Settings</h3>
	</td>
   </tr>
   <tr>
    <th>&nbsp;</th>
    <th>Name</th>
	<th>Lowest Range</th>
	<th>Highest Range</th>
   </tr>
   <?php
   $result = mysql_query("select * from grade_settings order by name") or die(mysql_error());
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td><input type='radio' name='id' value='<?=$row['id']?>'></td>
     <td><?=$row['name']?></td>
	 <td>&ge;<?=$row['low']?></td>
	 <td>&le;<?=$row['high']?></td>
    </tr>
    <?
    }
    echo '</form></table>';
    main_footer();
  }
?>
