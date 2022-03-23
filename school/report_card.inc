<?php
function report_card($sessid, $school_id, $session_id, $term_id, $class_id,
  $admission_number, $command, $url, $con) {

  $school = get_school($school_id); //Get rest of school information
  $this_term = get_term_info($term_id); //Ge this term's information

  //All this is a hack to get the next term
  $term = array();
  $result = mysqli_query($con, "select * from term where school_id={$school_id} order by id") or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result))
    $term[] = $row['id'];

  $key1 = array_search($term_id, $term); //Current term
  $key1++;

  //There must be another term defined for this to work, else I dont know
  //what error it will produce. We need to fix this.
  if (isset($term[$key1]))
    $next_term = get_term_info($term[$key1]);
  else {
    $next_term['name'] = "";
	$next_term['begin_date'] = "";
	$next_term['end_date'] = "";
	$next_term['session_id'] = "";
	$next_term['times_school_open'] = "";
  }

  //Get a count of all Student's in this clas
  //$sql="select count(*) as 'count' from student_{$sessid} where class_id=$class_id and school_id={$school_id}";
  $sql="select count(*) as 'count' from student_temp_{$sessid} where class_id=$class_id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_count = mysqli_fetch_array($result);

  if ($admission_number == '0') {
    //This should allow you to process all the Student's in this class
    $sql="select s.id, s.admission_number, s.firstname, s.lastname, s.date_of_birth,
	 s.gender, s.house, s.state_of_origin, s.scholarship, s.passport_image, s.school_id, st.class_id,
	 st.first_term_times_present, st.first_term_times_absent, st.second_term_times_present,
	 st.second_term_times_absent, st.third_term_times_present, st.third_term_times_absent
	 from student_temp_{$sessid} st join student s on s.id = st.student_id
	 where st.class_id=$class_id and s.school_id={$school_id}";
  } else {
    //Process only one Student
	$sql="select s.id, s.admission_number, s.firstname, s.lastname, s.date_of_birth,
	 s.gender, s.house, s.state_of_origin, s.scholarship, s.passport_image, s.school_id, st.class_id,
	 st.first_term_times_present, st.first_term_times_absent, st.second_term_times_present,
	 st.second_term_times_absent, st.third_term_times_present, st.third_term_times_absent
	 from student_temp_{$sessid} st join student s on s.id = st.student_id
	 where s.admission_number=$admission_number and st.class_id=$class_id and s.school_id={$school_id}";
  }

  $term_array = get_terms($session_id, 0); //Get info about all the terms
  $result_student = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($student = mysqli_fetch_array($result_student)) {
    echo "<table border='1' style='width:100%;'>
     <tr>
    ";

    //If command for printing is not set, then display printer Iconc
    if (!isset($command)) {
      echo "
       <td>
        <span style='position:absolute;top:0px;left:100px;'>
	 <a style='cursor:hand;' onclick='window.open(\"" . $url . "?action=Submit&school_id=$school_id&session_id=$session_id&term_id=$term_id&class_id=$class_id&student_name=$admission_number&admission_numbe=$admission_number&command=Print\", \"smallwin\",
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
         <td>
          <img src='upload/{$school['logo']}' width='100px' height='100px'></td>
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

     <tr>
      <td colspan='2' style='font-weight:bolder; text-align:center;'>
        {$this_term['name']} TERM</td></tr>
     <tr><td colspan='2' style='text-align:center;'>
        END OF {$this_term['name']} TERM REPORT SHEET:
      <span style='font-weight:bold;'>&nbsp;&nbsp;&nbsp;NEXT TERM BEGINS:</span>
        {$next_term['begin_date']}
      </td>
     </tr>";

    echo "
     <tr>
      <td style='width:100%;'>
       <table>
	<tr>
         <td style='width:100%;'>
          <table style='border-spacing:0.1em;' width='100%' class='t'>
           <tr><td colspan='4'><span style='font-weight:bold;'>Name</span>
            <span style='font-style:italic;'>(Surname First):</span>
             {$student['firstname']} {$student['lastname']}</td></tr>
           <tr>
            <td><span class='f'>Admission No:</span>
             {$student['admission_number']}</td>
            <td><span class='f'>Class:</span> "
             . get_value('class', 'name', 'id', $class_id, $con) . "</td>
            <td><span class='f'>House:</span> {$student['house']}</td>
            <td><span class='f'>Times School Open:</span>
              {$this_term['times_school_open']}</td>
           </tr>
           <tr>
           <td><span class='f'>No. in Class:</span> {$class_count['count']}</td>
           <td><span class='f'>Year:</span> "
             . get_value('session', 'name', 'id', $session_id, $con) . "</td>
           <td>&nbsp;</td>
           <td><span class='f'>Times Present:</span> ";

    if ($term_array[$term_id] == 'FIRST')
      echo $student['first_term_times_present'];
    else if ($term_array[$term_id] == 'SECOND')
      echo $student['second_term_times_present'];
    else if ($term_array[$term_id] == 'THIRD')
      echo $student['third_term_times_present'];

    echo "
      </td>
     </tr>
     <tr>
      <td><span class='f'>Sex:</span> {$student['gender']}</td>";

     /*** Display Age. Is this correct?***/
     $sql="SELECT firstname, lastname,  (YEAR(CURRENT_DATE)-YEAR(date_of_birth))  - (RIGHT(CURRENT_DATE,5)<RIGHT(date_of_birth,5))  AS age from student where id={$student['id']}";
     $result_age = mysqli_query($con, $sql) or die(mysqli_error($con));
     $row_age = mysqli_fetch_array($result_age);

    echo "
     <td><span class='f'>Age:</span> {$row_age['age']} years</td>
     <td>&nbsp;</td>
      <td><span class='f'>Times Absent:</span>
    ";
	   if ($term_array[$term_id] == 'FIRST') {
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
		";
		//If third term, display cummulative average
		if ($term_array[$term_id] == 'THIRD') {
	      echo "<th><img src='images/cum_average.png'></th>";
		}

		echo "
	    <th><img src='images/position.png'></th>
	    <th><img src='images/teachers_signature.png'></th>
       </tr>
  ";

  $marks_obtained = get_marks_obtained($sessid, $class_id);

  $marks_obtained_first_term = get_marks_obtained($sessid, $class_id);
  $marks_obtained_second_term = get_marks_obtained($sessid,  $class_id);
  $marks_obtained_third_term = get_marks_obtained($sessid, $class_id);

  $cum_marks_obtained = get_marks_obtained($sessid, $class_id);
  $cum_subject = get_marks_obtained($sessid, $class_id);
  $position = get_marks_obtained($sessid, $class_id);

  //Initialize array of students/marks
  //Get all the subjects for this Class for this Student
  $sql="Select sb.id, sb.name, sb.class_type_id from subject sb
    join (class c, student_temp_{$sessid} st, student s) on (sb.class_type_id = c.class_type_id
    and s.id = st.student_id and st.class_id = c.id ) where
     c.id = $class_id
    and s.admission_number ='{$student['admission_number']}'
	and s.school_id={$school_id} group by id order by id";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while ($row = mysqli_fetch_array($result)) {
    echo "
	 <tr>
	  <td style='text-align:left;'>{$row['name']}</td>";

       $sql1 = "select * from student_subject_{$sessid} where
	    session_id=$session_id
	    and term_id =$term_id
	    and class_id =$class_id
	    and subject_id={$row['id']}
		and school_id={$school_id}";

    $subject = array();

    $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
    if (mysqli_num_rows($result1) > 0) {
      while($row1 = mysqli_fetch_array($result1)) {
        $total = $row1['test'] + $row1['exam'];

		$marks_obtained[trim($row1['admission_number'])] += $total;
	    $subject[$row1['admission_number']] = $total;
	    if ($row1['admission_number'] == $student['admission_number']) {
	      echo "
	       <td>{$row1['test']}</td>
           <td>{$row1['exam']}</td>
	       <td>$total</td>
	       <td>" . grade($total) . "</td>";

	     echo"
	      <td><div id='h_{$student['admission_number']}_{$row['id']}'></div></td>
	      <td><div id='l_{$student['admission_number']}_{$row['id']}'></div></td>
	      <td><div id='a_{$student['admission_number']}_{$row['id']}'></div></td>";


	  if ($term_array[$term_id] == 'THIRD') {
        $totalc = 0;
	    foreach($term_array as $term_id1 => $name) {
          $sql = "select * from student_subject_{$sessid} where
	       session_id=$session_id
	       and term_id =$term_id1
	       and class_id =$class_id
	       and subject_id={$row['id']}
		   and school_id={$school_id}";
	      $resultc = mysqli_query($con, $sql) or die(mysqli_error($con));
	      if (mysqli_num_rows($resultc) > 0) {
	        while($rowc = mysqli_fetch_array($resultc)) {
	          if ($rowc['admission_number']== $student['admission_number']){
	            $totalc += $rowc['test'] + $rowc['exam'];
		      }
		      if ($name == 'FIRST') {
		        $marks_obtained_first_term[trim($rowc['admission_number'])] += ($rowc['test'] + $rowc['exam']);
		        //$marks_obtained_first_term[$rowc['admission_number']] += ($rowc['test'] + $rowc['exam']);
              }
	          if ($name == 'SECOND')  {
		        $marks_obtained_second_term[trim($rowc['admission_number'])] += ($rowc['test'] + $rowc['exam']);
		        //$marks_obtained_second_term[$rowc['admission_number']] += ($rowc['test'] + $rowc['exam']);
		      }
		      if ($name == 'THIRD')  {
		        $marks_obtained_third_term[trim($rowc['admission_number'])] += ($rowc['test'] + $rowc['exam']);
		       //$marks_obtained_third_term[$rowc['admission_number']] += ($rowc['test'] + $rowc['exam']);
		      }
			  $cum_marks_obtained[trim($rowc['admission_number'])] += ($rowc['test'] + $rowc['exam']);
		      //$cum_marks_obtained[$rowc['admission_number']] += (($rowc['test'] + $rowc['exam'])/3);
	        }
	      }
	    }
	    echo "<td>" . number_format($totalc/3, 1) . "</td>";
	  }
	  /* End of computing Cummulative average for each subject*/

	  echo "
	   <td><div id='p_{$student['admission_number']}_{$row['id']}'></div></td>
	   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  </tr>";
	}
      }
    } else {
      $subject[$student['admission_number']] = 0;

      //If third term
      if ($term_array[$term_id] == 'THIRD')
        $cum_subject[$student['admission_number']] = 0;
    }

    //Calculate highest, lowest, average
    $max = max($subject);
    $min = min($subject);
    $avg = round(array_sum($subject) / count($subject));

    echo "<script type='text/javascript'>\n";

    echo "document.getElementById('h_{$student['admission_number']}_{$row['id']}').innerHTML=$max;\n";
    echo "document.getElementById('l_{$student['admission_number']}_{$row['id']}').innerHTML=$min;\n";
    echo "document.getElementById('a_{$student['admission_number']}_{$row['id']}').innerHTML=$avg;\n";

    //If scores has not been entered for anybody
    //then all positions are zero

    if (array_sum($subject) == 0) {
      $i='0';
      while (list($key, $val) = each($subject)) {
        if ($key == $student['admission_number'])
          echo "document.getElementById('p_{$key}_{$row['id']}').innerHTML='$i';\n";
      }
    } else {
      //Calculate position for each student
      //$total_number_of_subjects++;
      arsort($subject);
      reset($subject);
      $i = 1;
      while (list($key, $val) = each($subject)) {
        if ($key == $student['admission_number'])
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
   join student_non_academic_{$sessid} sna on na.id = sna.non_academic_id
   where sna.session_id=$session_id and na.school_id = {$student['school_id']}
    and sna.term_id=$term_id
    and sna.class_id=$class_id
    and sna.admission_number={$student['admission_number']}
	and sna.school_id={$school_id} order by na.id";
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

   $sql="select count(*) as 'count' from student_subject_{$sessid} where admission_number={$student['admission_number']} and session_id={$session_id} and term_id={$term_id}";

   $result_count = mysqli_query($con, $sql) or die(mysqli_error($con));
   $subject_count = mysqli_fetch_array($result_count);
   $total_number_of_subjects = $subject_count['count'];

   echo "<td><span class='f'>Total number of subjects:</span> $total_number_of_subjects</td>
        <td><span class='f'>Marks obtainable:</span> ";

   $obtainable = $total_number_of_subjects * 100;

   echo "
     $obtainable
	</td>
		<td><span class='f'>Marks obtained:</span> {$marks_obtained[$student['admission_number']]}</td>
       </tr>
       <tr>
	   ";

	   if (($term_array[$term_id] == 'THIRD') && ($total_number_of_subjects != 0))
	     $cum_avg = $cum_marks_obtained[$student['admission_number']] / $total_number_of_subjects;

	   if ($total_number_of_subjects != 0)
	     $avg = $marks_obtained[$student['admission_number']] / $total_number_of_subjects;


	   $position = array();
	   $cum_position = array();

	   if ($term_array[$term_id] == 'THIRD') {
	     //Lets store the average cummulative total for this particular student
	     while (list($key, $val) = each($cum_marks_obtained)) {
		   if ($val == 0)
		     $cum_position[$key] = 0;
		   else {
		     if ($cum_avg != 0)
		       $cum_position[$key] = $val / $cum_avg;
		    }
	     }
	   }

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
          <td><span class='f'>Average:</span> " . number_format($avg,2) . "&nbsp;&nbsp;";


	  //Lets get the total number of subjects for each term
	  $total_num_of_sub = array();
	  if ($term_array[$term_id] == 'THIRD') {
	    foreach($term_array as $term_id1 => $name) {
		  $total_num_of_sub[$term_id1] = 0;
		}
		foreach($term_array as $term_id1 => $name) {
	      $sql="select count(*) as 'count' from student_subject_{$sessid} where admission_number={$student['admission_number']} and session_id={$session_id} and term_id={$term_id1} and school_id={$school_id}";
		  $result_countx = mysqli_query($con, $sql) or die(mysqli_error($con));
          $subject_countx = mysqli_fetch_array($result_countx);
          $total_num_of_sub[$term_id1] = $subject_countx['count'];
	    }
	  }


	  //Lets compute the Cummulative Average for this student
	  $cum_total = 0;
	  if ($term_array[$term_id] == 'THIRD') {
        foreach($term_array as $term_id1 => $name) {
	      if ($name == 'FIRST')
	        $cum_total += $marks_obtained_first_term[$student['admission_number']]/$total_num_of_sub[$term_id1];

	      if ($name == 'SECOND')
	        $cum_total += $marks_obtained_second_term[$student['admission_number']]/$total_num_of_sub[$term_id1];

	      if ($name == 'THIRD')
	        $cum_total += $marks_obtained_third_term[$student['admission_number']]/$total_num_of_sub[$term_id1];

	    }
	  echo "<span class='f'>Cum. Average:</span> " . number_format($cum_total/3, 1);
	  }
	  echo "</td>";

	  echo "<td><span class='f'>Position:</span>  ";

	   if (array_sum($position) == 0) {
         $i='0';
         while (list($key, $val) = each($position)) {
	       if ($key == $student['admission_number'])
             echo $i;
         }
       } else {

         //Calculate position for each student
         //arsort($marks_obtained);
         //reset($marks_obtained);
		 arsort($position);
         reset($position);

		 $i = 1;
   	     while (list($key, $val) = each($position)) {
           if ($key == $student['admission_number'])
             echo $i;
           $i++;
         }
       }

	   if ($term_array[$term_id] == 'THIRD') {
         echo "&nbsp;&nbsp;<span class='f'>Cum. Position:</span> ";

	     //Compute Cummulative Position
	     arsort($cum_position);
         reset($cum_position);

	     $i = 1;
   	     while (list($key, $val) = each($cum_position)) {
           if ($key == $student['admission_number'])
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

		  $sql="select * from student_comment_{$sessid}
		    where session_id=$session_id
            and term_id=$term_id
	        and class_id=$class_id
	        and admission_number = {$student['admission_number']}";
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
<!--<tr style='text-align:center;'><td colspan='3'>Registered with the Ministry of Education</td></tr>-->
</table>";
  } //End of student loop
}

function print_starter() {
echo "<html>
<head>
 <style>
  .a {
    font-size:2em;
	font-weight:800;
  }
  .b {
    font-size:0.7em;
	font-weight:800;
	position:relative;
	top:2px;
	left:20px;
  }
  .c {
    font-size:0.8em;
	position:relative;
	top:3px;
	left:10px;
  }
  .d {
    position:absolute;
	top:32px;
	left:298px;
	border: 1px solid black;
	width:40%;
	height:40%;
  }
  .e {
    font-size:1.5em;
	font-weight:bolder;
	position:relative;
	top:30px;
	left:70px;
  }
  .f {
    font-weight:bold;
  }
    table {
       color:black;
       background-color: white;
       border-width:1px;
       text-align: left;
       padding: 0;
       /*width:50%;*/
       table-layout: float;
       border: #d6e8ff 0.1em solid;
       border-collapse:collapse;
     }
.style4 {font-size: xx-small}
 </style>
</head>
<body>
";
}
?>
