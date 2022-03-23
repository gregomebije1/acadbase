<?
session_start();
if (!isset($_SESSION['uid'])) {
  header('Location: index.php');
  exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "school.inc";

$con = connect();

$user = array('Administrator','Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) { 
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

$extra_caution_sql = "school_id={$_SESSION['school_id']}";

main_menu($_SESSION['uid'],
   $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

$sql="select * from school";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
while($row = mysqli_fetch_array($result)) { 

  $sql="select * from student where school_id={$row['id']}";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));

  $student = array();
  while($row1 = mysqli_fetch_array($result1)) 
    $student[$row1['admission_number']] = $row1['id'];

  foreach($student as $admission => $id) {
    mt_srand(make_seed()); //Seed with microseconds
    $pincode = mt_rand();

    $sql="update user set passwd='$pincode' where name='$admission'
      and school_id={$row['id']}";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }
}
echo msg_box("Pins Generated", 'users.php', 'Back');
exit;
?>
