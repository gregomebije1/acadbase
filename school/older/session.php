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
if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
 print_header('Session List', 'session.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a session", 'session.php', 'Back');
	  exit;
	}
	if ($_REQUEST['id'] == $_SESSION['session_id']) {
	  echo msg_box("Deletion denied<br>
	   You are currently logged in to the " . 
	   get_value('session', 'name', 'id', $_REQUEST['id'], $con) 
	   . " Session <br> Log out before deleting the session", 
	   'session.php', 'Back');
	  exit;
	}
	
	$sql="select * from term where 
	 session_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("Deletion denied<br>
	    There are terms still tired to this session<br>
		Delete those terms before you can delete this session", 
		'session.php', 'Back');
	  exit;
	}
	
	$sql="select * from student_subject where 
	 session_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("***WARNING***<br>
	    Deleting this session will delete all students academic
		and financial records still tired to this Session<br>
		Are you sure you want to delete " . 
	  get_value('session', 'name', 'id', $_REQUEST['id'], $con)
	  . " Session?", 
	  "session.php?action=confirm_delete&id={$_REQUEST['id']}", 
	  'Continue to Delete');
	  exit;
    } else {
	   echo msg_box("***WARNING***<br>
	   Are you sure you want to delete " . 
	   get_value('session', 'name', 'id', $_REQUEST['id'], $con)
	   . " Term?" , 
	   "session.php?action=confirm_delete&id={$_REQUEST['id']}", 
	   'Continue to Delete');
	   exit;
	}
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a sesion", 'session.php', 'Back');
	  exit;
	}
	$sql="select * from session where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("Session does not exist in the database", 'session.php', 'OK');
	  exit;
	}
	$sql="delete from session where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql="delete from student_subject where session_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql="delete from student_fee where session_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Session has been deleted", 'session.php', 'OK');
	exit;
  }
  
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Session')) {
    if (empty($_REQUEST['name']))  {
       echo msg_box('Please enter Session Name', 
        'session.php?action=Form', 'Back');
       exit;
    }
    if (empty($_REQUEST['begin_date']) || empty($_REQUEST['end_date']))  {
       echo msg_box('Please enter correct begin and/or end date', 
        'session.php?action=Form', 'Back');
       exit;
    }
	$sql="select * from session where name='{$_REQUEST['name']}'";
	$result = mysql_query($sql) or die(mysql_errror());
	$row = mysql_fetch_array($result);
	if ($row['id'] == $_SESSION['session_id']) {
	  echo msg_box("Change denied<br>
	   You are currently logged in to the " . 
	   get_value('session', 'name', 'id', $_REQUEST['id'], $con) 
	   . " Session <br> Log out before changing the session", 
	   'session.php', 'Back');
	  exit;
	}
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("There is already an existing session 
	   with the same name as '{$_REQUEST['name']}'<br>
	   Please choose another name", 'session.php', 'Back');
	  exit;
	}
    $sql="insert into session (name, begin_date, end_date)
      values('{$_REQUEST['name']}', '{$_REQUEST['begin_date']}',
      '{$_REQUEST['end_date']}')";
    mysql_query($sql) or die(mysql_error());
	$session_id = mysql_insert_id();
	
	$sql="insert into term(name, begin_date, end_date, session_id) 
	 values('First', '{$_REQUEST['begin_date']}', 
	   '{$_REQUEST['end_date']}', $session_id)";
	mysql_query($sql) or die(mysql_error());
	
	$sql="insert into term(name, begin_date, end_date, session_id) 
	 values('Second', '{$_REQUEST['begin_date']}', 
	   '{$_REQUEST['end_date']}', $session_id)";
	mysql_query($sql) or die(mysql_error());
	
	$sql="insert into term(name, begin_date, end_date, session_id) 
	 values('Third', '{$_REQUEST['begin_date']}', 
	   '{$_REQUEST['end_date']}', $session_id)";
	mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Successfully added", 'session.php', 'OK');
	exit;

  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Session')) {
	if (empty($_REQUEST['id'])) {
	  echo msg_box('Please choose a session', 'session.php', 'Back');
	}
	$sql="select * from session where name='{$_REQUEST['name']}'";
	$result = mysql_query($sql) or die(mysql_errror());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("There is already an existing session 
	   with the same name as '{$_REQUEST['name']}'<br>
	   Please choose another name", 'session.php', 'Back');
	  exit;
	}
	$sql="select * from session where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("There is no session with the name
	   '{$_REQUEST['name']}'", 'session.php','Back');
	  exit;
	}
	if ($_REQUEST['id'] == $_SESSION['session_id']) {
	  echo msg_box("Change denied<br>
	   You are currently logged in to the " . 
	   get_value('session', 'name', 'id', $_REQUEST['id'], $con) 
	   . " Session <br> Log out before changing the session", 
	   'session.php', 'Back');
	  exit;
	}
    $sql="update session set name='{$_REQUEST['name']}', 
     begin_date='{$_REQUEST['begin_date']}', end_date='{$_REQUEST['end_date']}'
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
    echo msg_box("Successfully changed", 'session.php', 'OK');
	exit;
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {
   if ($_REQUEST['action'] != 'Add') {
     if (!isset($_REQUEST['id'])) {
	   echo msg_box("Please choose a session", 'session.php', 'Back');
	   exit;
	  }
     
     $sql = "select name, begin_date, end_date from session 
      where id={$_REQUEST['id']}";
     $result = mysql_query($sql);
     $row = mysql_fetch_array($result);

     $name=$row['name'];
     $begin_date= $row['begin_date'];
     $end_date= $row['end_date'];
   } else {
     $name="";
     $begin_date = date('Y-m-d');
     $end_date = date('Y-m-d');
   } 
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Session</h3></td>
   </tr>
   <form action="session.php" method="post">
   <tr>
    <td>Session Name</td>
    <td>
     <input type="text" name="name" 
     value='<?php echo $name; ?>'></td>
   </tr>
   <tr><td>Begin Date</td><td><input type="text" name="begin_date"
     value='<?php echo $begin_date; ?>'></td></tr>
   <tr><td>End Date</td><td><input type="text" name="end_date"
     value='<?php echo $end_date; ?>'></td></tr>
   <tr>
    <td>
    <?php  
    if ($_REQUEST['action'] != 'View') {
      if($_REQUEST['action'] == 'Edit') { 
       echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
      }
      echo "<input name='action' type='submit' value='"; 
      echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
      echo " Session'>";
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
     echo "
    <td>
    <form name='form1' action='session.php' method='post'>
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
    <td colspan='7' style='text-align:center;'><h3>Session</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Name</th>
    <th>Begining Date</th>
    <th>Ending Date</th>
   </tr>
   <?
   $result = mysql_query("select * from session", $con);
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td><input type='radio' name='id' value='<?=$row['id']?>'></td>
     <td><?=$row['name']?></td>
     <td><?=$row['begin_date']?></td>
     <td><?=$row['end_date']?></td>
    </tr>
    <?
    }
    echo '</form></table>';
     main_footer();
}
?>
