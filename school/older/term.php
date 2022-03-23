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
  print_header('List of Terms', 'term.php', 'Back to Main Menu', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a term", 'term.php', 'Back');
	  exit;
	}
	if ($_REQUEST['id'] == $_SESSION['term_id']) {
	  echo msg_box("Deletion denied<br>
	   You are currently logged in to the " . 
	   get_value('term', 'name', 'id', $_REQUEST['id'], $con) 
	   . " Term <br> Log out before deleting the Term", 
	   'term.php', 'Back');
	  exit;
	}
	//Allow the admin to delete Term, but warn of the 
	//consequences
	$sql="select * from student_subject where 
	 term_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
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
	   //Will never reach here
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
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a Term", 'term.php', 'Back');
	  exit;
	}
	$sql="select * from term where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("Term does not exist in the database", 'term.php', 'OK');
	  exit;
	}
	$sql="delete from term where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql="delete from student_subject where term_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql="delete from student_fee where term_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Term has been deleted", 'term.php', 'OK');
	exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Term')) {
    if (empty($_REQUEST['name']))  {
       echo msg_box('Please enter Term Name', 
        'term.php?action=Add', 'Back');
       exit;
    }
	if (!is_numeric($_REQUEST['times_school_open'])) {
	  echo msg_box('Please enter a correct number 
	   for the number of times school has been open', 
	   'term.php?action=Add', 'Back');
	  exit;
	}
    if (empty($_REQUEST['begin_date']) || empty($_REQUEST['end_date']))  {
       echo msg_box('Please enter correct begin and/or end date', 
        'session.php?action=Add', 'Back');
       exit;
    }
    $sql="select * from term where name='{$_REQUEST['name']}' 
     and begin_date='{$_REQUEST['begin_date']}'
     and end_date ='{$_REQUEST['end_date']}'
     and session_id = '{$_REQUEST['session_id']}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      echo msg_box("This term already exist.", 
        'term.php?action=Add', 'Back');
      exit;
    }

    $sql="insert into term (name, begin_date, end_date, session_id, times_school_open)
      values('{$_REQUEST['name']}', '{$_REQUEST['begin_date']}',
      '{$_REQUEST['end_date']}', {$_REQUEST['session_id']}, 
	  '{$_REQUEST['times_school_open']}')";
    mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Term successfully entered", 'term.php','Back');
	exit;
  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Term')) {
	
	//Check make sure this is not the current term 
	
	if ($_REQUEST['id'] == $_SESSION['term_id']) {
	  echo msg_box("Change denied<br>
	   You are currently logged in to the " . 
	   get_value('term', 'name', 'id', $_REQUEST['id'], $con) 
	   . " Term <br> Log out before changing the term", 
	   'term.php', 'Back');
	  exit;
	}
	if (empty($_REQUEST['name']))  {
       echo msg_box('Please enter Term Name', 
        'term.php', 'Back');
       exit;
    }
	if (!is_numeric($_REQUEST['times_school_open'])) {
	  echo msg_box('Please enter a correct number 
	   for the number of times school has been open', 
	   'term.php', 'Back');
	  exit;
	}
	if (empty($_REQUEST['id']))  {
       echo msg_box('Please choose a term',
        'term.php', 'Back');
       exit;
    }
    $sql="update term set name='{$_REQUEST['name']}', 
     begin_date='{$_REQUEST['begin_date']}', end_date='{$_REQUEST['end_date']}', session_id={$_REQUEST['session_id']}, 
	 times_school_open='{$_REQUEST['times_school_open']}' 
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
    echo msg_box("Term successfully Updated", 'term.php','Back');
	exit;
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {
   if ($_REQUEST['action'] != 'Add') {
   
     if (!isset($_REQUEST['id'])) {
	   echo msg_box("Please choose a term", 'term.php', 'Back');
	   exit;
	  }
     $sql = "select * from term 
      where id={$_REQUEST['id']}";
     $result = mysql_query($sql);
     $row = mysql_fetch_array($result);

     $name=$row['name'];
     $begin_date= $row['begin_date'];
     $end_date= $row['end_date'];
     $session_id = $row['session_id'];
	 $times_school_open = $row['times_school_open'];
   } else {
     $name="";
     $begin_date = date('Y-m-d');
     $end_date = date('Y-m-d');
     $session_id = "";
	 $times_school_open = "";
   } 
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Term</h3></td>
   </tr>
   <form action="term.php" method="post">
   <tr>
    <td>Term Name</td>
    <td>
     <input type="text" name="name" 
     value='<?php echo $name; ?>'></td>
   </tr>
   <tr><td>Begin Date</td><td><input type="text" name="begin_date"
     value='<?php echo $begin_date; ?>'></td></tr>
   <tr><td>End Date</td><td><input type="text" name="end_date"
     value='<?php echo $end_date; ?>'></td></tr>
   <tr>
   <tr>
    <td>Session</td>
    <td>
     <!--Doesn't work for Editing/Viewing of data-->
     <select name='session_id'>
     <?php
     $sql = "select * from session";
     $result = mysql_query($sql);
     while ($row = mysql_fetch_array($result)) {
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
     </select>
    </td>
   </tr>
   <tr>
    <td>Times School Open</td>
    <td><input type="text" name="times_school_open" 
	 maxlength='2' size='2' value='<?php echo $times_school_open; ?>'></td>
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
      echo " Term'>";
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
    <form name='form1' action='term.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
	  <option value='Edit'>Edit</option>
      <option value='Add'>Add</option>
      <option value='View'>View</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
    </td>
    ";
    }
    ?>
    <td colspan='7' style='text-align:center;'><h3>Term</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Term</th>
    <th>Session</th>
    <th>Begining Date</th>
    <th>Ending Date</th>
	<th>Times School Open</th>
   </tr>
   <?
   $result = mysql_query("select t.id,t.name as term, t.begin_date, t.end_date, 
    t.times_school_open, s.name from term t join session s on t.session_id = s.id", $con);
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td><input type='radio' name='id' value='<?=$row['id']?>'></td>
     <td><?=$row['term']?></td>
     <td><?=$row['name']?></td>
     <td><?=$row['begin_date']?></td>
     <td><?=$row['end_date']?></td>
	 <td><?=$row['times_school_open']?></td>
    </tr>
    <?
    }
    echo '</form></table>';
     main_footer();
}
?>
