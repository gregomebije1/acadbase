<?php
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();

//Change permision for data
$sql = "select * from school";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)) { 
  if(!mkdir("data/{$row['id']}", 0, true)) {
    die("Failed to create folder {$row['id']}");
  }
  if(!chmod("data/{$row['id']}", 0777)) 
    die("Failed to change mode to data/{$row['id']}");
  
  $st = array();

  $sql="select * from session where school_id={$row['id']}";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row1 = mysqli_fetch_array($result1)) {

      $sql = "select * from class where school_id={$row['id']}";
      $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
      while($row3 = mysqli_fetch_array($result3)) {

	    save_to_file($row['id'], $row1['id'], $row3['id']);
		
        delete_from_database($row['id'], $row1['id'], $row3['id']);

      } //end class
  } //end session
} //end school

/*
//Change permision for data
if(!chmod("data", 0644)) {
  die("Failed to chmod directory data");
}
*/
exit;
?>
