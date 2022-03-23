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
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a Class", 'enter_non_academic.php', 'Back');
    exit;
  }
  if ($_REQUEST['term_id'] == '0') {
    echo msg_box("Please choose a Term", 'enter_non_academic.php', 'Back');
    exit;
  }
  if ($_REQUEST['student_id'] == '0') {
    echo msg_box("Please choose a Student", 'enter_non_academic.php', 'Back');
    exit;
  }
  $sql="select * from student_non_academic 
	where session_id = {$_SESSION['session_id']}
    and term_id = {$_REQUEST['term_id']}
    and class_id = {$_REQUEST['class_id']}
    and student_id = {$_REQUEST['student_id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) { 
	  $sql="update student_non_academic 
	   set score={$_REQUEST[$row['non_academic_id']]} 
	    where non_academic_id={$row['non_academic_id']}
		and session_id={$_SESSION['session_id']}
		and term_id={$_REQUEST['term_id']}
		and class_id={$_REQUEST['class_id']}
		and student_id={$_REQUEST['student_id']}";
	  //echo "$sql<br>";
	  mysql_query($sql) or die(mysql_error());
	}
  } else {
    $sql="select * from non_academic";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
      $sql="insert into student_non_academic
	   (session_id, term_id, class_id, student_id, non_academic_id, score)
	   values({$_SESSION['session_id']}, {$_REQUEST['term_id']}, 
	   {$_REQUEST['class_id']}, {$_REQUEST['student_id']}, 
	   {$row['id']}, '{$_REQUEST[$row['id']]}')";
	  //echo "$sql<br>";
	  mysql_query($sql) or die(mysql_error());
    }
  }
  echo msg_box('Successfully updated', 'enter_non_academic.php', 
       'Continue');
   exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Proceed')) {
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a Class", 'enter_non_academic.php', 'Back');
    exit;
  }
  if ($_REQUEST['term_id'] == '0') {
    echo msg_box("Please choose a Term", 'enter_non_academic.php', 'Back');
    exit;
  }
  if ($_REQUEST['student_id'] == '0') {
    echo msg_box("Please choose a Student", 'enter_non_academic.php', 'Back');
    exit;
  }

  $sql="select * from student where id={$_REQUEST['student_id']}";
  $result = mysql_query($sql) or die('Cannot execute sql ' . mysql_error());
  $row = mysql_fetch_array($result);
  echo "
  <table>
   <tr class='class1'>
    <td colspan='3'><h3>Enter Non Academic Record</h3></td>
   </tr>
   <tr>
    <td colspan='2'>
     <table>
      <tr>
	  <td><b>Student:</b> {$row['admission_number']}
	    {$row['firstname']} {$row['lastname']}
       </td>
	   <td><b>Class:</b> " .  
        get_value('class', 'name', 'id', $_REQUEST['class_id'], $con) . 
       "</td>
      <td><b>Session:</b> ".
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con)."</td>
       <td><b>Term</b> " 
       . get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td> 
      </tr>
     </table>
    </td>
   </tr>
   
   <tr>
    <td>
     <table border='1' style='table-layout:row; border-spacing:0em; 
       border-collapse:collapse; width:100%;'>
	  <!--
      <tr>
       <th>Non Academic Skill</th>
       <th>&nbsp;</th>
      </tr>
	  -->
	 
   ";
   echo "
    <form action='enter_non_academic.php' method='post'>
    <input type='hidden' name='term_id' 
     value='{$_REQUEST['term_id']}'>
    <input type='hidden' name='student_id' 
     value='{$_REQUEST['student_id']}'>
    <input type='hidden' name='class_id' 
     value='{$_REQUEST['class_id']}'>
   ";
   $sql="select na.id, na.name, 
    sna.score from student_non_academic 
    sna join non_academic na on sna.non_academic_id = na.id 
	where
    sna.session_id = {$_SESSION['session_id']}
    and sna.term_id = {$_REQUEST['term_id']}
    and sna.class_id = {$_REQUEST['class_id']}
    and sna.student_id = {$_REQUEST['student_id']}
	order by na.id";
   //echo "$sql<br>";
   if (mysql_num_rows(mysql_query($sql)) > 0) {
     $result = mysql_query($sql) or die(mysql_error());
	 while($row = mysql_fetch_array($result)) {
	   echo "<tr>
	    <td>{$row['name']}</td>
	   ";
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
     $sql1="select * from non_academic order by id";
	 $result1 = mysql_query($sql1) or die(mysql_error());
	 while($row1 = mysql_fetch_array($result1)) {
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
	  <tr><td>1</td><td>Maintain an excellect degree of observable traits</td></tr>
	  <tr><td>2</td><td>Maintain a high degree of observable traits</td></tr>
	  <tr><td>3</td><td>Show acceptable level of observable traits</td></tr>
	  <tr><td>4</td><td>Show minimal level of observable traits</td></tr>
	  <tr><td>5</td><td>Show non regard for observable traits</td></tr>
	 </table>
	</td>
   </tr>
    <tr>
     <td colspan='2'>
	  <table border='1' width='100%'>
       <tr style='text-align:center;'><td><input type='submit' name='action' value='Submit'>
       <input type='submit' name='action' value='Cancel'></td></tr>
	  </table>
     </td>
    </form>
    </tr>
    </table>";
   exit;
}
?> 

<table> 
 <tr class="class1">
  <td colspan='3'><h3>Enter Non Academic Record</h3></td>
 </tr>
 <form name='form1' action="enter_non_academic.php" method="post">
  <input type='hidden' name='uid' value='<?php echo $_SESSION['uid'];?>'>
 <tr>
   <?php
    $sql="select * from term where session_id={$_SESSION['session_id']}";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("No Term has been defined. 
        Please define a Term before entering non academic record", 
        'term.php', 'Add a Term');
        exit;
    } 
    $result2 = mysql_query("Select * from class");
    if (mysql_num_rows($result2) <= 0) {
      echo msg_box("No Class has been defined. 
        Please define a Class before entering non academic record", 
        'class.php', 'Add a Class');
        exit;
    } 
    $result4 = mysql_query("select * from student");
    if (mysql_num_rows($result4) <= 0) {
      echo msg_box("No student has been added. 
        Please add a Student before entering non academic record", 
        'student.php', 'Add a Student');
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
   <select name="class_id" onChange="get_students();">
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
  <td>Students</td>
  <td><div id="students"></div></td>
 <tr>
  <td>
   <input name='action' type='submit' value='Proceed'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<?php main_footer();  ?>
