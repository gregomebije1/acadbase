<?php
require_once("util.inc");
$con = connect();

$param = $_GET["term"];

$sql="SELECT * FROM school WHERE name REGEXP '^$param'";
$query = mysqli_query($con, $sql) or die(mysqli_error($con));

for ($x = 0, $numrows = mysqli_num_rows($query); $x < $numrows; $x++) {
  $row = mysqli_fetch_assoc($query);
  $friends[$x] = array("name" => $row['name']);
}
//echo JSON to page
$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
echo $response;
?>
