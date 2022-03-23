<?php
session_start();

if (!isset($_SESSION['uid'])) {
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

$extra_caution_sql = "class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";

//Make sure that Session/Term/Class has been created and
//that the session variables representing them have been set
check_session_variables('enter_scores.php', $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  $sql = "select * from student s join student_temp_{$_SESSION['sessid']} st on s.id = st.student_id
   where st.class_id={$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']}";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while ($row = mysqli_fetch_array($result)) {

     $sql = "select id, subject_id from student_subject_{$_SESSION['sessid']}
        where admission_number ={$row['admission_number']}
      and subject_id={$_POST['subject_id']}
      and session_id={$_SESSION['session_id']}
      and term_id = {$_SESSION['term_id']}
      and $extra_caution_sql";
	 $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));

     while($row1 = mysqli_fetch_array($result1)) {

	   if(((!empty($_REQUEST["{$row['admission_number']}_{$row1['id']}_test"]))
	       && (!is_numeric($_REQUEST["{$row['admission_number']}_{$row1['id']}_test"])))
	     || ((!empty($_REQUEST["{$row['admission_number']}_{$row1['id']}_exam"]))
		   && (!is_numeric($_REQUEST["{$row['admission_number']}_{$row1['id']}_exam"])))) {
	     echo msg_box("Please enter numeric values", "enter_scores.php?action=Submit&subject_name={$_POST['subject_name']}", 'Back');
         exit;
       }

       $test = $_REQUEST["{$row['admission_number']}_{$row1['id']}_test"];
       $exam = $_REQUEST["{$row['admission_number']}_{$row1['id']}_exam"];

	   //If test or exam fields are blank, then make the User take a decision
	   if (empty($test) || empty($exam)) {
	     echo msg_box("One of Test and Exam fields are blank<br>
		 If a Student will no longer be offering this Subject, leave both Test and Exam fields blank<br>
		 Or Enter a score for the blank field", "enter_scores.php?action=Submit&subject_name={$_POST['subject_name']}", 'Back');
		 exit;
	   }
       //If test and exam fields are blank, then deregister this Student
       //from this course
       if (empty($test) && empty($exam)) {
         $sql="delete from student_subject_{$_SESSION['sessid']} where id={$row1['id']} and $extra_caution_sql";
       } else {
	     if ((!is_numeric($test)) || (!is_numeric($exam))) {
           echo msg_box("Please enter numeric values", "enter_scores.php?action=Submit&subject_name={$_POST['subject_name']}", 'Back');
           exit;
         }

	     if (((($test/30) * 100) > 100) || ((($exam/70) * 100) > 100)) {
	       $sql="select * from subject where id={$_REQUEST['subject_id']}";
	       $result_subject = mysqli_query($con, $sql) or die(mysqli_error($con));
           $row_subject = mysqli_fetch_array($result_subject);

	       echo msg_box("Please check your scores <br> Test scores must be <= 30% and exam scores <= 70%", "enter_scores.php?action=Submit&subject_name={$row_subject['name']}", 'Back');
		   exit;
	     }
	     $sql="update student_subject_{$_SESSION['sessid']} set test=$test, exam=$exam  where id= {$row1['id']} and $extra_caution_sql";
       }
       mysqli_query($con, $sql) or die(mysqli_error($con));
     }
   }
   save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

   echo msg_box('Successfully updated', 'enter_scores.php', 'Enter Scores');
   exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {

  check($_REQUEST['subject_name'],
   'Please choose a subject', 'enter_scores.php', 'Back');


  $subject_id = get_subject_id($_REQUEST['subject_name'], $_SESSION['class_id'], $_SESSION['school_id'], $con);
  if ($subject_id == 0) {
    echo msg_box("Please enter a correct subject for this Class", 'enter_scores.php', 'Back');
	exit;
  }

  $sql="select * from student s join student_temp_{$_SESSION['sessid']} st on s.id = st.student_id
  where st.class_id={$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']} order by admission_number";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("No Student exist for this Class", 'enter_scores.php', 'Bank');
    exit;
  }

   //Make sure subjects have been registered for this class
  $sql="select * from class c join subject s
   on c.class_type_id = s.class_type_id
   where c.id={$_SESSION['class_id']} and c.school_id={$_SESSION['school_id']}";

  if(mysqli_num_rows(mysqli_query($con, $sql)) <=0) {
    echo msg_box("No Subject has been registered for this class",
      'subject.php', 'Continue to Subject Module');
    exit;
  }

  echo "
  <table>
   <tr class='class1'>
    <td><h3 class='sstyle1'>Enter Scores for {$_REQUEST['subject_name']}</h3></td>
   </tr>
   <tr>
    <td colspan='3' class='message'>
     Please leave Test and Exam scores field blank
     if any Student will not be offering this course.</td>
   </tr>

   <tr>
    <td>
     <table valign='top' style='table-layout:row; border-spacing:0em;
       border-collapse:collapse; width:100%; border:1px solid #ebf3ff;'>
      <tr>
       <th>Student</th>
       <th>Test Scores</th>
       <th>Exam Scores</th>
      </tr>
    <form action='enter_scores.php' method='post'>
   ";
   while ($row = mysqli_fetch_array($result)) {
     $sql="select * from student_subject_{$_SESSION['sessid']} where
        session_id = {$_SESSION['session_id']}
        and admission_number = {$row['admission_number']}
        and subject_id = $subject_id
        and term_id = {$_SESSION['term_id']}
	and $extra_caution_sql";

     $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
     if (mysqli_num_rows($result1) > 0) {
	   //If there is a record of student scores for this subject
	   //then display it

       $row1 = mysqli_fetch_array($result1);
       $test_name = "{$row['admission_number']}_{$row1['id']}_test";
       $exam_name = "{$row['admission_number']}_{$row1['id']}_exam";
       $test_value = $row1['test'];
       $exam_value = $row1['exam'];
     } else {
	   //There is no record for this student for this subject
	   //therefore create a new empty record that contains NULL values for test and exam
	   //Since they are NULL values, when 'Update' is clicked, and these scores for
	   //these Student's remain empty, then 'Update' procedure will delete them from
	   //the database
       $sql="insert into student_subject_{$_SESSION['sessid']}(session_id, term_id, class_id,
         admission_number, subject_id, school_id)
         values({$_SESSION['session_id']}, {$_SESSION['term_id']},
           {$_SESSION['class_id']}, '{$row['admission_number']}',
         $subject_id, {$_SESSION['school_id']})";

       mysqli_query($con, $sql) or die(mysqli_error($con));
       $id = mysqli_insert_id($con);

       $test_name = "{$row['admission_number']}_{$id}_test";
       $exam_name = "{$row['admission_number']}_{$id}_exam";
       $test_value = '';
       $exam_value = '';
     }
     echo "
       <tr style='border:1px solid #ebf3ff;'>
        <td>{$row['admission_number']}
           {$row['firstname']}
           {$row['lastname']}
        </td>
        <td><input type='text' name='$test_name' value='$test_value'></td>
        <td><input type='text' name='$exam_name' value='$exam_value'></td>

       </tr>";
   }
   echo "</table></td></tr>
    <tr>
     <td style='text-align:center;'>
      <input type='submit' name='action' value='Update'>
      </td>
	 <input type='hidden' name='subject_name' value='{$_REQUEST['subject_name']}'/>
      <input type='hidden' name='subject_id' value='$subject_id'/>
    </form>
    </tr>
    </table>";
   exit;
}
/*** Check to see if any subjects have been registered for this Class ***/
$class_type_id = get_value('class', 'class_type_id', 'id', $_SESSION['class_id'], $con);
$sql = "select * from subject where school_id={$_SESSION['school_id']} and class_type_id='$class_type_id' order by name";

$result4 = mysqli_query($con, $sql) or die(mysqli_error($con));
if (mysqli_num_rows($result4) <= 0) {
 echo msg_box("No subject has been added for this Class. Please add a Subject before you can enter scores", 'subject.php', 'Add a Subject');
 exit;
}

require_once "choose_subject_ui.php";
choose_subject_ui("Enter Scores", "enter_scores.php", $con);

main_footer();  ?>
