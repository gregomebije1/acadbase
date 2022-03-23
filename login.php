<?php
session_start();
error_reporting(E_ALL);

require_once "school/util.inc";
require_once "admin/subscription_tools.inc";
$con = connect();

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'login')) {
  /*
  if (empty($_REQUEST['u']) || empty($_REQUEST['p1']) ||
    empty($_REQUEST['name']))  {
  */
  if (empty($_REQUEST['u']) || empty($_REQUEST['p1']))  {
    my_redirect('login_error_page.html', '');
    exit;
  } else {
    //Verify username, password and school
    //Change: Only very the username and password
	/*
    $sql="select u.id, u.name, u.school_id, u.firstname, u.lastname
      from user u join school s on
      u.school_id = s.id
      where u.name='{$_REQUEST['u']}' and s.name='{$_REQUEST['name']}'
      and u.passwd=sha1('{$_REQUEST['p1']}')";
    */
	$sql="select u.id, u.name, u.school_id, u.firstname, u.lastname
      from user u join school s on
      u.school_id = s.id
      where u.name='{$_REQUEST['u']}' and u.passwd=sha1('{$_REQUEST['p1']}')";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);


      check_subscription($row['school_id'], $con);

      //Store Session variables
      $_SESSION['uid'] = $row['id'];
      $_SESSION['firstname'] = $row['name'];
      $_SESSION['lastname'] = $row['name'];
      $_SESSION['school_id'] = $row['school_id'];

      my_redirect("school/student.php", "");
      exit;
    } else {
      my_redirect('login_error_page.html', '');
    }
  }
}
?>
