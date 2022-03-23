<?php
require_once("util.inc");
$con = connect();

$param = $_GET["term"];
$class_id1 = isset($_REQUEST['class_id1']) ? "= {$_REQUEST['class_id1']}" : "!= 0";

$sql="SELECT * FROM student s join student_temp_{$_REQUEST['sessid']} st on s.id = st.student_id
 WHERE (s.firstname REGEXP '^$param' or s.lastname REGEXP '^$param' or s.admission_number REGEXP '^$param')
  and st.class_id{$class_id1} and s.school_id={$_REQUEST['school_id']}";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

for ($x = 0, $numrows = mysqli_num_rows($query); $x < $numrows; $x++) {
  $row = mysqli_fetch_assoc($query);
  $friends[$x] = array("name" => "{$row['admission_number']}_{$row['firstname']}_{$row['lastname']} ");
}

//echo JSON to page
$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
echo $response;
?>
