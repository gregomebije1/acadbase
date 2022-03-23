<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
require_once "util.inc";
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
check_session_variables('enter_comment.php', $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  $sql = "select * from student s join student_temp_{$_SESSION['sessid']} st
    on s.id = st.student_id where st.class_id={$_SESSION['class_id']}
	and s.school_id={$_SESSION['school_id']}";

   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while ($row = mysqli_fetch_array($result)) {
     $sql="select * from student_comment_{$_SESSION['sessid']}
       where admission_number = {$row['admission_number']}
       and session_id = {$_SESSION['session_id']}
       and term_id = {$_SESSION['term_id']}
       and class_id = {$_SESSION['class_id']}
       and school_id = {$_SESSION['school_id']} order by admission_number";

     $result1 = mysqli_query($con, htmlentities($sql, ENT_QUOTES))
       or die(mysqli_error($con));

     while($row1 = mysqli_fetch_array($result1)) {

       $teacher_comment = $_REQUEST["{$row['admission_number']}_{$row1['id']}_teacher"];
       $principal_comment = $_REQUEST["{$row['admission_number']}_{$row1['id']}_principal"];

       if (empty($teacher_comment) && empty($principal_comment))
         $sql="delete from student_comment_{$_SESSION['sessid']} where id={$row1['id']}";
       else {
         $sql="update student_comment_{$_SESSION['sessid']} set teacher='" . htmlentities($teacher_comment, ENT_QUOTES) . "',
           principal='" . htmlentities($principal_comment, ENT_QUOTES) . "'  where id={$row1['id']}";
       }
       mysqli_query($con, $sql) or die(mysqli_error($con));
     }
   }
   save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

}
  $sql="select * from student s join student_temp_{$_SESSION['sessid']} st
   on s.id = st.student_id where st.class_id = {$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']}
   order by admission_number";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("No Student exist for this Class", 'enter_scores.php', 'Bank');
	exit;
  }

  echo "
  <table>
   <tr class='class1'>
    <td><h3 class='sstyle1'>Enter Comment</h3></td>
   </tr>
   <tr>
    <td>
     <table valign='top' style='table-layout:row; border-spacing:0em;
       border-collapse:collapse; width:100%;'>
      <tr>
       <th>Student</th>
       <th>Teacher Comment</th>
       <th>Principal Comment</th>
      </tr>
   ";

   echo "<form method='post' action='enter_comment.php'>";

   while ($row = mysqli_fetch_array($result)) {

     //Make sure there are no comments registered for this student for this
     $sql="select * from student_comment_{$_SESSION['sessid']}
       where admission_number = {$row['admission_number']}
       and session_id = {$_SESSION['session_id']}
       and term_id = {$_SESSION['term_id']}
       and class_id = {$_SESSION['class_id']}
       and school_id = {$_SESSION['school_id']} order by admission_number";

     $result1 = mysqli_query($con, $sql);

	 if (mysqli_num_rows($result1) > 0) {
	   $row1 = mysqli_fetch_array($result1);
	   $teacher_comment_name = "{$row['admission_number']}_{$row1['id']}_teacher";
	   $principal_comment_name = "{$row['admission_number']}_{$row1['id']}_principal";
	   $teacher_comment_value = $row1['teacher'];
	   $principal_comment_value = $row1['principal'];
	 } else {

       $sql="insert into student_comment_{$_SESSION['sessid']}(session_id, term_id, class_id,
         admission_number, teacher, principal, school_id)
         values({$_SESSION['session_id']}, {$_SESSION['term_id']}, {$_SESSION['class_id']},
		 '{$row['admission_number']}', ' ',' ', {$_SESSION['school_id']})";
	   mysqli_query($con, $sql) or die(mysqli_error($con));
	   $id = mysqli_insert_id($con);

	   $teacher_comment_name = "{$row['admission_number']}_{$id}_teacher";
	   $principal_comment_name = "{$row['admission_number']}_{$id}_principal";
	   $teacher_comment_value = '';
	   $principal_comment_value = '';

	 }
     echo "
       <tr style='border:1px solid #ebf3ff;'>
        <td>{$row['admission_number']}
           {$row['firstname']}
           {$row['lastname']}
        </td>
        <td><textarea rows='3' cols='55' name='$teacher_comment_name'>$teacher_comment_value</textarea></td>
        <td><textarea rows='3' cols='55' name='$principal_comment_name'>$principal_comment_value</textarea></td>
       </tr>";
  }
  echo "</table></td></tr>

    <tr>
     <td style='text-align:center;'>
      <input type='submit' name='action' value='Update'>
     </td>
    </form>
    </tr>
    </table>";

   exit;
  main_footer();
  ?>
