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

$con = connect();
$position = array();

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || (user_type($_SESSION['uid'], 'Exams', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['command']) && ($_REQUEST['command'] == "Print")) {
  print_header('Report Card', 'report.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate')) {
  //Make sure the user chose a class
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a class", 'report.php', 'Back');
    exit;
  }
  $sql="select * from student_subject where 
     session_id = {$_SESSION['session_id']}
    and class_id = {$_REQUEST['class_id']}";
	
  //Make sure there is data for the class
  if ($_REQUEST['student_id'] == '0') {
    if ($_REQUEST['term_id'] != '0') {
      $sql .= " and term_id = {$_REQUEST['term_id']} ";
	}
	$student_name = "";
  } else {
    if ($_REQUEST['term_id'] != '0') {
      $sql .= " and term_id = {$_REQUEST['term_id']} ";
	}
    $sql .= " and student_id = {$_REQUEST['student_id']}";
	 
	$student_name = "Student: " . get_value('student', 'admission_number', 'id', 
     $_REQUEST['student_id'], $con);
    $student_name .= " " . get_value('student', 'firstname', 'id', 
      $_REQUEST['student_id'], $con);
    $student_name .= " " . get_value('student', 'lastname', 'id', 
      $_REQUEST['student_id'], $con);
  }
  //echo "$sql<br>";
  $result = mysql_query($sql) or die(mysql_error() . "Ehen");
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("There is no data for " . 
       get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
     " Session, " . get_value('term','name','id',$_REQUEST['term_id'], $con).
     " Term, Class ".get_value('class','name','id',$_REQUEST['class_id'],$con).
     " $student_name", 'report.php', 'Back');
     exit;
   }  
   //Lets get the school info
   $sql="select * from school_info";
   $result2 = mysql_query($sql) or die(mysql_error());
   if (mysql_num_rows($result2) > 0) {
     $row2 = mysql_fetch_array($result2);
	 $name = $row2['name'];
	 $address = $row2['address'];
	 $phone = $row2['phone'];
	 $email = $row2['email'];
	 $web = $row2['web'];
	 $logo = $row2['logo'];
   } else {
     $name = "";
	 $address = "";
	 $phone = "";
	 $email = "";
	 $web = "";
	 $logo = "";
	 
   }
   //Generate a single student's report card or all the students 
   //in a class
   $total_score_everybody = 0;
   if ($_REQUEST['student_id'] == '0') {
     $sql="select * from student where current_class_id={$_REQUEST['class_id']}";
   } else {
     $sql="select * from student where id={$_REQUEST['student_id']} ";
   }
   echo " 
      <table>
       <tr>
        <!--<td colspan='2'><h3>Report Card</h3></td>-->";
   if (!isset($_REQUEST['command'])) {
      echo "
        <td>		  
		 <a style='cursor:hand;'; onclick='window.open(\"report.php?action=Generate&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}&student_id={$_REQUEST['student_id']}&command=Print\", \"smallwin\", 
		   \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
		 <img src='images/icon_printer.gif'></a>
        </td>
	   </tr>";
   }
   $term_array = get_terms($_REQUEST['term_id']);
   $row_test_exam = get_row_test_exam();
   
   $result = mysql_query($sql) or die('Cannot execute sql* ' . mysql_error());
   while($row = mysql_fetch_array($result)) { 
	 echo "
       <tr>
        <td colspan='3'>
         <table border='0'>
          <tr>
	       <!--
           <td>
            <table>
             <tr>
              <td>
               <img src='upload/{$logo}' alt='School Logo'
                width='80' height='80'>
              </td>
             </tr>
            </table>
           </td>
		   -->
           <td colspan='3'>
            <table style='text-align:center; font-weight:bold;'>
             <tr style='font-size:2em;'><td>$name</td></tr>
             <tr><td>$address</td></tr>
             <tr><td>$phone</td></tr>
             <tr><td>$email $web</td></tr>
            </table>
           </td>
          </tr>
         </table>
        </td>
       </tr> 
       <tr style='text-align:center; font-weight:bold; font-size:2em;'>
        <td>STUDENT'S CONTINUOUS ASSESSMENT REPORT SHEET</td></tr> 
       <tr>
        <td colspan='3'>
         <table>
          <tr>
           <td><b>Name(Surname First):</b>{$row['firstname']} {$row['lastname']}</td>
           <td><b>Position in Class:</b>&nbsp;<div style='display:inline;' id='p_{$row['id']}'>&nbsp;</div>
		   &nbsp;<b>Out of</b>&nbsp;<div style='display:inline;' id='n_{$row['id']}'>&nbsp;</div>&nbsp;Students</td>
          </tr>
          <tr>
           <td><b>Admission Number: </b>{$row['admission_number']}</td>
           <td><b>Term:</b> " . 
            get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
           <td><b>Session:</b> ".
            get_value('session', 'name', 'id', $_SESSION['session_id'],$con). "</td> 
          </tr> 
          <tr>
           <td><b>Class:</b> " .  
            get_value('class', 'name', 'id', $_REQUEST['class_id'], $con) . "</td>
          </tr> 
         </table>
        </td>
       </tr>
       <tr>
        <td colspan='2' width='80%'>
         <table border='1' style='table-layout:row; text-align:center;'>
          <tr>
           <th>Subject</th>
           <th>Continuous Assessment</th>
           <th>Test Total({$row_test_exam['test']}%)</th>
           <th>Exam Score({$row_test_exam['exam']}%)</th>
	 "; 
	 foreach($term_array as $id => $term_name) {
	   if ($id != $_REQUEST['term_id']) 
         echo "<th>$term_name Term Total Score</th>";
	 }
	 echo "<th>Total of " . implode(',',$term_array ) . " term Scores</th>
           <th>Total Average</th>
           <th>Position</th>
           <th>Remarks</th>
          </tr> 
          <tr>
           <td>&nbsp;</td>
           <td>
            <!--<table width='50%' border='1' style='text-align:center;'>-->
            <table border='1' style='table-layout:fixed;border-spacing:1em;
             width:100%;'>
          <tr>
           <td>1st Test</td>
           <td>2nd Test</td>
           <td>3rd Test</td>
           <td>4th Test</td>
          </tr>
         </table>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
       </tr> 
     ";
	  $total_score = 0;
	  $sql="select sb.id, sb.name, ss.test1, ss.test2, 
        ss.test3, ss.test4, ss.exam from subject sb join 
        (student_subject ss, student s) on 
        (s.id = ss.student_id and sb.id = ss.subject_id 
        and ss.session_id = {$_SESSION['session_id']})";
	  if ($_REQUEST['student_id'] == 0) {
	    $sql .= " where ss.student_id = {$row['id']} ";
	  } else {
        $sql .=" where ss.student_id = {$_REQUEST['student_id']} ";
	  }
	  if ($_REQUEST['term_id'] != '0') 
	    $sql .= " and ss.term_id = {$_REQUEST['term_id']}";
    
      $sql .= " and ss.class_id = {$_REQUEST['class_id']} order by sb.id";
      echo "$sql<br>";
      $result1 = mysql_query($sql) or die(mysql_error());
      $total_score = 0;
      $count = 0;
      while ($row1 = mysql_fetch_array($result1)) {
        $total_test = $row1['test1'] + $row1['test2'] 
         + $row1['test3'] + $row1['test4'];
		//Test scores accounts for 15%, Exam scores accounts for 70%
		$total_subject_score = (($total_test /100)* $row_test_exam['test']) + (($row1['exam']/100) * $row_test_exam['exam']);
        $total_score += $total_subject_score;
        $count++;
		
		//Save the scores
		$position[$row['id']] = $total_score;
	    $total_score_everybody += $total_score;
        echo "
	   <tr>
        <td style='text-align:left;'>{$row1['name']}</td>
        <td>
         <!--<table width='50%' border='1' style='text-align:center;'>-->
         <table border='1' style='table-layout:fixed;border-spacing:1em;
          width:100%;'>
          <tr>
           <td>{$row1['test1']}</td>
           <td>{$row1['test2']}</td>
           <td>{$row1['test3']}</td>
           <td>{$row1['test4']}</td>
          </tr>
         </table>
        </td>
        <td>$total_test</td>
       <td>{$row1['exam']}</td>
	   <td><div id='t_{$row['id']}_{$_REQUEST['term_id']}_{$row1['id']}'>&nbsp;</div></td>
	  ";
	  foreach($term_array as $id => $term_name) {
	    if ($id != $_REQUEST['term_id'])  {
        echo "<td><div id='t_{$row['id']}_{$id}_{$row1['id']}'>&nbsp;</div></td>";
		echo "<td><input type='text' id='t_total_{$row['id']}_{$row1['id']}' value='0'></td>";
		echo "<td><input type='text' id='t_average_{$row['id']}_{$row1['id']}' value='0'></td>";
		}
		//echo "<td><div id='t_total_{$row['id']}_{$row1['id']}'>0</div></td>";
	  }
	  echo "
        <td><div id='p_{$row['id']}_{$row1['id']}'>&nbsp;</div></td>
        <td>&nbsp;</td>
       </tr>";
      } 
	 //Lets store the scores
	 //used later for calculating positions
     //$position[$row['id']] = $total_score;
      echo " 
      </table>
     </td> 
     <td>
      <table>
       <tr>
        <td>
         <table border='1'>
          <caption><b>EFFECTIVE TRAITS BEHAVIOUS</b></caption>
          <tr><td>Personality</td><td>A</td></tr>
          <tr><td>Mental Awareness</td><td>B</td></tr>
          <tr><td>Respect</td><td>A</td></tr>
          <tr><td>Politeness</td><td>A</td></tr>
          <tr><td>Honesty</td><td>A</td></tr>
          <tr><td>Relationship with peers</td><td>A</td></tr>
          <tr><td>Willigness to Learn</td><td>A</td></tr>
          <tr><td>Spirit of teamwork</td><td>A</td></tr>
         </table>
        </td>
       </tr>
       <tr><td>&nbsp;</td></tr>
       <tr>
        <td>
         <table border='1'>
          <caption><b>PSYCHOMOTOR</b></caption>
          <tr><td>Verbal Skills</td><td>A</td></tr>
          <tr><td>Participation in Games and Sports</td><td>A</td></tr>
          <tr><td>Artistic Creativity</td><td>A</td></tr>
          <tr><td>Musical Skills</td><td>B</td></tr>
          <tr><td>Dance Skills</td><td>C</td></tr>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td colspan='3'>
      <table border='1'>
       <tr>
        <td>The term ends on:</td>
        <td>Next term begins on:</td>
       </tr> 
       <tr>
        <td>Class Teachers Remarks:</td>
        <td>Signature/Date:</td>
       </tr> 
       <tr>
        <td>Principal's Remarks:</b></td>
        <td>Signature/Date:</b></td>
       </tr>
       <tr>
        <td>No. of Times School Opened:</td>
        <td>No. of Times Present:</b></td>
        <td>No. of Times Absent:</td>
       </tr>
       <tr>
        <td>Summary Remarks:</td>
        <td>Signature/Date:</td>
       </tr>
       <tr>
        <td>Parent's/Guardian's comment:</td>
        <td>Signature/Date:</td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td colspan='3'>
      <b>Grades:</b> A=Excellent 90-100, B=Good 70-89, C=Average 50-69, 
       D=Below Average 40-49, E=Poor Below 40 
     </td>
    </tr>
     ";
	 //Determine the total number of students
	 $sql="select count(*) as 'count'
      from student where current_class_id={$_REQUEST['class_id']}";
     $result3 = mysql_query($sql) or die(mysql_error());
     $row3 = mysql_fetch_array($result3);
	 echo "<br><script type='text/javascript'>";
     echo "document.getElementById('n_{$row['id']}').innerHTML='{$row3['count']}';";
	 echo "</script>";
	}
  echo "</table>";
  //This is so so dumb inefficient. 
  print_r($position);
  
  echo "<br><script type='text/javascript'>";
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
  /*
  $sql="select * from student where current_class_id={$_REQUEST['class_id']}";
   if ($_REQUEST['student_id'] != 0) 
     $sql .= " and id = {$_REQUEST['student_id']}";
  echo "$sql<br>";
  $result  = mysql_query($sql) or die(mysql_error());
  while ($row = mysql_fetch_array($result)) {
    $sql="select * from term where session_id= {$_SESSION['session_id']}";
	echo "$sql<br>";
	$result2 = mysql_query($sql) or die(mysql_error());
	$term = array();
	$term_total = 0;
	while($row2 = mysql_fetch_array($result2)) { 
      $sql="select sb.id, sb.name, ss.test1, 
	   ss.test2, ss.test3, ss.test4, ss.exam
	   from subject sb join (student_subject ss, student s) on 
       (s.id = ss.student_id and sb.id = ss.subject_id 
       and ss.session_id = {$_SESSION['session_id']})
       where ss.student_id = {$row['id']} 
	   and ss.class_id = {$_REQUEST['class_id']}
	   and ss.term_id={$row2['id']}";
	  echo "$sql<br>";
	  $result3 = mysql_query($sql) or die(mysql_error());
	  $subject = array();
	  
	  while ($row3 = mysql_fetch_array($result3)) {
	    
		$total_test = $row3['test1'] + $row3['test2'] 
         + $row3['test3'] + $row3['test4'];
		 
		//Test scores accounts for 15%, Exam scores accounts for 70%
		$total_subject_score = ($total_test * 0.3) + ($row3['exam'] * 0.7);
        $subject[$row3['id']] = $total_subject_score;
		
		echo "<br><script type='text/javascript'>\n";
        echo "document.getElementById('t_{$row['id']}_{$row2['id']}_{$row3['id']}').innerHTML='$total_subject_score';\n";
		echo " var a = document.getElementById('t_total_{$row['id']}_{$row3['id']}').value;\n";
        echo " var t = parseFloat(a);\n";
		echo " t += parseFloat($total_subject_score);\n";
		//Calculate total of the terms
		echo "document.getElementById('t_total_{$row['id']}_{$row3['id']}').value=t;\n";
		//Calculate average of the terms
		echo " var avg = t/" . count($term_array) . ";\n";
		echo " document.getElementById('t_average_{$row['id']}_{$row3['id']}').value=avg;\n";
	    
		echo "</script>";
      }
	  $term[$row2['id']] = $subject;
	}
	$student[$row['id']] = $term;
  }
  
  //print_r($student);
  
  //echo "<br>";
  /*
  $tscore = 0;
  $total = array();
  $subjecta = array();
  foreach($student as $id => $term) {
    echo "<b>" . get_value('student', 'firstname', 'id', $id, $con) . "</b><br>";
    foreach($term as $tid => $subject) {
	  echo  "<b>" . get_value('term', 'name', 'id', $tid, $con) . " Term</b><br>";
	  foreach($subject as $sid => $score) { 
	   $tscore += $score;   
        echo  " " . get_value('subject', 'name', 'id', $sid, $con) . " = $score <br>";  
	    echo "<br><script type='text/javascript'>";
        echo "document.getElementById('t_{$id}_{$tid}_{$sid}').innerHTML='$score';";
	    echo "</script>";
		$key = "{$id}_{$sid}";
		$subjecta[$key] += $score;  
		}
	  } 
	}
  
  echo "<br>";
  print_r($subject);
  */
  /*
  echo "<br><script type='text/javascript'>";
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
  */
  //print_r($position);
  exit;
}
 ?> 
<table> 
 <tr class="class1">
  <td colspan='3'><h3>Generate Report Card</h3></td>
 </tr>
 <form name='form1' action="report.php" method="post">
 <tr>
  <td>Term</td>
  <td>
   <select name='term_id'>
   <?php 
    $sql ="select * from term where session_id={$_SESSION['session_id']}";
    $result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_array($result)) { 
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
      }
	  echo "<option value='0'>All Terms</option>";
	}
    ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>Class</td>
  <td>
   <select name="class_id" onchange='get_students_with_all();'>
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
 <tr><td>Student</td><td><div id="students"></div></td></tr>
 <tr>
  <td>
   <input name='action' type='submit' value='Generate'>
   <input name="action" type="submit" value="Cancel">
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
