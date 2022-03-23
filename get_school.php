<?php
require_once("school/util.inc");
$con = connect();

$param = $_GET["term"];
$query = mysqli_query($con, "SELECT * FROM school WHERE name REGEXP '^$param'");


for ($x = 0, $numrows = mysqli_num_rows($query); $x < $numrows; $x++) {
  $row = mysqli_fetch_assoc($query);

  $friends[$x] = array("name" => $row["name"]);
}

//echo JSON to page
$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
echo $response;

?>
