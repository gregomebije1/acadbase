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
  || (user_type($_SESSION['uid'], 'Exams', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {
   $sql = "select * from student where current_class_id = 
    {$_REQUEST['class_id']}";
    
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     //echo " {$row['firstname']} = {$_REQUEST["{$row['id']}_student_id"]}<br>";
     $sql = "select id, subject_id from student_subject where student_id={$row['id']}
      and subject_id={$_REQUEST['subject_id']} 
      and session_id={$_SESSION['session_id']}
      and term_id = {$_REQUEST['term_id']}
      and class_id = {$_REQUEST['class_id']}";
     $result1 = mysql_query($sql) or die(mysql_error());
     while($row1 = mysql_fetch_array($result1)) {
	     $sql="update student_subject set test = " . 
              $_REQUEST["{$row['id']}_{$row1['id']}_test"] . 
              ", exam = " . 
              $_REQUEST["{$row['id']}_{$row1['id']}_exam"] . 
             " where id= {$row1['id']}";
	    //echo "$sql";
	    mysql_query($sql) or die(mysql_error());
	}
   }
   echo msg_box('Successfully updated', 'enter_scores.php', 'Enter Scores');
   exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Proceed')) {
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a class", 'enter_scores.php', 'Back');
    exit;
  }
  if ($_REQUEST['subject_id'] == '0') {
    echo msg_box("Please choose a subject", 'enter_scores.php', 'Back');
    exit;
  }
  $sql="select * from student where current_class_id={$_REQUEST['class_id']}";
  $result = mysql_query($sql) or die('Cannot execute sql ' . mysql_error());
  echo "
  <table>
   <tr class='class1'>
    <td colspan='3'><h3>Enter Scores</h3></td>
   </tr>
   <tr>
    <td>
     <table style='width:100%;'>
      <tr>
      <td><b>Session:</b>".
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con)."</td>
       <td><b>Term</b>" 
       . get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
       <td><b>Class:</b> " .  
        get_value('class', 'name', 'id', $_REQUEST['class_id'], $con) . 
       "</td>
       <td><b>Subject</b> " . 
        get_value('subject', 'name', 'id', $_REQUEST['subject_id'], $con) . 
       "</td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>
     <table border='1' valign='top' style='table-layout:row; border-spacing:0em; 
       border-collapse:collapse; width:100%;'>
      <tr>
       <th>Student</th>
       <th>Test Scores</th>
       <th>Exam Scores</th>
      </tr>
   ";
   
   echo "
    <form action='enter_scores.php' method='post'>
    <input type='hidden' name='term_id' 
     value='{$_REQUEST['term_id']}'>
    <input type='hidden' name='subject_id' 
     value='{$_REQUEST['subject_id']}'>
    <input type='hidden' name='class_id' 
     value='{$_REQUEST['class_id']}'>
   ";
   
   while ($row = mysql_fetch_array($result)) {
     //Get the type of class
     $sqlx = "select type from class where id={$_REQUEST['class_id']}";
     $resultx = mysql_query($sqlx) or die(mysql_error());
     $rowx = mysql_fetch_array($resultx);

     //Get all the subjects of this type of class
     $sql="select * from subject where type='{$rowx['type']}'
	  and id={$_REQUEST['subject_id']}";
     $resulty = mysql_query($sql) or die(mysql_error());

     //Register the following subjects for this student
     while($rowy = mysql_fetch_array($resulty)) {
       //Make sure there are no subjects registered for this student for this

       $sql="select ss.id, sb.name, ss.test, ss.exam from subject sb join 
        (student_subject ss, student s) on 
        (s.id = ss.student_id and sb.id = ss.subject_id 
        and ss.session_id = {$_SESSION['session_id']})    
        where s.id = {$row['id']} 
        and ss.subject_id = {$rowy['id']} 
        and ss.term_id = {$_REQUEST['term_id']}
        and ss.class_id = {$_REQUEST['class_id']} order by sb.id";
       
       $result1 = mysql_query($sql);
	   
	   if (mysql_num_rows($result1) > 0) {
	     $row1 = mysql_fetch_array($result1);
	     $test_name = "{$row['id']}_{$row1['id']}_test";
		 $exam_name = "{$row['id']}_{$row1['id']}_exam";
		 $test_value = $row1['test'];
		 $exam_value = $row1['exam'];
	   } else {
	       
           $sql="insert into student_subject(session_id, term_id, class_id,
            student_id, subject_id, test, exam)
            values({$_SESSION['session_id']}, {$_REQUEST['term_id']}, {$_REQUEST['class_id']}, 
		    {$row['id']}, {$rowy['id']}, '0','0')";
		   //echo "$sql<br>";
		   mysql_query($sql) or die(mysql_error());
		   $id = mysql_insert_id();
		   
		   $test_name = "{$row['id']}_{$id}_test";
		   $exam_name = "{$row['id']}_{$id}_exam";
		   $test_value = 0;
		   $exam_value = 0;
	   }
       echo "
       <tr>
        <td>{$row['admission_number']}
           {$row['firstname']}
           {$row['lastname']}
        </td>
        <td><input type='text' name='$test_name' value='$test_value'></td>
        <td><input type='text' name='$exam_name' value='$exam_value'></td>
       </tr>";
	 }  
  } 
  echo "</table></td></tr>
   
    <tr>
     <td>
      <input type='submit' name='action' value='Submit'>
      <input type='submit' name='action' value='Cancel'>
     </td>
    </form>
    </tr>
    </table>";
	
   exit;
}
?> 
<table> 
 <tr class="class1">
  <td colspan='3'><h3>Enter Scores</h3></td>
 </tr>
 <form name='form1' action="enter_scores.php" method="post">
  <input type='hidden' name='uid' value='<?php echo $_SESSION['uid'];?>'>
 <tr>
   <?php
    $sql="select * from term where session_id={$_SESSION['session_id']}
	 order by id";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("No Term has been defined. 
        Please define a Term before entering scores", 
        'term.php', 'Add a Term');
        exit;
    } 
    $result2 = mysql_query("Select * from class order by name");
    if (mysql_num_rows($result2) <= 0) {
      echo msg_box("No Class has been defined. 
        Please define a Class before entering scores", 
        'class.php', 'Add a Class');
        exit;
    } 
    $result4 = mysql_query("select * from subject order by name");
    if (mysql_num_rows($result4) <= 0) {
      echo msg_box("No subject has been added. 
        Please add a Subject before you can enter scores", 
        'subject.php', 'Add a Subject');
        exit;
    } 
    ?>
    <td>Term</td>
    <td>
    <select name='term_id'>
    <?php 
    while ($row = mysql_fetch_array($result)) { 
      echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>Class</td>
  <td>
   <select name="class_id" onChange="get_subject();">
    <option value='0'></option>
   <?php
   $sql="select * from class";
   $result = mysql_query($sql);
   while($row1 = mysql_fetch_array($result)) {
     echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
   }
   ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>Subject</td>
  <td><div id="subjects"></div></td>
 <tr>
  <td>
   <input name='action' type='submit' value='Proceed'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<?php main_footer();  ?>
