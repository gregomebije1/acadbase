<?php
require_once "util.inc";
  
$con = connect();
$sql = "select * from student where class_id={$_GET['class_id1']} order by admission_number";

echo "<select name='student_id'";
if (isset($_GET['size'])) 
  echo " size='{$_GET['size']}' ";
echo ">";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    echo "<option value='{$row['admission_number']}'>
    {$row['admission_number']} {$row['firstname']} {$row['lastname']}</option>";
  }
}
echo "</select>";
?>
