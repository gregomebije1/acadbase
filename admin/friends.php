<?php

	//connection information
	$host = "localhost";
	$user = "profile_account";
	$password = "password";
	$database = "profile_accounting";
	$param = $_GET["term"];

	//make connection
	$con = mysqli_connect($host, $user, $password, $database);
  if (!$con) {
    die("Cannot connect to database server " . mysqli_error($con));
  }
  if (mysqli_connect_errno()) {
    die("Connect failed: ".mysqli_connect_errno()." : "
     . mysqli_connect_error());
  }

	//query the database
	$query = mysqli_query($con, "SELECT * FROM account WHERE name REGEXP '^$param'");

	//build array of results
	for ($x = 0, $numrows = mysqli_num_rows($query); $x < $numrows; $x++) {
		$row = mysqli_fetch_assoc($query);

		$friends[$x] = array("name" => $row["name"]);
	}

	//echo JSON to page
	$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
	echo $response;

	mysqli_close($server);

?>
