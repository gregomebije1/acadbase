<?
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";

$con = connect();


$temp = get_user_perm($_SESSION['uid'], $con);
if (!(in_array('Administrator', $temp) || in_array('Administrator', $temp))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) &&
  ($_REQUEST['action'] == 'Update Org Info')) {

  if (empty($_REQUEST['n'])) {
    echo msg_box("Please enter Name of Organization", "org_info.php", "Back");
   exit;
  } else {
    $result = mysqli_query($con, "select * from org_info where id=1")
     or die(mysqli_error($con));
	if(mysqli_num_rows($result) > 0) {
      if (!empty($_FILES['logo']['name'])) {
        if ($_FILES['logo']['error'] > 0) {
          echo '<tr><td>Problem: ';
          switch($_FILES['logo']['error']) {
            case 1: echo 'File exceeded upload max_filesize'; break;
            case 2: echo 'File exceeded max_file_size'; break;
            case 3: echo 'File only partially uploaded'; break;
            case 4: echo 'No file uploaded'; break;
          }
          echo '</td></tr>';
        } elseif ($_FILES['logo']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
          echo '<tr><td>Prolem: file is not an image</td></tr>';
          exit;
        } else {
          //Delete previous file
          //unlink("images/". $row['logo']);

          $upfile = "images/". $_FILES['logo']['name'];
          if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
            if(!move_uploaded_file($_FILES['logo']['tmp_name'], $upfile)) {
              echo '<tr><td>
                Problem: Could not move file to destination directory
                </td></tr>';
              exit;
            }
          } else {
            echo '<tr><td>Problem: Possible fiel upload attachk. Filename: ';
            echo $_FILES['logo']['name'] . '</td></tr>';
            exit;
          }
        }
        $sql="UPDATE org_info set logo = '{$_FILES['logo']['name']}'
          where id=1";
        mysqli_query($con, $sql);
	  }
      $sql="UPDATE org_info set name='{$_REQUEST['n']}',
       address = '{$_REQUEST['a']}', phone = '{$_REQUEST['p']}',
       email = '{$_REQUEST['em']}', web = '{$_REQUEST['w']}'  where id=1";
      mysqli_query($con, $sql);
    } else {
     if (!empty($_FILES['passport']['name'])) {
      if ($_FILES['logo']['error'] > 0) {
        echo '<tr><td>Problem: ';
        switch($_FILES['logo']['error']) {
          case 1: echo 'File exceeded upload max_filesize'; break;
          case 2: echo 'File exceeded max_file_size'; break;
          case 3: echo 'File only partially uploaded'; break;
          case 4: echo 'No file uploaded'; break;
        }
        echo '</td></tr>';
      } elseif ($_FILES['logo']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
        echo '<tr><td>Prolem: file is not an image</td></tr>';
        exit;
      } else {
        $upfile = "images/". $_FILES['logo']['name'];
        if(is_uploaded_file($_FILES['logo']['tmp_name'])) {
          if(!move_uploaded_file($_FILES['logo']['tmp_name'], $upfile)) {
            echo '<tr><td>
                Problem: Could not move file to destination directory
                </td></tr>';
            exit;
          }
        } else {
          echo '<tr><td>Problem: Possible fiel upload attachk. Filename: ';
          echo $_FILES['logo']['name'] . '</td></tr>';
           exit;
        }
      }
	 }
     $sql="INSERT INTO org_info (name, address, email, phone,
           web, logo) VALUES('{$_REQUEST['n']}', '{$_REQUEST['a']}',
           '{$_REQUEST['em']}', '{$_REQUEST['p']}', '{$_REQUEST['w']}',
           '{$_FILES['logo']['name']}')";
     mysqli_query($con, $sql);
	}
  }
}

$result = mysqli_query($con, "SELECT * FROM org_info") or die(mysqli_error($con));
$row = mysqli_fetch_array($result);
?>
  <table>
   <tr class='class1'>
       <td colspan="4">
        <h3>Organization Inforamtion</h3>
        <form enctype="multipart/form-data"
          action="org_info.php" method="post">
       </td>
      </tr>
      <tr>
       <td>Logo Image</td>
       <td>
       <img src='images/<?php echo $row['logo'];?>'
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
       <td><input type="text" name="w" size="50" value="<?=$row['web']?>"></td>
      </tr>
      <tr>
       <td>Logo</td>
       <td><input type="file" name="logo"></td>
      </tr>
      <tr>
       <td><input type="submit" name="action" value="Update Org Info"></td>
      </tr>
     </form>
    </table>
<?
  main_footer();
?>
