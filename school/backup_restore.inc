<?php

require_once "util.inc";

function open_session($sessid, $file_name, $con) {
  $sql="create table student_temp_{$sessid}(
		  id integer auto_increment primary key,
		  student_id integer,
		  class_id integer,
		  first_term_times_present varchar(100),
		  first_term_times_absent varchar(100),
		  second_term_times_present varchar(100),
		  second_term_times_absent varchar(100),
		  third_term_times_present varchar(100),
		  third_term_times_absent varchar(100)
		 )";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="create table student_subject_{$sessid}(
		  id integer auto_increment primary key,
		  session_id integer,
		  term_id integer,
		  class_id integer,
		  admission_number varchar(100),
		  subject_id integer,
		  test float,
		  exam float,
		  school_id integer
		 )";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="create table student_comment_{$sessid}(
		  id integer auto_increment primary key,
		  session_id integer,
		  term_id integer,
		  class_id integer,
		  admission_number varchar(100),
		  teacher text,
		  principal text,
		  school_id integer
		 )";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="create table student_non_academic_{$sessid}(
		   id integer auto_increment primary key,
		   admission_number varchar(100),
		   session_id integer references session,
		   term_id integer references term,
		   class_id integer references class,
		   non_academic_id integer references non_academic,
		   score varchar(100),
		   school_id integer
	  )";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="CREATE TABLE student_fees_{$sessid}(
		  id int(11) NOT NULL auto_increment primary key,
		  session_id int(11) default NULL,
		  term_id int(11) default NULL,
		  class_id int(11) default NULL,
		  admission_number varchar(100),
		  date date,
		  amount_paid varchar(100),
		  school_id integer
		)";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="create table fee_class_{$sessid}(
    id integer auto_increment primary key,
    session_id integer,
	term_id integer,
    class_id integer references class,
    amount varchar(100),
	school_id integer
   )";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  load_data($sessid, $file_name);
}
function close_acadbase_session($sessid, $school_id, $session_id, $class_id, $con) {
  $tables = array('student_comment', 'student_fees', 'student_non_academic','student_subject', 'fee_class', 'student_temp');

  foreach($tables as $table_name) {
    $sql="drop table {$table_name}_{$sessid}";
	mysqli_query($con, $sql);
  }
}
function close_special_session($sessid, $school_id, $session_id, $class_id, $con) {
  $tables = array('student_comment', 'student_fees', 'student_non_academic','student_subject', 'student_temp');

  foreach($tables as $table_name) {
    $sql="drop table {$table_name}_{$sessid}";
	mysqli_query($con, $sql);
  }
}

function save_session($sessid, $school_id, $session_id, $class_id, $con) {

  $tables = array('student_comment', 'student_fees', 'student_non_academic','student_subject', 'fee_class', 'student_temp');
  foreach($tables as $table_name) {
      $stc[$table_name] = "select * from {$table_name}_{$sessid}";
  }
  $stc_file = "data/{$school_id}/{$session_id}_{$class_id}.sql";
  store_data($stc, $stc_file);
}


function load_data($sessid, $file) {
 if (file_exists($file)) {
  $lines = file($file);
  $con = connect();
	$un = "";
    foreach ($lines  as $line) {
	  $end_i = substr($line, -3, 2);
	  $end_t = substr($line, -2, 1);
	  $start_i = substr($line, 0, 6);
	  $start_t = substr($line, 0, 8);

	  if ((($start_i == strtoupper('INSERT')) && ($end_i == ");"))
	   || (($start_t == strtoupper('TRUNCATE')) &&($end_t == ";"))) {
	  }
	  if (substr($line, 0, 6) == 'INSERT') {
	    $t = substr($line, 12, strpos(substr($line, 12), "(")) . "_$sessid";
	    $line = substr_replace($line, $t, 12, strpos(substr($line, 12), "("));;
	  }
	  $result = mysqli_query($con, $line) or die(mysqli_error($con));
	  if (!$result) {
	    $un = $un . $line;
	    $endx = substr($un, -3, 2);
	    //echo "Error Executing: $line<br>End is $endx<br><br>";
		 if($endx == ");") {
		  // echo "Complete line $un <br><br>";
		   mysqli_query($con, $un) or die(mysqli_error($con));
		   //echo "Executed completed line $un<br>";
		   $un = "";
		 }
	  }
    }
 }
}

function store_data($tables, $file) {
  $con = connect();

  $fp = fopen($file, "w");
  /*
  if(!chmod($file, 0777))
    die("Failed to chmod file");
  */

  $sql="";
  foreach ($tables as $table_name => $sql1) {
    $result2 = mysqli_query($con, $sql1) or die(mysqli_error($con));
    $num_rows = mysqli_num_rows($result2);
    if ($num_rows == 0)
      continue;
    else {
      while($row = mysqli_fetch_row($result2)) {
	    $x = mysqli_num_fields($result2);
	    $sql .="INSERT INTO $table_name(";

	    //Get row names
	    for($j = 0; $j < $x; $j++) {
	      if ($j == ($x - 1))
	        $sql .= mysqli_fetch_field_direct($result2, $j)->name;
	      else
	        $sql .= mysqli_fetch_field_direct($result2, $j)->name . ", ";
	    }
	    $sql .= ") values (";

	    //Get the row values
	    for($k = 0; $k < $x; $k++) {
	      if ($k == ($x - 1))
                if (mysqli_fetch_field_direct($result2, $k)->type == 'int')
	          $sql .= htmlspecialchars($row[$k], ENT_QUOTES);
	        else
	          $sql .= "'" . htmlspecialchars($row[$k], ENT_QUOTES) . "'";
		  else {
		    if (mysqli_fetch_field_direct($result2, $k)->type == 'int')
		      $sql .= htmlspecialchars($row[$k], ENT_QUOTES) . ", ";
		    else
		      $sql .= " '" . htmlspecialchars($row[$k], ENT_QUOTES) . "', ";
	      }
	    }
		$sql .= ");";
	    fwrite($fp, "$sql\n");
	    //echo "$sql<br>";
        $sql="";
	  }
    }
  }

  fclose($fp);
}
