<?php
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();

$sql[]="alter table fee_class add column session_id integer after fee_id";
$sql[]="alter table fee_class add column term_id integer after session_id";
$sql[] = "truncate table fee";
$sql[] = "truncate table fee_class";
$sql[] = "truncate table student_fees";
foreach($sql as $query) {
  mysql_query($query, $con) or die(mysqli_error($con));
  echo "$query<br>";
}
echo "-------------------------------------";

$sql = "select * from school";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)) { 
  
  $sql = "insert into fee (name, school_id) values('Tuition', {$row['id']})";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  echo "$sql<br>";
  echo "-------------------------------------";
  $fee_id = mysqli_insert_id($con);

  $sql="select * from session where school_id={$row['id']}";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row1 = mysqli_fetch_array($result1)) {

    $sql = "select * from term where session_id={$row1['id']}";
    $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
    while($row2 = mysqli_fetch_array($result2)) {

      $sql = "select * from class where school_id={$row['id']}";
      $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
      while($row3 = mysqli_fetch_array($result3)) {
	  
        $sql="insert into fee_class(fee_id, session_id, term_id, class_id, school_id, amount) values 
         ($fee_id, {$row1['id']}, {$row2['id']}, {$row3['id']}, {$row['id']}, '0')";
        mysqli_query($con, $sql) or die(mysqli_error($con));
		echo "$sql<br>";
  
      } //end class
    } //end term
  } //end session
  echo "------------------------------------- <br>";
} //end school
echo "Finished processing<br>";
exit;
?>
