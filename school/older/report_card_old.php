<?php 
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once 'ui.inc';
require_once 'util.inc';
require_once 'school.inc';
require_once 'report_card.inc';

$con = connect();
$position = array();

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || (user_type($_SESSION['uid'], 'Exams', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['command']) && ($_REQUEST['command'] == 'Print')) {
  print_starter('Report Card', 'report.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate')) {
  if ($_REQUEST['class_id'] == '0') {
    echo msg_box("Please choose a class", 'report_card.php', 'Back');
	exit;
  }
  //We are not processing all students just yet
  if ($_REQUEST['student_id'] == '0') {
    echo msg_box("Please choose a student", 'report_card.php', 'Back');
	exit;
  }
  $school = get_school_info();
  $next_term = get_term_info($_REQUEST['term_id'] + 1);
  $this_term = get_term_info($_REQUEST['term_id']);
  
  $sql="select count(*) as 'count' from student where current_class_id={$_REQUEST['class_id']}";
  $result = mysql_query($sql) or die(mysql_error());
  $class_count = mysql_fetch_array($result);
  
  $sql="select * from student where id ={$_REQUEST['student_id']}";
  $result = mysql_query($sql) or die(mysql_error());
  $student = mysql_fetch_array($result);
  if (!isset($_REQUEST['command'])) {
      echo "
        <span style='position:absolute;top:0px;left:100px;'>
		 <a style='cursor:hand;'; onclick='window.open(\"report_card.php?action=Generate&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}&student_id={$_REQUEST['student_id']}&command=Print\", \"smallwin\", 
		   \"width=1200,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
		 <img src='images/icon_printer.gif'></a>
		</span>
        ";
   }

  echo "
   <table>
    <tr>
	 <td><img src='upload/{$school['logo']}' width='100px' height='100px'></td>
<div style='position:absolute; top:20px; left:120px; width: 581px;'>
 <div class='a'>{$school['name']}</div>
 <div class='b'>{$school['address']}</div>
 <div class='c'>Email:{$school['email']}</div>
 <div class='x'>Tel:{$school['phone']}</div>
 <table class='d' width='100%'>
  <tr><td>End of Term Report Sheet</td></tr>
  <tr><td>
   <span style='font-weight:bold;'>Next Term Begins:</span> {$next_term['begin_date']}</td></tr>
 </table>
 <div class='e'>{$this_term['name']} TERM</div>
</div>
 <div style='width:50%; position:absolute; top:160px; left:82px; border: 1px solid black;'>
  <table style='border-spacing:0.5em;' width='100%' class='t'>
  <tr><td colspan='4'><span style='font-weight:bold;'>Name</span>
   <span style='font-style:italic;'>(Surname First):</span>{$student['firstname']} {$student['lastname']}</td></tr>
  <tr>
   <td><span class='f'>Admission No:</span> {$student['admission_number']}</td>
   <td><span class='f'>Class:</span> " . get_value('class', 'name', 'id', $student['current_class_id'], $con) . "</td>
   <td><span class='f'>House:</span> {$student['house']}</td>
   <td><span class='f'>Times School Open:</span> {$this_term['times_school_open']}</td>
   </tr>
  <tr>
   <td><span class='f'>No. in Class:</span> {$class_count['count']}</td>
   <td><span class='f'>Year:</span> ". get_value('session', 'name', 'id', $_SESSION['session_id'], $con) . "</td>
   <td>&nbsp;</td>
   <td><span class='f'>Times Present:</span> {$student['times_absent']}</td>
  </tr>
  <tr>
   <td><span class='f'>Sex:</span>{$student['gender']}</td>
   <td><span class='f'>Age:</span> </td>
   <td>&nbsp;</td>
   <td><span class='f'>Times Absent:</span> {$student['times_present']}</td>
  </tr>
  </table>
</div>
<div style='border: 1px solid black; width:10%; position:relative: top:160px; right:1em;'>
  <img src='upload/{$student['passport']}' width='100' height='100'>
</div>
<div style='position:absolute; top:263px; left:43px; width: 610px; height: 701px;'>
  <table width='107%' height='717' valign='top' class='t'>
  <tr>
   <td valign='top'>
    <table width='100%' border='1' style='table-layout:row; text-align:center;' valign='top'>
     <tr style='height:0px;'>
	  <th>Subject</th>
	  <th style='height:1em;'><img src='images/ca.png'></th>
	  <th><img src='images/exams.png'></th>
	  <th><img src='images/scores.png'></th>
	  <th><img src='images/grade.png'></th>
	  <th><img src='images/highest.png'></th>
	  <th><img src='images/lowest.png'></th>
	  <th><img src='images/average.png'></th>
	  <th><img src='images/position.png'></th>
	  <th><img src='images/teachers_signature.png'></th>
     </tr> 
  ";
  $marks_obtained = get_marks_obtained();
  
  //Initialize array of students/marks
  $total_number_of_subjects = 0;
  
  $sql="Select sb.id, sb.name, sb.type from subject sb 
   join (class c, student s) on (sb.type = c.type
    and s.current_class_id = c.id) where 
	 c.id = {$_REQUEST['class_id']}
	 and s.id={$_REQUEST['student_id']}";
	 
   //echo "$sql<br>";
  $result = mysql_query($sql) or die(mysql_error());
  while ($row = mysql_fetch_array($result)) {
    echo "
	 <tr>
	  <td style='text-align:left;'>{$row['name']}</td>";
	 
    $sql1 = "select * from student_subject where 
	 session_id={$_SESSION['session_id']}
	 and term_id ={$_REQUEST['term_id']}
	 and class_id ={$_REQUEST['class_id']}
	 and subject_id={$row['id']}";
	$subject = array();
	//echo "$sql1<br>";
	$result1 = mysql_query($sql1) or die(mysql_error());
	while($row1 = mysql_fetch_array($result1)) {
	  $total = $row1['test'] + $row1['exam'];
	  $marks_obtained[$row1['student_id']] += $total;
	  
	  $subject[$row1['student_id']] = $total;
	  if ($row1['student_id'] == $_REQUEST['student_id']) {
	    echo "
	     <td>{$row1['test']}</td>
         <td>{$row1['exam']}</td>
		 <td>$total</td>
	     <td>" . grade($total) . "</td>
		 <td><div id='h_{$row1['student_id']}_{$row['id']}'></div></td>
	     <td><div id='l_{$row1['student_id']}_{$row['id']}'></div></td>
	     <td><div id='a_{$row1['student_id']}_{$row['id']}'></div></td>
	     <td><div id='p_{$row1['student_id']}_{$row['id']}'></div></td>
	     <td>&nbsp;</td>
	    </tr>";
	}
  }
  //Calculate highest, lowest, average
  echo "<script type='text/javascript'>\n";
  $max = max($subject);
  $min = min($subject);
  $avg = round(array_sum($subject) / count($subject));
  
  echo "document.getElementById('h_{$_REQUEST['student_id']}_{$row['id']}').innerHTML=$max;\n";
  echo "document.getElementById('l_{$_REQUEST['student_id']}_{$row['id']}').innerHTML=$min;\n";
  echo "document.getElementById('a_{$_REQUEST['student_id']}_{$row['id']}').innerHTML=$avg;\n";
  
  //If scores has not been entered for anybody
  //then all positions are zero
  if (array_sum($subject) == 0) {
    $i='0';
    while (list($key, $val) = each($subject)) {
	  if ($key == $_REQUEST['student_id'])
       echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML='$i';\n";
    }
  } else {
    //Calculate position for each student
	$total_number_of_subjects++;
    arsort($subject);
    reset($subject);
    $i = 1;
    while (list($key, $val) = each($subject)) {
      if ($key == $_REQUEST['student_id'])
        echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML=$i;\n";
      $i++;
    }
  }
  echo "</script>\n";	
}
  echo " 
    </table>
   </td> 
   <td width='34%'>
    <table width='100%' height='413' border='1'>
	<tr>
       <th><span class='style4'>SKILLS & BEHAVIOUR</span></th>
       <th><span class='style4'>1</span></th>
       <th><span class='style4'>2</span></th>
       <th><span class='style4'>3</span></th>
       <th><span class='style4'>4</span></th>
       <th><span class='style4'>5</span></th>
     </tr>
  ";
  $sql = "select na.name, sna.score from non_academic na
   join student_non_academic sna on na.id = sna.non_academic_id
   where sna.session_id={$_SESSION['session_id']}
    and sna.term_id={$_REQUEST['term_id']}
	and sna.class_id={$_REQUEST['class_id']}
	and sna.student_id={$_REQUEST['student_id']} order by na.id";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
      echo "
	 <tr style='text-align:center;'>
	  <th style='text-align:left;'><span class='style4'>{$row['name']}</span></th>";
	  echo grade_non_academic($row['score']) . "</tr>";
    }
  } else {
    $sql="select * from non_academic";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
	  echo "<tr>
	   <th style='text-align:left;'><span class='style4'>{$row['name']}</span></th>";
	  for($i=1; $i <= 5; $i++) 
	    echo "<td><span class='style4'></span></td>";
	  echo "</tr>";
	}
  }
  echo "
   </table>
     <table width='100%' height='163' border='1'>
      <caption>
      <span class='style4'><b>KEY TO RATING</b></span>
                                    </caption>
      <tr>
        <td height='32'><span class='style4'>5</span></td>
        <td><span class='style4'>Maintain an excellent degree of observable traits</span>        </tr>
      <tr>
        <td height='32'><span class='style4'>4</span></td>
        <td><span class='style4'>Maintain a high degree of observable traits</span>        </tr>
      <tr>
        <td height='33'><span class='style4'>3</span></td>
        <td><span class='style4'>Show acceptable level of observable traits</span>        </tr>
      <tr>
        <td height='32'><span class='style4'>2</span></td>
        <td><span class='style4'>Show minimal level of observable traits</span>        </tr>
      <tr>
        <td height='18'><span class='style4'>1</span></td>
        <td><span class='style4'>Show no regard for observable traits</span>        </tr>
    </table>
    </td>
  </tr>
  <tr>
     <td height='93' colspan='2'>
      <table border='1' width='100%'>
        
       <tr>
        <td><span class='f'>Total number of subjects:</span> $total_number_of_subjects</td>
        <td><span class='f'>Marks obtainable:</span> " . ($total_number_of_subjects * 100) . "</td>
		<td><span class='f'>Marks obtained:</span> {$marks_obtained[$_REQUEST['student_id']]}</td>
       </tr> 
       <tr>
	   ";
	   $avg = round(array_sum($marks_obtained) / count($marks_obtained));
	   echo "
        <td><span class='f'>Average:</span> $avg</td>
		<td><span class='f'>Position:</span>  
       ";
	   if (array_sum($marks_obtained) == 0) {
         $i='0';
         while (list($key, $val) = each($marks_obtained)) {
	       if ($key == $_REQUEST['student_id'])
             echo $i;
         }
       } else {
         //Calculate position for each student
         arsort($marks_obtained);
         reset($marks_obtained);
         $i = 1;
         while (list($key, $val) = each($marks_obtained)) {
           if ($key == $_REQUEST['student_id'])
             echo $i;
           $i++;
         }
       }
       echo "
        </td>
		<td><span class='f'>Out of:</span> " . count($marks_obtained) . "</td>
       </tr>
       <tr>
        <td><span class='f'>Class Teacher's comment:</span></td>
        <td colspan='2'></td>
       </tr>
       <tr>
        <td height='18'><span class='f'>Principal's Comment:</span></td>
        <td colspan='2'></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td height='25' colspan='2'>
       <span class='f'>Grades:</span>
	";
	$sql="select * from grade_settings order by name";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
	  echo "{$row['name']}={$row['low']}-{$row['high']}  ";
	}
	echo "</td>
    </tr>
  </table>";
  
  exit;
  }
?>
<table> 
 <tr class='class1'>
  <td colspan='3'><h3>Generate Report Card</h3></td>
 </tr>
 <form name='form1' action='report_card.php' method='post'>
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
	  //echo "<option value='0'>All Terms</option>";
	}
    ?>
   </select>
  </td>
 </tr>
 <tr>
  <td>Class</td>
  <td>
   <select name='class_id' onchange='get_students_with_all();'>
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
 <tr><td>Student</td><td><div id='students'></div></td></tr>
 <tr>
  <td>
   <input name='action' type='submit' value='Generate'>
   <input name='action' type='submit' value='Cancel'>
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
