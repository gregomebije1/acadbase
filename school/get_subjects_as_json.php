<?php
require_once("util.inc");
$con = connect();

$param = $_GET["term"];

$sql="SELECT * FROM subject WHERE name REGEXP '^$param' and class_type_id='{$_REQUEST['class_type_id']}'
 and school_id={$_REQUEST['school_id']}";

$query = mysqli_query($con, $sql) or die(mysqli_error($con));
for ($x = 0, $numrows = mysqli_num_rows($query); $x < $numrows; $x++) {
  $row = mysqli_fetch_assoc($query);

  $friends[$x] = array("name" => "{$row['name']} ");
}

//echo JSON to page
$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
echo $response;
?>
