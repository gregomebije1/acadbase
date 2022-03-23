<?php
session_start();
if(!isset($_SESSION['uid'])) {
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

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) && (
  ($_REQUEST['action'] == 'Transfer') || ($_REQUEST['action'] == 'Promote/Repeat'))) { 

   //Input Validation:
   //You cannot transfer an empty set of students or promote/transfer to
   //a non-existent class
   if (empty($_REQUEST['class_to'])) {
     echo msg_box("Please choose a class to promote/transfer to", 
	   'promote.php', 'Back');
	 exit;
   }
   if (empty($_REQUEST['class_members'])) {
      echo msg_box("Please choose a class to promote/transfer to", 
	   'promote.php', 'Back');
	 exit;
   }
   $new_type = get_value('class', 'type', 'id', $_REQUEST['class_to'], $con);
   $data = explode("|", $_REQUEST['class_members']);
   $userData = array();
   $old_class_id = "";
   
   foreach ($data as $student) {
     //Input Validation: You cannot promote/transfer to the
	 //same class
	 $sql="select * from student where id=$student";
	 $result = mysql_query($sql) or die(mysql_error());
	 $row = mysql_fetch_array($result);
	 $old_class_id = $row['current_class_id'];
	 $old_type = get_value('class', 'type', 'id', $old_class_id, $con);
	 
	 //You cannot promote/transfer student to the same class
	 if ($old_class_id == $_REQUEST['class_to']) {
	   echo msg_box("You cannot promote/transfer student to
	     the same class", 'promote.php', 'Back');
	   exit;
	 }
	  
     //If you are transfering the student, you transfer his records
	 //from the old class to the new one
	 if ($_REQUEST['action'] == 'Transfer') {
	   //You cannot transfer from JSS to SSS or vice-versa
	   //use promote for that purpose
	   if ($new_type != $old_type) {
	     echo msg_box("You cannot tranfer from $old_type to $new_type<br>
		  Use promote instead", 
		   'promote.php', 'Back');
		 exit;
	   } else {
	     //Change student's class to the new class
	    $sql = "update student set current_class_id={$_REQUEST['class_to']}
          where id=$student";
        mysql_query($sql) or die(mysql_query());
     
	    $sql="update student_subject set class_id={$_REQUEST['class_to']}
	      where session_id={$_SESSION['session_id']} and term_id={$_SESSION['term_id']}
	      and student_id=$student and class_id=$old_class_id";
	    mysql_query($sql) or die(mysql_query());
	   }
	 } else if ($_REQUEST['action'] == 'Promote/Repeat') {
	   if ($new_type == $old_type) {
	     echo msg_box("You cannot promote from one $old_type class to another $new_type class<br>
		  Use Transfer instead", 
		   'promote.php', 'Back');
		 exit;
	   } else {
	     //Change student's class to the new class
	     $sql = "update student set current_class_id={$_REQUEST['class_to']}
          where id=$student";
         mysql_query($sql) or die(mysql_query());
	     //Check if any academic record concerning this student for this new class already exist
	     //A better way to check this, is to delete any previous academic record (subject) concerning
	     //this student for this new class. 
	     $sql="select * from subject where type='$old_type'";
		 $result2 = mysql_query($sql) or die(mysql_error());
	     while($row2 = mysql_fetch_array($result2)) {
	       $sql="delete from student_subject 
	        where session_id={$_SESSION['session_id']} and term_id={$_SESSION['term_id']}
		    and class_id=$old_class_id and student_id=$student 
		    and subject_id = {$row2['id']}";
		   $result4 = mysql_query($sql) or die(mysql_error());
	     }
	    //Get all subjects for this new class.
	    //Simple way to do this is check the type of the subject
	     //This is inefficient
         $sql="select * from subject where type='$new_type'";
         $result3 = mysql_query($sql) or die(mysql_error());
	     while($row3 = mysql_fetch_array($result3)) {
	       //Construct insert statement to register this subject for this new 
		   //class for this student.
		   //This is efficent because you dont do database query in a loop
		   //till you are out of it
           $userData[] = "({$_SESSION['session_id']}, {$_SESSION['term_id']}, 
	       {$_REQUEST['class_to']}, $student, {$row3['id']}, '0', '0')";
		   //print_r($userData);
		   //echo "<br>";
		}
	   }
	 }  
   }
   if (!empty($userData)) {
   $sql="insert into student_subject(session_id, term_id, class_id, 
         student_id, subject_id, test, exam)
        values" . implode(',', $userData);	
    mysql_query($sql) or die(mysql_error());
	 //echo "$sql<br>";
   }
   echo msg_box('Student(s) have been successfully promoted/transfered', 
    'promote.php', 'Continue');
   exit;
}
?>
  <div style='width:100em; height:30em; border: #d6e8ff 0.1em solid;'>
  <form name='form1' id='form1' method='post' action='promote.php'>
  <div class='class1'>
   <h3>Promotion/Transfer of Students</h3>
  </div>

  <div style='width:10em; position:absolute; top:40px; left:0px; border: solid black 0.0em;'>
    <p>From
    <select name='class_id' onchange='get_students_with_size(10);'>
	 <option></option>
	<?php 
     //Get List of all classes
     $result = mysql_query("select * from class order by id") or die(mysql_error());
     while($row = mysql_fetch_array($result)) { 
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
    </select>
	</p>
  </div>
  
  <div style='width:15em; height:17em;
  position:absolute; top:70px; left:0px; border: solid black 0.0em;'>
    <div id='students'></div>
   </div>
   
  <div id='students_container_to' style='width:10em; border: solid black 0.0em; 
   position:absolute; top:40px; left:40em;'>
   <p>To
   <select name='class_to'>
   <?php 
     //Get List of all classes
     $result = mysql_query("select * from class") or die(mysql_error());
     while($row = mysql_fetch_array($result)) { 
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
   </select>
   </p>
  </div>
  
  <div style='border: solid black 0.0em; width:7em; position:absolute; top:100px; left:350px;'>
    <!--<input type='button' name='add_to_class' id='add_to_class' 
     value='  add   ' onClick='add_student_to_class();'>-->
	<table style='border: solid black 0.0em;'>
	<tr><td><a  name='add_to_class' id='add_to_class' onClick='add_student_to_class();'><img src='images/next.gif'></a></td></tr>
	<!--
    <input type='button' name='remove_from_class' 
     value='remove' id='remove_from_class' 
     onClick='remove_student_from_class();'>-->
	 <tr><td><a  name='remove_from_class' id='remove_from_class' onClick='remove_student_from_class();'><img src='images/prev.gif'></a></td></tr>
	</table>
   </div>

   <div style='width:10em; position:absolute; top:70px; left:40em; border: solid black 0.0em;'>
    <select size='10' id='sclass' name='sclass'>
    </select>
   </div>
   
   <div style='position:absolute; top:250px; left:250px; border: solid black 0.0em;
    width:20em;'>
    <input type='hidden' name='class_members'>
    <input type='submit' name='action' value='Promote/Repeat'>
	<input type='submit' name='action' value='Transfer'>
   </div>
  </form>
  <div>
<?
 main_footer();
?>
