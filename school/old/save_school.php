<?php
if(isset($_GET['action']) && ($_REQUEST['action'] == 'Backup')) {
  $filename = "data/{$_SESSION['school_id']}_{$_SESSION['session_id']}_{$_SESSION['term_id']}_{$_SESSION['class_id']}";
  if (file_exists($filename)) 
    unlink($filename);
  
  $fp = fopen($filename, "w+");
    $sql = "";
  $tables = array('student_subject', 'student_comment', 'student_non_academic', 'student_fees');
  foreach($tables as $table) {
    $sqlx="select * from $table where school_id={$_SESSION['school_id']} and session_id={$_SESSION['session_id']}
	  and term_id={$_SESSION['term_id']} and class_id={$_SESSION['class_id']}";
	  
	$result2 = mysql_query($sqlx, $con) or die(mysqli_error($con));
	
    $sql ="TRUNCATE table $table_name;\n";
	
    $num_rows = mysqli_num_rows($result2);
    if ($num_rows == 0) 
      continue;
    else {
      while($row = mysql_fetch_row($result2)) {
        $x = mysql_num_fields($result2);
	  
	    $sql .="INSERT INTO $table_name(";
	    for($j = 0; $j < $x; $j++) {
	      if ($j == ($x - 1)) 
	        $sql .= mysql_field_name($result2, $j);
	       else
	        $sql .= mysql_field_name($result2, $j) . ", ";
	    }
	  $sql .= ") values (";
	  for($k = 0; $k < $x; $k++) {
	    if ($k == ($x - 1))
          if (mysql_field_type($result2, $k) == 'int') 
	        $sql .= htmlspecialchars($row[$k], ENT_QUOTES);
	      else 
	        $sql .= "'" . htmlspecialchars($row[$k], ENT_QUOTES) . "'";
		else {
		  if (mysql_field_type($result2, $k) == 'int') 
		    $sql .= htmlspecialchars($row[$k], ENT_QUOTES) . ", ";
		  else 
		  $sql .= " '" . htmlspecialchars($row[$k], ENT_QUOTES) . "', ";
	    }
	  }
	  $sql .= ");";
	  fwrite($fp, "$sql\n");
      echo "$sql<br>";
      $sql="";
        }
      }
    }
    mysql_free_result($result);
    fclose($fp);