<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
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
check_session_variables('enter_non_academic.php', $con); 

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {

  check($_REQUEST['student_name'], 'Please choose a Student', 
    'enter_non_academic.php');

  $admission_number = get_admission_number($_REQUEST['student_name']);
  
  $sql="select * from student_non_academic_{$_SESSION['sessid']} 
	where session_id = {$_SESSION['session_id']}
    and term_id = {$_SESSION['term_id']}
    and $extra_caution_sql
    and admission_number = $admission_number";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result)) { 
      $sql="update student_non_academic_{$_SESSION['sessid']} 
        set score={$_REQUEST[$row['non_academic_id']]} 
        where non_academic_id={$row['non_academic_id']}
	and session_id={$_SESSION['session_id']}
	and term_id={$_SESSION['term_id']}
        and $extra_caution_sql
	and admission_number=$admission_number";

      mysqli_query($con, $sql) or die(mysqli_error($con));
    }
  } else {
    $sql="select * from non_academic 
      where school_id = {$_SESSION['school_id']}";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($result)) {
      $sql="insert into student_non_academic_{$_SESSION['sessid']}
       (session_id, term_id, class_id, admission_number, school_id, 
       non_academic_id, score)
       values({$_SESSION['session_id']}, {$_SESSION['term_id']}, 
       {$_SESSION['class_id']}, $admission_number, {$_SESSION['school_id']}, 
       {$row['id']}, '{$_REQUEST[$row['id']]}')";

       mysqli_query($con, $sql) or die(mysqli_error($con));
    }
  }
  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);
  echo msg_box('Successfully updated', 'enter_non_academic.php', 
       'Continue');
   exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {

  check($_REQUEST['student_name'], 'Please choose a Student', 
    'enter_non_academic.php');

  $admission_number = get_admission_number($_REQUEST['student_name']);

  $sql="select * from student s join student_temp_{$_SESSION['sessid']} st
    on s.id = st.student_id where s.admission_number='$admission_number'
    and st.class_id={$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']}";
	
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
    echo msg_box("{$_REQUEST['student_name']} is not a Student in this School", 'enter_non_academic.php', 'Back');
	exit;
  }
  $row = mysqli_fetch_array($result);
  ?>
  <table>
   <tr class='class1'>
    <td colspan='2'><h3 class='sstyle5'>Enter Non Academic Record for 
	<?php echo "{$row['admission_number']} {$row['firstname']} {$row['lastname']}"; ?></h3></td>
   </tr>
   <tr>
    <td>
     <table border='1' style='table-layout:row; border-spacing:0em; 
       border-collapse:collapse; width:100%;'>
      
    <form action='enter_non_academic.php' method='post'>
    <?php
  
	$sql="select na.id, na.name, sna.score from student_non_academic_{$_SESSION['sessid']} sna 
	 join non_academic na on sna.non_academic_id = na.id 
	 where session_id ={$_SESSION['session_id']} 
	 and term_id ={$_SESSION['term_id']}
	 and class_id={$_SESSION['class_id']}
	 and sna.school_id={$_SESSION['school_id']}
	 and admission_number ={$admission_number} order by na.id";

  
   if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
     $result = mysqli_query($con, $sql) or die(mysqli_error($con));
     while($row = mysqli_fetch_array($result)) {
       echo "<tr><td>{$row['name']}</td>";

       echo "<td>
        <select name='{$row['id']}'>";
       for($i=1; $i <= 5; $i++) {
         echo "<option ";
	 if ($row['score'] == $i)
	   echo "selected='selected'";
	 echo ">$i</option>\n";
       }
       echo "
        </select>
       </td>
       </tr>";
     } 
   } else {
     $sql1="select * from non_academic 
      where school_id={$_SESSION['school_id']} order by id";

     $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
     while($row1 = mysqli_fetch_array($result1)) {
       echo "<tr>
         <td>{$row1['name']}</td>
	 <td>
	  <select name='{$row1['id']}'>";
       for($i=1; $i <= 5; $i++)
         echo "<option>$i</option>\n";
       echo "
	  </select>
	 </td>
	 </tr>";
     } 
   }
   echo "</table></td>
    <td valign='top'>
     <table width='50%' border='1' valign='top'>
      <caption><b>KEY TO RATING</b></caption>
       <tr><td>5</td><td>Maintain an excellect degree of observable traits </td></tr>
       <tr><td>4</td><td>Maintain a high degree of observable traits</td></tr>
       <tr><td>3</td><td>Show acceptable level of observable traits</td></tr>
       <tr><td>2</td><td>Show minimal level of observable traits</td></tr>
       <tr><td>1</td><td>Show non regard for observable traits</td></tr>
      </table>
     </td>
   </tr>
   <tr>
    <td colspan='2'>
     <table border='1' width='100%'>
      <tr style='text-align:center;'>
       <td>
        <input type='submit' name='action' value='Update'>
        </td></tr>
     </table>
    </td>
    <input type='hidden' name='student_name' 
      value='{$_REQUEST['student_name']}'/>
    </form>
   </tr>
  </table>";
  exit;
}
/*** Check to see if any Student's have been registered for this Class ***/
$sql="select * from student s join student_temp_{$_SESSION['sessid']} st on s.id = st.student_id 
     where st.class_id = {$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']}";
$result4 = mysqli_query($con, $sql) or die(mysqli_error($con));
if (mysqli_num_rows($result4) <= 0) {
  echo msg_box("No student has been added for this Class. Please add a Student before entering non academic record", 'student.php', 
    'Add a Student');
 exit;
} 
  
require_once "choose_student_ui.php"; 
choose_student_ui("Enter Non Academic Information", "enter_non_academic.php", $con);

?>