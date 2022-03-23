<?
require_once "util.inc";

$con = connect();

$sql="select * from student_backup";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)) {

  //Calculate the age
  if (empty($row['age']))
    $age = 0;
  else
    $age = $row['age'];
 
  $sql="select date_sub(CURRENT_DATE(), INTERVAL $age YEAR) as 'date_of_birth'";
  echo "$sql\n";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row1 = mysqli_fetch_array($result1);

  //Set the date
  $sql="update student set date_of_birth='{$row1['date_of_birth']}' where id={$row['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  echo "$sql\n";
 
  $sql="update student set house='{$row['house']}' where id={$row['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  echo "$sql\n";

  $sql="update student set state_of_origin='{$row['state_of_origin']}' where id={$row['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  echo "$sql\n";

  $sql="update student set parent_guardian_info='{$row['parent_guardian_name']} {$row['parent_guardian_phone']} {$row['parent_guardian_address']}' where id={$row['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  echo "$sql\n";

  $tables = array('student_subject', 'student_comment', 'student_fees',
   'student_non_academic');
  foreach ($tables as $table) {
    $sql="update $table set admission_number='{$row['admission_number']}' where admission_number='{$row['id']}'";
    echo "$sql\n";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  } 
  echo "Finished processing {$row['firstname']} {$row['lastname']}\n\n";
 
}

exit;
?>
