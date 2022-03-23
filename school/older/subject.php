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
  || (user_type($_SESSION['uid'], 'Exams', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}  
  
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Subject List', 'subject.php', '', $con);
} else {
  main_menu($_SESSION['uid'], 
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
   if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a subjects", 'subject.php', 'Back');
	  exit;
	}
	$sql="select s.id from subject s join student_subject ss
	 on s.id = ss.subject_id where s.id={$_REQUEST['id']}";
	 
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
      echo msg_box("***WARNING***<br>
	    Deleting this subject will delete all students academic
		records still tired to this Subject<br>
		Are you sure you want to delete " . 
	  get_value('subject', 'name', 'id', $_REQUEST['id'], $con) . "?", 
	  "subject.php?action=confirm_delete&id={$_REQUEST['id']}", 
	 'Continue to Delete');
	 exit;
    } else {
	  echo msg_box("***WARNING***<br>
		Are you sure you want to delete " . 
	  get_value('subject', 'name', 'id', $_REQUEST['id'], $con) . "?", 
	  "subject.php?action=confirm_delete&id={$_REQUEST['id']}", 
	 'Continue to Delete');
	 exit;
	}
	exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a subject", 'subject.php', 'Back');
	  exit;
	}
	$sql="select * from subject where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("Subject does not exist in the database", 'subject.php', 'OK');
	  exit;
	}
	$sql="delete from subject where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	
	echo msg_box("Subject has been deleted", 'subject.php', 'OK');
	exit;
  }
  if (isset($_REQUEST['action']) && 
   ($_REQUEST['action'] == 'Add Subject')) {
    if(empty($_REQUEST['subject'])) {
      echo msg_box('Please enter a subject',
      'subject.php?action=Add','Back');
      exit;
    }
    $sql="SELECT * FROM subject WHERE name ='{$_REQUEST['subject']}' and 
      type = '{$_REQUEST['type']}'";
    $result = mysql_query($sql, $con);
    if(mysql_num_rows($result) > 0) {
      echo msg_box("This subject already exists", 
	    'subject.php?action=Add', 'Back');
	  exit;
    } else {
      $sql = "INSERT INTO subject (name, type)
       VALUES ('{$_REQUEST['subject']}', '{$_REQUEST['type']}')";
      mysql_query($sql, $con) or die(mysql_error());	  
      $subject_id = mysql_insert_id();

      //On adding a subject, we should make this subject available
      //to all students of this class type 
      //by adding it to the student_subject table
	  
	  echo msg_box("Successfully entered", 'subject.php', 'Back To Subjects');
	  exit;
    }
  } elseif (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add')) {
    ?>
    <table>
     <form action='subject.php' method='POST'>
     <tr class='class1'>
      <td colspan='3'><h3>Add Subjects</h3></td></tr>
     <tr>
      <td>Subject</td>
      <td><input type='text' name='subject' size='40'></td>
     </tr>
     <tr>
      <td>Class Type</td>
      <td>
       <select name='type'>
        <option value='jss'>JSS</option>
        <option value='sss'>SSS</option>
       </select>
      </td>
     </tr>
     <tr>
      <td>
       <input type='submit' name='action' value='Add Subject'>
       <input type='submit' name='action' value='Cancel'>
      </td>
     </tr>
     </form>
    </table>
    <?php 
    exit;
  } elseif (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if(empty($_REQUEST['sid'])) {
     echo msg_box('Please choose a subject to delete',
      'subject.php','Back');
     exit;
    }
    ?>
    <table> 
     <tr class='class1'>
      <td colspan='7'> 
      <?php
      //Have the preconditions necessary for the delete been safisfied?
      $sql = "delete from subject where id={$_REQUEST['sid']}";
      mysql_query($sql, $con);
      echo msg_box("Subject {$_REQUEST['sid']} has been deleted",
      'subject.php?action=ListForm','Back');
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
       <form name='form1' action='subject.php' method='post'>
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
       <td colspan='5' style='text-align:center;'><h3>List of Subjects</h3></td>
     </tr>
     <tr>
      <th colspan='2' style='text-align:center;'>Junior Secondary School</th>
    <th colspan='2' style='text-align:center;'>Senior Secondary School</th></tr>
     <tr>
      <td colspan='2' style='vertical-align:top;'>
      <?
      $result = mysql_query("select * from subject where type='jss'");
      echo "<table border='1'>";
      while($row = mysql_fetch_array($result)) {
        echo "<tr><td><input type='radio' name='id' value='{$row['id']}'>
           &nbsp;{$row['name']}</td></tr>";
      }
      echo "</table>";
      ?>
      </td>
      <td colspan='2' style='vertical-align:top;'>
      <?
      $result = mysql_query("select * from subject where type='sss'");
      echo "<table border='1'>"; 
      while($row = mysql_fetch_array($result)) {
        echo "<tr><td><input type='radio' name='id' value='{$row['id']}'>
           &nbsp;{$row['name']}</td></tr>";
      }
      echo "</table>";
      ?>
      </td>
      </tr>
      <? 
      echo "</form></table>"; 
      main_footer();
 }
?>
