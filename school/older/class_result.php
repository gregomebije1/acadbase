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
$position = array();

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || (user_type($_SESSION['uid'], 'Exams', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "Print")) {
  print_header('Class Result', 'class_result.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && 
  (($_REQUEST['action'] == 'Generate') || ($_REQUEST['action'] == 'Print'))) {
     $sql="select s.id, s.name from subject s join class c on 
      s.type = c.type where c.id = {$_REQUEST['class_id']}";
     $result = mysql_query($sql) or die(mysql_query());
	 if (mysql_num_rows($result) == 0) {
	   echo msg_box("No subject has been registered for 
	    this class", 'class_result.php', 'Back');
	   exit;
	 }
   $term_array = get_terms(0);	
   echo "
  <table style='table-layout:fixed; width:100em;'>
   <tr class='class1'>
    <td style='text-align:left;'><h3>Class Result</h3></td>
     <table style='table-layout:fixed;'>
      <tr>
       <td><b>Session:</b> ".
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con). "</td> 
       <td><b>Term:</b>";
  if ($_REQUEST['term_id'] == '0') 
    echo "Cummulative";
  else {
    echo get_value('term', 'name', 'id', $_REQUEST['term_id'], $con);
  }
  echo "</td>
       <td><b>Class:</b> " .  
        get_value('class', 'name', 'id', $_REQUEST['class_id'], $con) . "</td>
  ";
  if ($_REQUEST['action'] == 'Generate') {
    echo "<td><a style='cursor:hand;'; onclick='window.open(\"class_result.php?action=Print&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}\", \"smallwin\", \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'><img src='images/icon_printer.gif'></a></td>
    ";
   }
  echo "
      </tr> 
     </table>
    </td>
   </tr>
   <tr>
    <td style='width:100em;'>
     <table style='table-layout:row; text-align:center;' border='1'>
      <tr>
       <th>Admission No</th>
       <th>Firstname</th>
       <th>Lastname</th>
   ";
   $sql="select s.name from subject s join class c on 
     s.type = c.type where c.id = {$_REQUEST['class_id']}";
   //echo "$sql<br>";
   $result = mysql_query($sql) or die(mysql_query());
   while ($row = mysql_fetch_array($result)) {
     echo "<th style='width:10em;'>{$row['name']}</th>";
   }
   ?>
     <th>Total</th>
     <th>Average</th>
     <th>Position</th>
     <th>Remarks</th>
      </tr>
     
   <?php 
   
   //Fetch students in that class
   $sql="select * from student 
    where current_class_id = {$_REQUEST['class_id']}";
   //echo "$sql<br>";
   $result = mysql_query($sql) or die(mysql_error());
   $total_score_everybody = 0;
   while ($row = mysql_fetch_array($result)) {
     echo "   <tr>
               <td>
                <a href='report_card.php?class_id={$_REQUEST['class_id']}&term_id={$_REQUEST['term_id']}&student_id={$row['id']}&action=Generate'>{$row['admission_number']}</a></td>
               <td>{$row['firstname']}</td>
               <td>{$row['lastname']}</td>
     ";
     
     $total_score = 0;
     //Fetch all subjects in that class
     $sql1="select s.id, s.name from subject s join class c on 
      s.type = c.type where c.id = {$_REQUEST['class_id']}";
     $result1 = mysql_query($sql1) or die(mysql_query());
     while ($row1 = mysql_fetch_array($result1)) { 
	   $subject_score = 0;
       //If it is for cummulative terms
	   if ($_REQUEST['term_id'] == '0') {
	     foreach($term_array as $term_id => $term_name) {
		   $sql2="select * from student_subject where 
            session_id = {$_SESSION['session_id']}    
            and term_id = $term_id
            and student_id = {$row['id']} 
            and subject_id = {$row1['id']} order by id";
		   //echo "$sql2<br>";
           $test = 0;
	       $exam = 0;
		   
	   
           $result2 = mysql_query($sql2);
	       if (mysql_num_rows($result2) > 0) {
             while($row2 = mysql_fetch_array($result2)) {
		       $test = $row2['test'];
		       $exam = $row2['exam'];
		       $subject_score += $test + $exam;
			 }
	       } else {
		     $subject_score += $test + $exam;
           }
		   //echo "subject score is $subject_score total_score is $total_score<br>";
		 }
		 $total_score += $subject_score;
	   } 
	   //For only one term
	   else {
  	     //Fetch students records for this subject
         $sql2="select * from student_subject where 
          session_id = {$_SESSION['session_id']}    
          and term_id = {$_REQUEST['term_id']}
          and student_id = {$row['id']} 
          and subject_id = {$row1['id']} order by id";
         $test = 0;
	     $exam = 0;
	   
         $result2 = mysql_query($sql2);
	     if (mysql_num_rows($result2) > 0) {
           $row2 = mysql_fetch_array($result2);
		   $test = $row2['test'];
		   $exam = $row2['exam'];
		   $subject_score = $test + $exam;
           $total_score += $subject_score;
	     } else {
		   $subject_score = $test + $exam;
           $total_score += $subject_score;
         }
	  }
	  echo "<td>$subject_score</td>";
     }
	 $sql="select count(*) as 'count' from student where current_class_id={$_REQUEST['class_id']}";
     $result_count = mysql_query($sql) or die(mysql_error());
     $class_count = mysql_fetch_array($result_count);

     echo "<td>$total_score</td>";
     echo "<td>" . number_format(($total_score/$class_count['count']), 2) . "</td>";
     echo "<td><div id='p_{$row['id']}'>&nbsp;</div></td>";
     echo "<td>&nbsp;</td>";
     echo "</tr>";
     $position[$row['id']] = $total_score;
	 $total_score_everybody += $total_score;
   }
   echo "</table>";
   echo "<script type='text/javascript'>";
   if ($total_score_everybody == 0) {
     $i='0';
     while (list($key, $val) = each($position)) {
       echo "document.getElementById('p_$key').innerHTML='$i';";
     }
   } else {
     arsort($position);
     reset($position);
     
     $i = 1;
     while (list($key, $val) = each($position)) {
       echo "document.getElementById('p_$key').innerHTML=$i;";
       $i++;
     }
   }
   echo "</script>";
   exit;
 }
 ?> 
<table style='table-layout:fixed;'> 
 <tr class="class1">
  <td colspan='3'><h3>Generate Class Result</h3></td>
 </tr>
 <form action="class_result.php" method="post">
 <tr>
  <td>Term</td>
  <td>
   <select name='term_id'>
    <?php
    $sql ="select * from term where session_id={$_SESSION['session_id']}
	 order by id";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) { 
      echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    ?>
	<option value='0'>Cummulative</option>
   </select>
  </td>
 </tr>
 <tr>
  <td>Class</td>
  <td>
   <select name="class_id">
   <?php
   $sql="select * from class order by name";
   $result = mysql_query($sql);
   while($row1 = mysql_fetch_array($result)) {
     echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
   }
   ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>
   <input name='action' type='submit' value='Generate'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
