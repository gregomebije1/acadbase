<?php
include_once('util.inc');

  
function check_session_variables($referer, $con) {
  $extra_input = "<input type='hidden' name='action' value='Add'>
    <input type='hidden' name='REFERER' value='$referer'>";
  //my_redirect("term.php?action=Add&REFERER=$referer",'');
  
  if (mysqli_num_rows(mysql_query("select * from session where school_id={$_SESSION['school_id']}", $con)) < 1) {
    my_redirect("session.php", $extra_input);
    exit;
  }

  if (mysqli_num_rows(mysql_query("select * from term where school_id={$_SESSION['school_id']}", $con)) < 1) {
    my_redirect("term.php", $extra_input);
    exit;
  }
  
  if (mysqli_num_rows(mysql_query("select * from class where school_id={$_SESSION['school_id']}", $con)) < 1) {
	my_redirect("class.php", $extra_input);
    exit;
  }
  
  if ((!isset($_SESSION['session_id'])) || (!isset($_SESSION['term_id'])) 
    || (!isset($_SESSION['class_id']))){
	my_redirect("choose_session_term_class.php", $extra_input);
    exit;
  }
}

	
function get_subject_id($subject_name, $class_id, $school_id, $con) { 
  $sql="select s.id from subject s join class c on s.class_type_id = c.class_type_id
   where s.name='$subject_name' and s.school_id=$school_id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  return $row['id'];
}
function decode_student_id($text, $con) {
  $data = explode("_", $text);
  $sql="select id from student where admission_number='{$data[0]}'
    and firstname='{$data[1]}' and lastname='{$data[2]}'";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
	return $row['id'];
  } else 
    return 0;
}

 
 function grade($grade) {
  $sql="select * from grade_settings where 
   low <= $grade and high >= $grade";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) == 0) {
    return 'Unknown Grade';
  } else {
    $row = mysqli_fetch_array($result);
	return $row['name'];
  }
}
function grade_non_academic($score) {
  for($i=1; $i <= 5; $i++) {
    if ($i == $score) 
	  echo "<td><span class='style4'>X</span></td>";
	else 
	  echo "<td><span class='style4'></span></td>";
  }
}
function get_row_test_exam() {
  $result_test_exam = mysql_query("select * from test_exam_settings") or 
   die(mysqli_error($con));
  return mysqli_fetch_array($result_test_exam);
}
function get_school() {
  $school = array();
  $sql="select * from school";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $school['name'] = $row['name'];
    $school['address'] = $row['address'];
    $school['phone'] = $row['phone'];
    $school['email'] = $row['email'];
    $school['web'] = $row['web'];
    $school['logo'] = $row['logo'];
  }
  return $school;
}

function get_term_info($id) {
  $term = array();
  $sql="select * from term where id=$id";
    
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) == 0) {
    $term['name'] = "";
	$term['begin_date'] = "";
	$term['end_date'] = "";
	$term['session_id'] = "";
	$term['times_school_open'] = "";
  } else {
    $row = mysqli_fetch_array($result);
	$term['name'] = $row['name'];
	$term['begin_date'] = $row['begin_date'];
	$term['end_date'] = $row['end_date'];
	$term['session_id'] = $row['session_id'];
	$term['times_school_open'] = $row['times_school_open'];
  }
  return $term;
}

function get_terms($session_id, $term_id) {
  $sql_term="select * from term where session_id=$session_id";
  if ($term_id != '0') {   
    $sql_term .= " and id=$term_id";
  }
  $sql_term .= " order by id asc";
  
  $result_term = mysql_query($sql_term) or die(mysqli_error($con));
  $term_array = array();
  while ($row_term = mysqli_fetch_array($result_term)) {
    $term_array[$row_term['id']] = $row_term['name'];
  }
  
  return $term_array;
}
function get_total_subjects_per_student($class_id, $student_id) {
  $sql="select count(*) as 'count' from student s join student_subject ss 
   on (s.id = ss.student_id) where ss.class_id=$class_id
   and s.id=$student_id";
	 
   $result_count = mysqli_query($con, $sql) or die(mysqli_error($con));
   $subject_count = mysqli_fetch_array($result_count);
   return $subject_count['count'];
}
   
function get_marks_obtained($class) {
  $marks_obtained = array();
  if ($class != '0') 
    $sql="select * from student where class_id=$class";
  else 
    $sql="select * from student";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    $marks_obtained[$row['id']] = 0;
  }
  return $marks_obtained;
}
function get_fee_by_name($name) {
  $sql="select amount from fee_class fc join fee f
   on fc.fee_id = f.id where f.name='$name'";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  return $row['amount'];
}
function get_all_fees($class_id) {
  $sql="select sum(amount) as 'sum' from fee_class fc join 
   fee f on fc.fee_id = f.id where fc.class_id=$class_id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  return $row['sum'];
}
function report_card($session_id, $term_id, $class_id, $student_id, $command, $url, $con) {

  $school = get_school();
  $this_term = get_term_info($term_id);

  //All this is a hack to get the next term  
  $term = array();
  $sql="select * from term";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result))
    $term[] = $row['id'];
  
  $key1 = array_search($term_id, $term); //Current term 
  ++$key1;
  
  //There must be another term defined.
  $next_term = get_term_info($term[$key1]);
  
  //Check if the result is for the current class of the student, or a previous class
  if ($student_id == '0') 
    $sqlq="select count(*) as 'count' from student where class_id=$class_id";
  else {
    $sql="select * from student where class_id=$class_id and id=$student_id";
	if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
      //If true, count the number of students in the current class
      $sqlq="select count(*) as 'count' from student where class_id=$class_id";
    } else {
      //If false get the Class Count from student_history, which was put there during a previous promotion/demotion
      $sqlq="select class_count as 'count' from student_history where session_id=$session_id";
      $sqlq += " and term_id=$term_id and class_id=$class_id and student_id=$student_id";
    }
  }
  $result = mysql_query($sqlq) or die(mysqli_error($con));
  $class_count = mysqli_fetch_array($result);
  
  if ($student_id == '0') {
    $sql="select * from student where class_id=$class_id"; 
  } else {
    $sql="select * from student where id =$student_id";
  }
  
  $term_array = get_terms($session_id, 0);	
  //print_r($term_array);
  $result_student = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($student = mysqli_fetch_array($result_student)) {
    echo "<table border='1' style='width:100%;'>
     <tr>
    ";
    if (!isset($command)) {
      echo "
	   <td>
        <span style='position:absolute;top:0px;left:100px;'>
		 <a style='cursor:hand;' onclick='window.open(\"" . $url . "?action=Submit&session_id=$session_id&term_id=$term_id&class_id=$class_id&student_name=$student_id&student_id=$student_id&command=Print\", \"smallwin\", 
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
	 if ($term_id == '0') {
	   //Process cummulative terms
	   echo "
	   <tr>
	    <td colspan='2' style='font-weight:bolder; font-size:1em; text-align:center;'>CUMULLATIVE TERMS</td>
	   </tr>
	   ";
	 } else {
	   echo "
     <tr>
	  <td colspan='2' style='font-weight:bolder; text-align:center;'>{$this_term['name']} TERM</td></tr>
     <tr><td colspan='2' style='text-align:center;'>END OF {$this_term['name']} TERM REPORT SHEET:
       <span style='font-weight:bold;'>&nbsp;&nbsp;&nbsp;NEXT TERM BEGINS:</span>
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
         <td><span class='f'>Class:</span> " . get_value('class', 'name', 'id', $class_id, $con) . "</td>
         <td><span class='f'>House:</span> {$student['house']}</td>
         <td><span class='f'>Times School Open:</span> 
	 ";
	    if ($term_id == '0') {
		  //Newest Change $sql_term="select sum(times_school_open) as 'sum' from term where session_id={$_SESSION['session_id']}";
		  $sql_term="select sum(times_school_open) as 'sum' from term where session_id={$session_id}";
                 
		  $result_term = mysql_query($sql_term) or die(mysqli_error($con));
		  $row = mysqli_fetch_array($result_term);
		  echo $row['sum'];
		} else {
		  echo $this_term['times_school_open'];
		}
		echo "
		  </td>
        </tr>
        <tr>
         <td><span class='f'>No. in Class:</span> {$class_count['count']}</td>
         <td><span class='f'>Year:</span> ". get_value('session', 'name', 'id', $session_id, $con) . "</td>
         <td>&nbsp;</td>
         <td><span class='f'>Times Present:</span> ";
		 
		if ($term_id == '0') {
	     echo  ($student['first_term_times_present'] + $student['second_term_times_present'] + $student['third_term_times_present']);
	   } else if ($term_array[$term_id] == 'FIRST') { 
	     echo $student['first_term_times_present'];
	   } else if ($term_array[$term_id] == 'SECOND') {
	     echo $student['second_term_times_present'];
	   } else if ($term_array[$term_id] == 'THIRD') {
	     echo $student['third_term_times_present'];
	   } 
		echo "
		</td>
        </tr>
        <tr>
         <td><span class='f'>Sex:</span> {$student['gender']}</td>
         <td><span class='f'>Age:</span>{$student['age']} years</td>
		";
		
		echo 
        "
         <td>&nbsp;</td>
         <td><span class='f'>Times Absent:</span>
       ";
	   if ($term_id == '0') {
	     echo  ($student['first_term_times_absent'] + $student['second_term_times_absent'] + $student['third_term_times_absent']);
	   } else if ($term_array[$term_id] == 'FIRST') {
	     echo $student['first_term_times_absent'];
	   } else if ($term_array[$term_id] == 'SECOND') {
	     echo $student['second_term_times_absent'];
	   } else if ($term_array[$term_id] == 'THIRD') {
	     echo $student['third_term_times_absent'];
	   }
	   echo "
		</td>
        </tr>
       </table>
      </td>
      <td>
       <img src='upload/{$student['passport_image']}' width='80' height='80'>
      </td>
	 </tr>
	</table>
   </td>
  </tr>";
  if ($term_id == '0') {
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
	$position = get_marks_obtained('0');
 
    //Initialize array of students/marks
    $sql="Select sb.id, sb.name, sb.class_type_id from subject sb 
     join (class c, student s) on (sb.class_type_id = c.class_type_id
      and s.class_id = c.id) where 
	  c.id = $class_id and s.id={$student['id']} order by sb.id";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result)) {
	 echo "
	   <tr>
	    <td style='text-align:left;'>{$row['name']}</td>";
		
	 $subject = get_marks_obtained($class_id);
     foreach($term_array as $term_id => $name) {
       $sql1 = "select * from student_subject where 
	    session_id=$session_id
	    and term_id =$term_id
	    and class_id =$class_id
	    and subject_id={$row['id']}";
	   $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
	   if (mysqli_num_rows($result1) > 0) {
	     while($row1 = mysqli_fetch_array($result1)) {
	       $total = $row1['test'] + $row1['exam'];
		   $subject[$row1['student_id']] += $total;
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
	  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
   <td width='24%'>
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
  $sql="select * from non_academic where school_id='{$student['school_id']}'";

  $result_non = mysqli_query($con, $sql) or die(mysqli_error($con));
  while ($row_non = mysqli_fetch_array($result_non)) {
    $sql = "select sum(score) as 'sum' from student_non_academic
      where session_id=$session_id
	  and class_id=$class_id
	  and student_id={$student['id']} 
	  and non_academic_id={$row_non['id']} order by id";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
	    echo "
	       <tr style='text-align:center;'>
	       <th style='text-align:left;'><span class='style4'>{$row_non['name']}</span></th>";
	    echo grade_non_academic($row['sum']/3) . "</tr>";   
      }
    } else {
	  $sql="select * from non_academic where school_id='{$student['school_id']}'";
	  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	  while($row = mysqli_fetch_array($result)) {
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
  $position = get_marks_obtained('0');
  //Initialize array of students/marks

  $sql="Select sb.id, sb.name, sb.class_type_id from subject sb 
   join (class c, student s) on (sb.class_type_id = c.class_type_id
    and s.class_id = c.id) where 
	 c.id = $class_id
	 and s.id={$student['id']} order by id";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while ($row = mysqli_fetch_array($result)) {
    echo "
	 <tr>
	  <td style='text-align:left;'>{$row['name']}</td>";
	 
    $sql1 = "select * from student_subject where 
	 session_id=$session_id
	 and term_id =$term_id
	 and class_id =$class_id
	 and subject_id={$row['id']}";
	
	$subject = array();
	$result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
	if (mysqli_num_rows($result1) > 0) {
	  while($row1 = mysqli_fetch_array($result1)) {
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
	       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	      </tr>";
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
	//$total_number_of_subjects++;
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
   <td width='24%'>
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
   where sna.session_id=$session_id and na.school_id = {$student['school_id']}
    and sna.term_id=$term_id
	and sna.class_id=$class_id
	and sna.student_id={$student['id']} order by na.id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result)) {
      echo "
	 <tr style='text-align:center;'>
	  <th style='text-align:left;'><span class='style4'>{$row['name']}</span></th>";
	  echo grade_non_academic($row['score']) . "</tr>";
    }
  } else {
        $sql="select * from non_academic where school_id='{$student['school_id']}'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result)) {
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
      <table border='0' width='100%'> 
       <tr>
  ";
  /*
  $sql="select count(*) as 'count' from student s join (student_subject ss, subject sb)
   on (s.id = ss.student_id and sb.id = ss.subject_id) where ss.class_id=$class_id
   and s.id={$student['id']}";
   */
   //changes
   /*Newest change$sql="select count(*) as 'count' from student_subject where student_id={$student['id']} and session_id={$_SESSION['session_id']}
    and term_id={$_SESSION['term_id']}";
   */
   $sql="select count(*) as 'count' from student_subject where student_id={$student['id']} and session_id={$session_id} and term_id={$term_id}";
	
   $result_count = mysqli_query($con, $sql) or die(mysqli_error($con));
   $subject_count = mysqli_fetch_array($result_count);
   //$average = $total_score/$subject_count['count'];
   $total_number_of_subjects = $subject_count['count'];
	 
   echo "<td><span class='f'>Total number of subjects:</span> $total_number_of_subjects</td>
        <td><span class='f'>Marks obtainable:</span> ";
   //*Newest change if($_SESSION['term_id'] == '0') 

   if($term_id == '0') 
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
	   //$avg = round(array_sum($marks_obtained) / $class_count['count']);
	   
	   //$avg = round($marks_obtained[$student['id']] / $total_number_of_subjects);
	   $avg = $marks_obtained[$student['id']] / $total_number_of_subjects;
	   $position = array();
	   //Lets store the average total for that particular student
	   while (list($key, $val) = each($marks_obtained)) {
		 
		 if ($val == 0) 
		   $position[$key] = 0;
		 else {
		   if ($avg != 0)
		     $position[$key] = $val / $avg;		   
		  }
	   }
	   echo "
        <td><span class='f'>Average	</span> " . number_format($avg,2) . "</td>
		<td><span class='f'>Position:</span>  
       ";
	   //if (array_sum($marks_obtained) == 0) {
	   if (array_sum($position) == 0) {
         $i='0';
         //while (list($key, $val) = each($marks_obtained)) {
		  while (list($key, $val) = each($position)) {
	       if ($key == $student['id'])
             echo $i;
         }
       } else {
	   
         //Calculate position for each student
         //arsort($marks_obtained);
         //reset($marks_obtained);
		 arsort($position);
         reset($position);
		 
		 $i = 1;
         //while (list($key, $val) = each($marks_obtained)) {
		 while (list($key, $val) = each($position)) {
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
        <td colspan='3' >
		 <table border='1' style='width: 100%; border: solid 1px black;'>";

		  $sql="select * from student_comment 
		    where session_id=$session_id
            and term_id=$term_id
	        and class_id=$class_id
	        and student_id={$student['id']}";
		  $resultc = mysqli_query($con, $sql) or die(mysqli_error($con));
		  $rowc = mysqli_fetch_array($resultc);
		  echo "<tr><td><span class='f'>Class Teacher's comment:</span>&nbsp;";
		  echo "<span style='font-size:0.8em;'>{$rowc['teacher']}</span>";
		  echo "</td></tr>
		  <tr><td><span class='f'>Principal's Comment:</span>&nbsp;";
		  echo "<span style='font-size:0.8em;'>{$rowc['principal']}</span></td></tr>
         </table>
		</td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td height='25' colspan='2'>
       <span class='f'>Grades:</span>
	";
	$sql="select * from grade_settings where school_id={$student['school_id']} order by name";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($result)) {
	  echo "{$row['name']}={$row['low']}-{$row['high']}  ";
	}
	echo "</td>
    </tr>
  </table>
 </td>
</tr>
<tr style='text-align:center;'><td colspan='3'>Registered with the Ministry of Education</td></tr>
</table>";
  } //End of student loop
}

function get_user_type($perm, $con) {
 $result = mysql_query("select * from permissions where id=$perm", $con);
 $row = mysqli_fetch_array($result);
 return $row['name'];
}

function user_type($uid, $users, $con) {
  
  foreach($users as $perm) {
    $sql="select * from permissions p left join 
    (user u, user_permissions up) on (u.id = up.uid and up.pid = p.id) 
    where u.id =$uid and p.name='$perm'";
	
    $result = mysqli_query($con, $sql) or die ("Cannot execute SQL query" . mysqli_error($con));
	if (mysqli_num_rows($result) > 0)
	  return true;
  }
  return false;
}

?>
