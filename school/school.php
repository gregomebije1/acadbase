<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";

$con = connect();

$user = array('Administrator','Proprietor','Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

$extra_caution_sql = "id={$_SESSION['school_id']}";

//Make sure that Session/Term/Class has been created and
//that the session variables representing them have been set
check_session_variables('school.php', $con);

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) &&
  ($_REQUEST['action'] == 'Update School Info')) {

  if (empty($_REQUEST['n'])){
    echo msg_box("Please make sure you enter correct values for School Name", "school.php", "Back");
   exit;
  }
  $arr = array('logo');
  foreach($arr as $ar)
    if(!empty($_FILES[$ar]['name'])) {
      upload_file($ar, 'school.php?action=Add');

     $sql="UPDATE school set logo = '{$_FILES['logo']['name']}'
      where $extra_caution_sql";
     mysqli_query($con, $sql) or die(mysqli_error($con));

	 $sql="UPDATE directory set logo='{$_FILES['logo']['name']}'
	   where school_name='{$_REQUEST['n']}'";
	 mysqli_query($con, $sql) or die(mysqli_error($con));
	}

  $sql="UPDATE school set name='{$_REQUEST['n']}',
       address = '{$_REQUEST['a']}', phone = '{$_REQUEST['p']}',
       email = '{$_REQUEST['em']}', website = '{$_REQUEST['w']}',
	   other_information ='{$_REQUEST['other_information']}' where $extra_caution_sql";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="UPDATE directory set school_name='{$_REQUEST['n']}',
       address = '{$_REQUEST['a']}', phone = '{$_REQUEST['p']}',
       email = '{$_REQUEST['em']}', website = '{$_REQUEST['w']}',
	   other_information ='{$_REQUEST['other_information']}'
	   where school_name='{$_REQUEST['n']}'";
  mysqli_query($con, $sql) or die(mysqli_error($con));

}

$sql="SELECT * FROM school where $extra_caution_sql";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>
  <table>
   <tr class='class1'>
       <td colspan="4">
        <h3>School Inforamtion</h3>
        <form enctype="multipart/form-data"
          action="school.php" method="post">
       </td>
      </tr>
      <tr>
       <td>Logo Image</td>
       <td>
       <img src='upload/<?php echo $row['logo'];?>'
        width='100' height='100'></td>
      </tr>
      <tr>
       <td>Name</td>
       <td><input type="text" name="n" size="50" value="<?=$row['name']?>"></td>
      </tr>
      <tr>
       <td>Address</td>
       <td><textarea rows="5" cols="50" name="a"><?=$row['address']?></textarea></td>
      </tr>
      <tr>
       <td>Phone</td>
        <td><input type="text" name="p" size="50" value="<?=$row['phone']?>">
        </td>
      </tr>
      <tr>
       <td>Email</td>
       <td><input type="text" name="em" size="50" value="<?=$row['email']?>">
       </td>
      </tr>
      <tr>
       <td>Website</td>
       <td><input type="text" name="w" size="50" value="<?=$row['website']?>"></td>
      </tr>
	   <tr>
       <td>Other Information</td>
       <td><textarea rows="5" cols="50" name="other_information" ><?=$row['other_information']?></textarea></td>
      </tr>
      <tr>
       <td>Logo</td>
       <td><input type="file" name="logo"></td>
      </tr>
      <tr>
       <td><input type="submit" name="action" value="Update School Info"></td>
      </tr>
     </form>
    </table>
<?
  main_footer();
?>
