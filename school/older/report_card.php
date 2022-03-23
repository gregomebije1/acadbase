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
  
  $school = get_school_info();
  $next_term = get_term_info($_REQUEST['term_id'] + 1);
  $this_term = get_term_info($_REQUEST['term_id']);
  
  $sql="select count(*) as 'count' from student where current_class_id={$_REQUEST['class_id']}";
  $result = mysql_query($sql) or die(mysql_error());
  $class_count = mysql_fetch_array($result);
  
  if ($_REQUEST['student_id'] == '0') {
    $sql="select * from student where current_class_id={$_REQUEST['class_id']}"; 
  } else {
    $sql="select * from student where id ={$_REQUEST['student_id']}";
  }
  //echo "$sql<br>";
  $term_array = get_terms(0);	
  $result_student = mysql_query($sql) or die(mysql_error());
  while($student = mysql_fetch_array($result_student)) {
    echo "<table border='1' style='width:100%;'>
     <tr>
    ";
    if (!isset($_REQUEST['command'])) {
      echo "
	   <td>
        <span style='position:absolute;top:0px;left:100px;'>
		 <a style='cursor:hand;'; onclick='window.open(\"report_card.php?action=Generate&term_id={$_REQUEST['term_id']}&class_id={$_REQUEST['class_id']}&student_id={$_REQUEST['student_id']}&command=Print\", \"smallwin\", 
		   \"width=1200,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
		 <img src='images/icon_printer.gif'></a>
		</span>
		</td>
		</tr>
        ";
    }
    echo "
     <tr>
      <td>
	   <table>
	    <tr>
	     <td><img src='upload/{$school['logo']}' width='100px' height='100px'></td>
	     <td style='width:100%;'>
          <table border='1' style='width:100%;'>
	       <tr><td class='a'>{$school['name']}</td>
           <tr><td>{$school['address']}</td></tr>
           <tr><td>Email:{$school['email']}</td></tr>
           <tr><td>Tel:{$school['phone']}</td></tr>
	      </table>
	     </td>
	    </tr>
	   </table>
	  </td>
     </tr>
	 ";
	 if ($_REQUEST['term_id'] == '0') {
	   echo "
	   <tr>
	    <td colspan='2' style='font-weight:bolder; font-size:1em; text-align:center;'>CUMULLATIVE TERMS</td>
	   </tr>
	   ";
	 } else {
	   echo "
     <tr>
	  <td colspan='2' style='font-weight:bolder; text-align:center;'>{$this_term['name']} TERM</td></tr>
     <tr><td colspan='2' style='text-align:center;'>End of {$this_term['name']} Term Report Sheet 
       <span style='font-weight:bold;'>Next Term Begins:</span>
		{$next_term['begin_date']}
	  </td>
	 </tr>";
	 } 
	 echo "
     <tr>
      <td style='width:100%;'>
       <table>
	    <tr>
	     <td style='width:100%;'>
          <table style='border-spacing:0.1em;' width='100%' class='t'>
           <tr><td colspan='4'><span style='font-weight:bold;'>Name</span>
        <span style='font-style:italic;'>(Surname First):</span>{$student['firstname']} {$student['lastname']}</td></tr>
        <tr>
         <td><span class='f'>Admission No:</span> {$student['admission_number']}</td>
         <td><span class='f'>Class:</span> " . get_value('class', 'name', 'id', $student['current_class_id'], $con) . "</td>
         <td><span class='f'>House:</span> {$student['house']}</td>
         <td><span class='f'>Times School Open:</span> 
	 ";
	    if ($_REQUEST['term_id'] == '0') {
		  $sql_term="select sum(times_school_open) as 'sum' from term where session_id={$_SESSION['session_id']}";
		  $result_term = mysql_query($sql_term) or die(mysql_error());
		  $row = mysql_fetch_array($result_term);
		  echo $row['sum'];
		} else {
		  echo $this_term['times_school_open'];
		}
		echo "
		  </td>
        </tr>
        <tr>
         <td><span class='f'>No. in Class:</span> {$class_count['count']}</td>
         <td><span class='f'>Year:</span> ". get_value('session', 'name', 'id', $_SESSION['session_id'], $con) . "</td>
         <td>&nbsp;</td>
         <td><span class='f'>Times Present:</span> ";
		if ($_REQUEST['term_id'] == '0') {
	     echo  ($student['first_term_times_present'] + $student['second_term_times_present'] + $student['third_term_times_present']);
	   } else if ($term_array[$_REQUEST['term_id']] == 'First') {
	     echo $student['first_term_times_present'];
	   } else if ($term_array[$_REQUEST['term_id']] == 'Second') {
	     echo $student['second_term_times_present'];
	   } else if ($term_array[$_REQUEST['term_id']] == 'Third') {
	     echo $student['third_term_times_present'];
	   } 
		echo "
		</td>
        </tr>
        <tr>
         <td><span class='f'>Sex:</span> {$student['gender']}</td>
         <td><span class='f'>Age:</span>
		";
        $today = gettimeofday();
		$date_of_birth = $student['date_of_birth'];
		$data = explode("-", $date_of_birth);
       
        $date_of_birth = mktime(0, 0, 0, $data[1], $data[2], $data[0]);

        //$date_of_birth = mktime(0, 0, 0, 07, 23, 1980);
        echo calc_age($today['sec'], $date_of_birth);
		echo 
        "
 		 </td>
         <td>&nbsp;</td>
         <td><span class='f'>Times Absent:</span>
       ";
	   if ($_REQUEST['term_id'] == '0') {
	     echo  ($student['first_term_times_absent'] + $student['second_term_times_absent'] + $student['third_term_times_absent']);
	   } else if ($term_array[$_REQUEST['term_id']] == 'First') {
	     echo $student['first_term_times_absent'];
	   } else if ($term_array[$_REQUEST['term_id']] == 'Second') {
	     echo $student['second_term_times_absent'];
	   } else if ($term_array[$_REQUEST['term_id']] == 'Third') {
	     echo $student['third_term_times_absent'];
	   }
	   echo "
		</td>
        </tr>
       </table>
      </td>
      <td>
       <img src='upload/{$student['passport']}' width='80' height='80'>
      </td>
	 </tr>
	</table>
   </td>
  </tr>";
  if ($_REQUEST['term_id'] == '0') {
    echo "<tr>
   <td style='width: 100%; height: 701px;'>
    <table width='100%' height='717' valign='top' class='t'>
     <tr>
      <td valign='top'>
       <table width='100%' border='1' style='table-layout:row; text-align:center;' valign='top'>
       <tr style='height:0px;'>
	    <th>Subject</th>
	    <th><img src='images/first_term_total.png'></th>
	    <th><img src='images/second_term_total.png'></th>
	    <th><img src='images/third_term_total.png'></th>
	    <th><img src='images/total.png'></th>
		<th><img src='images/highest.png'></th>
	    <th><img src='images/lowest.png'></th>
	    <th><img src='images/average.png'></th>
	    <th><img src='images/position.png'></th>
	    <th><img src='images/teachers_signature.png'></th>
       </tr> 
    ";
    $marks_obtained = get_marks_obtained('0');
    
    //Initialize array of students/marks
    $total_number_of_subjects = 0;
    $sql="Select sb.id, sb.name, sb.type from subject sb 
     join (class c, student s) on (sb.type = c.type
      and s.current_class_id = c.id) where 
	  c.id = {$_REQUEST['class_id']}
	  and s.id={$student['id']}";
    //echo "$sql<br>";
    $result = mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
	 echo "
	   <tr>
	    <td style='text-align:left;'>{$row['name']}</td>";
	 $subject = get_marks_obtained($_REQUEST['class_id']);
     foreach($term_array as $term_id => $name) {
       $sql1 = "select * from student_subject where 
	    session_id={$_SESSION['session_id']}
	    and term_id =$term_id
	    and class_id ={$_REQUEST['class_id']}
	    and subject_id={$row['id']}";
	   //echo "$sql1<br>";
	   $result1 = mysql_query($sql1) or die(mysql_error());
	   if (mysql_num_rows($result1) > 0) {
	     while($row1 = mysql_fetch_array($result1)) {
	       $total = $row1['test'] + $row1['exam'];
		   $subject[$row1['student_id']] += $total;
		   //print_r($subject);
	       $marks_obtained[$row1['student_id']] += $total;
	       if ($row1['student_id'] == $student['id']) {
	         echo "<td>$total</td>";
		   }	   
		 }
	   } else {
	     echo "<td>0</td>";
	   }
	 } //End of term loop
	 //print_r($subject);
	 echo "
	  <td>{$subject[$student['id']]}</td>
	  <td><div id='h_{$student['id']}_{$row['id']}'></div></td>
	  <td><div id='l_{$student['id']}_{$row['id']}'></div></td>
	  <td><div id='a_{$student['id']}_{$row['id']}'></div></td>
	  <td><div id='p_{$student['id']}_{$row['id']}'></div></td>
	  <td>&nbsp;</td>
	 ";
	 echo "</tr>";
	 
	 //Calculate highest, lowest, average, position for a subject
     $max = max($subject);
     $min = min($subject);
     $avg = round(array_sum($subject) / count($subject));
	 
	 echo "<script type='text/javascript'>\n";
     echo "document.getElementById('h_{$student['id']}_{$row['id']}').innerHTML=$max;\n";
     echo "document.getElementById('l_{$student['id']}_{$row['id']}').innerHTML=$min;\n";
     echo "document.getElementById('a_{$student['id']}_{$row['id']}').innerHTML=$avg;\n";
  
     //If scores has not been entered for anybody
     //then all positions are zero
  
     if (array_sum($subject) == 0) {
       $i='0';
       while (list($key, $val) = each($subject)) {
	    if ($key == $student['id'])
          echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML='$i';\n";
       }
     } else {
      //Calculate position for each student
	  $total_number_of_subjects++;
      arsort($subject);
      reset($subject);
      $i = 1;
      while (list($key, $val) = each($subject)) {
        if ($key == $student['id'])
          echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML=$i;\n";
        $i++;
      }
    }
    echo "</script>\n";	
	//print_r($subject);
	//exit;
    }//End of subject loop
	//Begin processing of cummulative non-academic 
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
  $sql="select * from non_academic";
  $result_non = mysql_query($sql) or die(mysql_error());
  while ($row_non = mysql_fetch_array($result_non)) {
    $sql = "select sum(score) as 'sum' from student_non_academic
      where session_id={$_SESSION['session_id']}
	  and class_id={$_REQUEST['class_id']}
	  and student_id={$student['id']} 
	  and non_academic_id={$row_non['id']} order by id";
	  //echo "$sql<br>";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      while($row = mysql_fetch_array($result)) {
	    echo "
	       <tr style='text-align:center;'>
	       <th style='text-align:left;'><span class='style4'>{$row_non['name']}</span></th>";
	    echo grade_non_academic($row['sum']/3) . "</tr>";   
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
  }
 } //End of cummulative result
  else {
  echo "
  <tr>
   <td style='width: 100%; height: 701px;'>
    <table width='100%' height='717' valign='top' class='t'>
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
  $marks_obtained = get_marks_obtained('0');
  
  //Initialize array of students/marks
  $total_number_of_subjects = 0;
  $sql="Select sb.id, sb.name, sb.type from subject sb 
   join (class c, student s) on (sb.type = c.type
    and s.current_class_id = c.id) where 
	 c.id = {$_REQUEST['class_id']}
	 and s.id={$student['id']}";
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
	//echo "$sql1<br>";
	$subject = array();
	$result1 = mysql_query($sql1) or die(mysql_error());
	if (mysql_num_rows($result1) > 0) {
	  while($row1 = mysql_fetch_array($result1)) {
	    $total = $row1['test'] + $row1['exam'];
	    $marks_obtained[$row1['student_id']] += $total;
	  
	    $subject[$row1['student_id']] = $total;
	    if ($row1['student_id'] == $student['id']) {
	      echo "
	       <td>{$row1['test']}</td>
           <td>{$row1['exam']}</td>
		   <td>$total</td>
	       <td>" . grade($total) . "</td>
		   <td><div id='h_{$student['id']}_{$row['id']}'></div></td>
	       <td><div id='l_{$student['id']}_{$row['id']}'></div></td>
	       <td><div id='a_{$student['id']}_{$row['id']}'></div></td>
	       <td><div id='p_{$student['id']}_{$row['id']}'></div></td>
	       <td>&nbsp;</td>
	      </tr>";
		  //++$total_number_of_subjects;
		}
	  }
	} else {
	  $subject[$student['id']] = 0;
	}
  
  //Calculate highest, lowest, average
  $max = max($subject);
  $min = min($subject);
  $avg = round(array_sum($subject) / count($subject));
  
  echo "<script type='text/javascript'>\n";
  
  echo "document.getElementById('h_{$student['id']}_{$row['id']}').innerHTML=$max;\n";
  echo "document.getElementById('l_{$student['id']}_{$row['id']}').innerHTML=$min;\n";
  echo "document.getElementById('a_{$student['id']}_{$row['id']}').innerHTML=$avg;\n";
  
  //If scores has not been entered for anybody
  //then all positions are zero
  
  if (array_sum($subject) == 0) {
    $i='0';
    while (list($key, $val) = each($subject)) {
	  if ($key == $student['id'])
       echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML='$i';\n";
    }
	
  } else {
    //Calculate position for each student
	$total_number_of_subjects++;
    arsort($subject);
    reset($subject);
    $i = 1;
    while (list($key, $val) = each($subject)) {
      if ($key == $student['id'])
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
	and sna.student_id={$student['id']} order by na.id";
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
}//Not cummulative result
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
        <td><span class='f'>Marks obtainable:</span> ";
   if($_REQUEST['term_id'] == '0') 
     $obtainable = $total_number_of_subjects * 300;
   else 
     $obtainable = $total_number_of_subjects * 100;
   echo "
     $obtainable
	</td>
		<td><span class='f'>Marks obtained:</span> {$marks_obtained[$student['id']]}</td>
       </tr> 
       <tr>
	   ";
	   $avg = round(array_sum($marks_obtained) / $class_count['count']);
	   echo "
        <td><span class='f'>Average:</span> $avg</td>
		<td><span class='f'>Position:</span>  
       ";
	   if (array_sum($marks_obtained) == 0) {
         $i='0';
         while (list($key, $val) = each($marks_obtained)) {
	       if ($key == $student['id'])
             echo $i;
         }
       } else {
         //Calculate position for each student
         arsort($marks_obtained);
         reset($marks_obtained);
         $i = 1;
         while (list($key, $val) = each($marks_obtained)) {
           if ($key == $student['id'])
             echo $i;
           $i++;
         }
       }
       echo "
	    
        </td>
		<td><span class='f'>Out of:</span> {$class_count['count']}</td>
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
  </table>
 </td>
</tr>
</table>";
 
  } //End of student loop
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
    $sql ="select * from term where session_id={$_SESSION['session_id']}
	 order by id";
    $result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_array($result)) { 
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
      }
	  echo "<option value='0'>Cummulative</option>";
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
    $sql="select * from class order by name";
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
  
