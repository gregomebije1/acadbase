<?php
function calc_age($curr_secs, $prev_secs) {
$secs = $curr_secs - $prev_secs;
  
  $years = floor($secs / 31449600);
  $secs = $secs % 31449600;
  
  //1 year = 52 weeks
  $weeks = floor($secs / 604800);
  $secs = $secs % 604800;
  
  $days = floor($secs / 86400);
  $secs = $secs % 86400;

  $hours = floor($secs / 3600);
  $secs = $secs % 3600;

  $mins = floor($secs / 60);
  $secs = $secs % 60;
  
  if ($years > 0) {
    if ($years == 1) {
      $temp = "$years year ";
    } else {
      $temp = "$years years ";
    }
  } else if ($weeks > 0) {
    if ($weeks == 1) {
      $temp = "$weeks week ";
    } else {
      $temp = "$weeks weeks ";
    }
  } else if ($days > 0) {
    if ($days == 1) {
      $temp = "$days day ";
    } else {
      $temp = "$days days ";
    }
  } elseif ($hours > 0) {
    if ($hours == 1) {
      $temp = "$hours hour ";
    } else {
        $temp = "$hours hours ";
    }
  } elseif ($mins > 0) {
    if ($mins == 1) {
      $temp = "$mins min ";
    } else {
      $temp = "$mins mins ";
    }
  } else {
    if (($secs == 1) || ($secs == 0)) {
      $temp = "$secs second ";
    } else {
      $temp = "$secs seconds ";
    }
  }
  return $temp;
}
 
 function grade($grade) {
  $sql="select * from grade_settings where 
   low <= $grade and high >= $grade";
  //echo "$sql<br>";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) == 0) {
    return 'Unknown Grade';
  } else {
    $row = mysql_fetch_array($result);
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
   die(mysql_error());
  return mysql_fetch_array($result_test_exam);
}
function get_school_info() {
  $school = array();
  $sql="select * from school_info";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) == 0) {
    $school['name'] = "";
	$school['address'] = "";
	$school['phone'] = "";
	$school['email'] = "";
	$school['web'] = "";
	$school['logo'] = "";
  } else {
    $row = mysql_fetch_array($result);
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
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) == 0) {
    $term['name'] = "";
	$term['begin_date'] = "";
	$term['end_date'] = "";
	$term['session_id'] = "";
	$term['times_school_open'] = "";
  } else {
    $row = mysql_fetch_array($result);
	$term['name'] = $row['name'];
	$term['begin_date'] = $row['begin_date'];
	$term['end_date'] = $row['end_date'];
	$term['session_id'] = $row['session_id'];
	$term['times_school_open'] = $row['times_school_open'];
  }
  return $term;
}

function get_terms($term_id) {
  $sql_term="select * from term where session_id={$_SESSION['session_id']}";
  if ($term_id != '0') {   
    $sql_term .= " and id=$term_id";
  }
  $sql_term .= " order by id asc";
  //echo "$sql_term<br>";
  $result_term = mysql_query($sql_term) or die(mysql_error());
  $term_array = array();
  while ($row_term = mysql_fetch_array($result_term)) {
    $term_array[$row_term['id']] = $row_term['name'];
  }
  return $term_array;
}
function get_marks_obtained($class) {
  $marks_obtained = array();
  if ($class != '0') 
    $sql="select * from student where current_class_id=$class";
  else 
    $sql="select * from student";
  $result = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($result)) {
    $marks_obtained[$row['id']] = 0;
  }
  return $marks_obtained;
}
function get_value($table, $field1, $field2, $field3, $con) {
  $sql="select $field1 from $table where $field2=$field3";
  //echo "$sql<br>";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  return $row[$field1];
}
function get_fee_by_name($name) {
  $sql="select amount from fee_class fc join fee f
   on fc.fee_id = f.id where f.name='$name'";
  $result = mysql_query($sql) or die(mysql_error());
  $row = mysql_fetch_array($result);
  return $row['amount'];
}
function get_all_fees($class_id) {
  $sql="select sum(amount) as 'sum' from fee_class fc join 
   fee f on fc.fee_id = f.id where fc.class_id=$class_id";
  $result = mysql_query($sql) or die(mysql_error());
  $row = mysql_fetch_array($result);
  return $row['sum'];
}
function get_amount_paid($session_id, $term_id, $class_id, $student_id) {
  if ($class_id == 'all_sss_classes') {
   $sql="SELECT sum(sf.amount) as 'sum' FROM student_fee sf
          JOIN (class c, student s) ON (s.current_class_id = c.id
          AND sf.student_id = s.id)  
          WHERE sf.session_id = $session_id 
          AND sf.term_id = $term_id
          and sf.student_id= $student_id 
          and c.type = 'sss'";
  } else if ($class_id == 'all_jss_classes') {
   $sql="SELECT sum(sf.amount) as 'sum' FROM student_fee sf
          JOIN (class c, student s) ON (s.current_class_id = c.id
          AND sf.student_id = s.id)  
          WHERE sf.session_id = $session_id 
          AND sf.term_id = $term_id
          and sf.student_id= $student_id 
          and c.type = 'jss'";
  } else if ($class_id == 'all_classes') {
    $sql="select sum(amount) as 'sum' from student_fee where
      session_id = $session_id   
      and term_id = $term_id
      and student_id=$student_id";
  } else {
    $sql="select sum(amount) as 'sum' from student_fee where 
     session_id=$session_id and term_id=$term_id and 
     class_id=$class_id and student_id=$student_id";
  }
  //echo "$sql<br>";
  $result = mysql_query($sql) or die(mysql_error() . "2222");
  $row = mysql_fetch_array($result);
  return $row['sum'];
}
?>
