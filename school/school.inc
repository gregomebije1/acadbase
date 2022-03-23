<?php
include_once('util.inc');
include_once "backup_restore.inc";

$con = connect();

function delete_student($admission_number, $con) {
  $extra_caution_sql = "class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";
  $tables = array('student_subject', 'student_comment', 'student_non_academic', 'student_fees');
  foreach($tables as $table) {
    $sql="delete from {$table}_{$_SESSION['sessid']} where admission_number={$admission_number} and $extra_caution_sql";
	mysqli_query($con, $sql) or die(mysqli_error($con));
  }
  //Get Student ID
  $sql="select * from student where admission_number={$admission_number}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);

  //Delete student data in student_temp_{$_SESSION['sessid']}
  $sql="delete from student_temp_{$_SESSION['sessid']} where id={$row['id']}";
  mysqli_query($con, "delete from student where admission_number={$admission_number} and $extra_caution_sql");

  save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);


}

function get_admission_number($text){
  $data = explode("_", $text);
  return $data[0];
}

function check_session_variables($referer, $con) {

  $extra_input = "<input type='hidden' name='action' value='Add'>
    <input type='hidden' name='REFERER' value='$referer'>";
  //my_redirect("term.php?action=Add&REFERER=$referer",'');

  if (mysqli_num_rows(mysqli_query($con, "select * from session where school_id={$_SESSION['school_id']}")) < 1) {
    my_redirect("session.php", $extra_input);
    exit;
  }

  if (mysqli_num_rows(mysqli_query($con, "select * from term where school_id={$_SESSION['school_id']}")) < 1) {
    my_redirect("term.php", $extra_input);
    exit;
  }

  if (mysqli_num_rows(mysqli_query($con, "select * from class where school_id={$_SESSION['school_id']}")) < 1) {
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
   where s.name='$subject_name' and s.school_id=$school_id and c.id={$class_id}";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    return $row['id'];
  } else
    return 0;
}
function decode_student_id($text, $con) {
  $data = explode("_", $text);
  $sql="select * from student where admission_number='{$data[0]}'
    and firstname='{$data[1]}' and lastname='{$data[2]}'";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
	return $row['id'];
  } else
    return 0;
}


 function grade($grade) {

  global $con;
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
  global $con;
  $result_test_exam = mysqli_query($con, "select * from test_exam_settings") or
   die(mysqli_error($con));
  return mysqli_fetch_array($result_test_exam);
}
function get_school($id) {
  global $con;
  $school = array();
  $sql="select * from school where id={$id}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $school['name'] = $row['name'];
    $school['address'] = $row['address'];
    $school['phone'] = $row['phone'];
    $school['email'] = $row['email'];
    $school['website'] = $row['website'];
    $school['logo'] = $row['logo'];
  }
  return $school;
}

function get_term_info($id) {
  global $con;
  $term = array();
  $sql="select * from term where id=$id";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) <= 0) {
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
  global $con;

  $sql_term="select * from term where session_id=$session_id";
  if ($term_id != '0') {
    $sql_term .= " and id=$term_id";
  }
  $sql_term .= " order by id asc";

  $result_term = mysqli_query($con, $sql_term) or die(mysqli_error($con));
  $term_array = array();
  while ($row_term = mysqli_fetch_array($result_term)) {
    $term_array[$row_term['id']] = $row_term['name'];
  }

  return $term_array;
}
function get_total_subjects_per_student($class_id, $student_id) {

  global $con;
  $sql="select count(*) as 'count' from student s join student_subject ss
   on (s.id = ss.student_id) where ss.class_id=$class_id
   and s.id=$student_id";

   $result_count = mysqli_query($con, $sql) or die(mysqli_error($con));
   $subject_count = mysqli_fetch_array($result_count);
   return $subject_count['count'];
}

function get_marks_obtained($sessid, $class) {

  global $con;
  $marks_obtained = array();
  if ($class != '0')
    $sql="select * from student s join student_temp_{$sessid} st on s.id = st.student_id where st.class_id=$class";
  else
    $sql="select * from student s join student_temp_{$sessid} st on s.id = st.student_id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    $marks_obtained["{$row['admission_number']}"] = 0;
  }
  return $marks_obtained;
}
function get_fee_by_name($name) {

  global $con;
  $sql="select amount from fee_class fc join fee f
   on fc.fee_id = f.id where f.name='$name'";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  return $row['amount'];
}

function get_all_fees($class_id) {
  global $con;
  $sql="select sum(amount) as 'sum' from fee_class fc join
   fee f on fc.fee_id = f.id where fc.class_id=$class_id";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  return $row['sum'];
}

function get_user_type($perm, $con) {
 $result = mysqli_query($con, "select * from permissions where id=$perm");
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
