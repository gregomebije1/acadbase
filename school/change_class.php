<?php
session_start();
if(!isset($_SESSION['uid'])) {
  header('Location: index.php');
  exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
require_once "util.inc";
require_once "school.inc";
require_once "backup_restore.inc";
$con = connect();

$user = array('Administrator','Proprietor','Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

$extra_caution_sql = " school_id={$_SESSION['school_id']}";

if (isset($_REQUEST['action']) && ($_POST['action'] == 'Change')) {

  check($_REQUEST['class_to'], 'Please choose a class to change to', 'change_class.php', 'Back');
  check($_REQUEST['class_to'], 'Please choose Student(s)', 'change_class.php', 'Back');

  //Close current session
  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

  //Log into session we are promoting students to
  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_SESSION['school_id']}/{$_REQUEST['session_id1']}_{$_REQUEST['class_to']}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);
  $data = explode("|", $_REQUEST['class_members']);

  $msg = "";
  foreach ($data as $student) {
    if (empty($student) || ($student == ' '))
	  continue;
	$sql = "select * from student where admission_number='{$student}' and school_id={$_SESSION['school_id']}";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result)) {
	  $sql="select * from student_temp_{$_SESSION['sessid']} where student_id={$row['id']} and class_id={$_REQUEST['class_to']}";
	  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0)
	    echo " {$row['admission_number']} {$row['firstname']} {$row['lastname']} already registered in " . get_value('session', 'name', 'id', $_REQUEST['session_id1'], $con) . " session<br>";
	  else {
	    $sql="insert into student_temp_{$_SESSION['sessid']} (student_id, class_id) values ({$row['id']}, {$_REQUEST['class_to']})";
		$msg .= "Inserting student with {$row['admission_number']} {$row['firstname']} {$row['lastname']}<br>";
        mysqli_query($con, $sql) or die(mysqli_error($con));
	  }
	}
  }

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_REQUEST['session_id1'], $_REQUEST['class_to'],$con);
  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_REQUEST['session_id1'], $_REQUEST['class_to'], $con);

  //Restore our previous environment
  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_SESSION['school_id']}/{$_SESSION['session_id']}_{$_SESSION['class_id']}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);

  echo msg_box('Student(s) successfully promoted/demoted ', 'student.php', 'Continue');
  echo $msg;
  exit;
}
?>
<form name='form1' id='form1' method='post' action='change_class.php'>
  <?php
    if (isset($_REQUEST['session_id1']))
      echo "<input type='hidden' name='session_id1' value='{$_REQUEST['session_id1']}'>";
	else {
	  echo msg_box("Encourntered a serious error", 'choose_session_to_promote_to.php', 'Back');
	  exit;
	}
  ?>
  <div style='width:100em; height:30em; border: #d6e8ff 0.1em solid;'>

  <div class='class1' style='position:absolute; top:0px; left:0px; width:85em; text-align:center; border: #d6e8ff 0.1em solid;'>
   <h3>Promote/Demote into <?php echo get_value('session', 'name', 'id', $_REQUEST['session_id1'], $con); ?></h3>
  </div>

  <div style='width:10em; position:absolute; top:50px; left:100px; border: solid black 0.0em;'>
    <p>From
    <select name='class_id1' onchange='get_students_with_size(15);'>
	 <option></option>
	<?php
     //Get List of all classes
	$sql="select * from class where {$extra_caution_sql} order by id";

     $result = mysqli_query($con, $sql) or die(mysqli_error($con));
     while($row = mysqli_fetch_array($result)) {
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
    </select>
	</p>
  </div>

  <div style='width:20em; height:15em; position:absolute; top:90px; left:100px;'>
    <div id='students'></div>
   </div>

   <div style='border: solid black 0.0em; width:7em; position:absolute; top:100px; left:400px;'>
	<table style='border: solid black 0.0em;'>
	<tr><td><a  name='add_to_class' id='add_to_class' onClick='add_student_to_class();'><img src='images/next.gif'></a></td></tr>
	<tr><td><a  name='remove_from_class' id='remove_from_class' onClick='remove_student_from_class();'><img src='images/prev.gif'></a></td></tr>
	</table>
   </div>


  <div id='students_container_to' style='width:10em; border: solid black 0.0em;
   position:absolute; top:50px; left:40em;'>
   <p>To
   <select name='class_to'>
   <?php
     //Get List of all classes
     $result = mysqli_query($con, "select * from class where {$extra_caution_sql} order by id") or die(mysqli_error($con));
     while($row = mysqli_fetch_array($result)) {
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
   </select>
   </p>
  </div>

   <div style='width:15em; height: 15em; position:absolute; top:90px; left:40em;'>
    <select size='12' style='border solid black 0.0em;' id='sclass' name='sclass'>
    </select>
   </div>

   <div style='position:absolute; top:250px; left:400px; border: solid black 0.0em;
    width:20em;'>
    <input type='hidden' name='class_members'>
    <input type='submit' name='action' value='Change'>
   </div>
  <div>
  </form>
<?
 main_footer();
?>
