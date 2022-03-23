<?php
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

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('User List', 'users.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate Pin')) {

  check($_REQUEST['id'], 'Please choose a User', 'users.php', 'Back');

  mt_srand(make_seed()); //Seed with microseconds
  $pincode = mt_rand();
  //$pincode = mt_rand() + $_SESSION['school_id'];

  $sql="update user set passwd='$pincode' where id={$_REQUEST['id']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  echo msg_box("Pin Generated", 'users.php', 'Back');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Generate All Pin')) {
  $sql="select * from student where school_id={$_SESSION['school_id']}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $student = array();
  while($row = mysqli_fetch_array($result))
    $student[$row['admission_number']] = $row['id'];

  foreach($student as $admission => $id) {
    //$pincode = mt_rand() + $_SESSION['session_id'];
    mt_srand(make_seed()); //Seed with microseconds
    $pincode = mt_rand();

    $sql="update user set passwd='$pincode' where name='$admission'
      and school_id={$_SESSION['school_id']}";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }

  echo msg_box("Pins Generated", 'users.php', 'Back');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  check($_REQUEST['id'], 'Please choose a User', 'users.php', 'Back');

    if ($_REQUEST['id'] == $_SESSION['uid']) {
      echo msg_box("Deletion denied<br>
       You cannot delete this user while logged in ", 'users.php', 'Back');
      exit;
    }
    echo msg_box("Are you sure you want to delete " .
     get_value('user', 'name', 'id', $_REQUEST['id'], $con)
     . " User?" ,
     "users.php?action=confirm_delete&id={$_REQUEST['id']}",
     'Continue to Delete');
     exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a User", 'users.php', 'Back');
      exit;
    }
    $sql="select * from user where id={$_REQUEST['id']}";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if (mysqli_num_rows($result) <= 0) {
      echo msg_box("User does not exist in the database", 'users.php', 'OK');
      exit;
    }
    $sql="delete from user where id={$_REQUEST['id']}";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    mysqli_query($con, "DELETE FROM user_permissions where uid=". $_REQUEST['id'])
     or die(mysqli_error($con));

    echo msg_box("User has been deleted", 'users.php', 'OK');
    exit;
  }
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update User')) {
  check($_REQUEST['id'], 'Please choose a User', 'users.php', 'Back');

    if ($_REQUEST['id'] == $_SESSION['uid']) {
      echo msg_box("Update denied<br>
       Cannot change user detials while logged in  ", 'users.php', 'Back');
      exit;
    }
    //If Permission is not Exams, just change the permission to the new
    //value
    if ($_REQUEST['permissions_id'] != '4') {
	  //Change users firstname and lastname
      //To change password, use the 'Change Password' Option
      $sql="update user set firstname='{$_REQUEST['firstname']}',
       lastname='{$_REQUEST['lastname']}' where id={$_REQUEST['id']}";
      //echo "$sql<br>";
      mysqli_query($con, $sql) or die(mysqli_error($con));

      $sql="update user_permissions set pid={$_REQUEST['permissions_id']}
       where uid={$_REQUEST['id']}";
      //echo "$sql<br>";
	  mysqli_query($con, $sql) or die(mysqli_error($con));
    } else {
	  if (empty($_REQUEST['s_permissions_members'])) {
	    echo msg_box('Please choose the subjects that the user has access to',
	    'users.php?action=Add', 'Back');
		exit;
	  }
	  //Change users firstname and lastname
      //To change password, use the 'Change Password' Option
      $sql="update user set firstname='{$_REQUEST['firstname']}',
       lastname='{$_REQUEST['lastname']}' where id={$_REQUEST['id']}";
      //echo "$sql<br>";
	  mysqli_query($con, $sql) or die(mysqli_error($con));

      //First delete all the permissions for this user
      $sql="delete from user_permissions where uid={$_REQUEST['id']}";
      //echo "$sql<br>";
      mysqli_query($con, $sql) or die(mysqli_error($con));

      //Then loop through class subject data
      $data = explode("|", $_REQUEST['s_permissions_members']);
      foreach ($data as $class_subject) {
        $data2 = explode("_", $class_subject);

        //There should be a more efficient way
        $sql="insert into user_permissions(uid, pid, class_id, subject_id)
         values ({$_REQUEST['id']}, {$_REQUEST['permissions_id']}, {$data2[0]},
          {$data2[1]})";
        mysqli_query($con, $sql) or die(mysqli_error($con));
      }
    }
    echo msg_box("User details have been changed", 'users.php', 'OK');
    exit;
  }

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add User')) {

  //Make sure no fields are blank
  if (empty($_REQUEST['username']) || empty($_REQUEST['firstname'])
      || empty($_REQUEST['lastname'])) {
    echo msg_box("Please fill in all the fields in the form",
      'users.php?action=Add', 'Back');
    exit;
  }

  //Make sure permission was specified
  if ($_REQUEST['permissions_id'] == '0') {
    echo msg_box("Please choose a Permission", 'users.php?action=Add',
       'Back');
    exit;
  }

  //make sure password was entered
  if (empty($_REQUEST['password']) || empty($_REQUEST['password2'])) {
    echo msg_box('Please enter the passwords','users.php?action=Add', 'Back');
    exit;
  }

  //make sure passwords are equal
  if ($_REQUEST['password'] != $_REQUEST['password2']) {
    echo msg_box('Passwords are not equal', 'users.php?action=Add', 'Back');
    exit;
  }

  //Make sure this users does not exist for this particular school
  $sql = "select * from user where name='{$_REQUEST['username']}'
    and school_id='{$_SESSION['school_id']}'";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  if (mysqli_num_rows($result) > 0) {
    echo msg_box("There is already another user with the same username<b>
       Please choose another user", 'users.php?action=Add', 'Back');
    exit;
  }

  //If User does not have 'Exam' permission, then go ahead and insert
  if ($_REQUEST['permissions_id'] != '4') {

    //insert user
    $sql="insert into user(name, passwd, firstname, lastname, school_id)
     values('{$_REQUEST['username']}', sha1('{$_REQUEST['password']}'),
     '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}',
     '{$_SESSION['school_id']}')";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $uid = mysqli_insert_id($con);

    //insert user permissions, no need to specify class and subject
    $sql="insert into user_permissions(uid, pid, class_id, subject_id)
         values ($uid, {$_REQUEST['permissions_id']}, '', '')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  } else {
    //Ok. We have a user who has 'Exam' permissions

    //If user did not choose any subjects
    if (empty($_REQUEST['s_permissions_members'])) {
      echo msg_box('Please choose the subjects that the user has access to',
        'users.php?action=Add', 'Back');
      exit;
    }

    //insert user
    $sql="insert into user(name, passwd, firstname, lastname, school_id)
      values('{$_REQUEST['username']}', sha('{$_REQUEST['password']}'),
      '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}',
      '{$_SESSION['school_id']}')";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $uid = mysqli_insert_id($con);

    //Decode permissions string into an array. e.g., 2_2|3_3
    $data = explode("|", $_REQUEST['s_permissions_members']);

    foreach ($data as $class_subject) {
      $data2 = explode("_", $class_subject);

      //insert permissions for each subject
      $sql="insert into user_permissions(uid, pid, class_id, subject_id)
        values ($uid, {$_REQUEST['permissions_id']}, {$data2[0]},
        {$data2[1]})";
      mysqli_query($con, $sql) or die(mysqli_error($con));
    }
  }
  //Ok. We are done
  echo msg_box("{$_REQUEST['username']} successfully added",
    'users.php?action=Add', 'Back');
  exit;

} elseif (isset($_REQUEST['action']) &&
      ($_REQUEST['action'] == 'Change Password')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box('Please choose a user', 'users.php', 'Back');
      exit;
    } else {
      if ($_REQUEST['id'] != $_SESSION['uid']) {
        if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
          echo msg_box("Security Alert: You cannot change someone
            else password ", 'users.php', 'Back');
	  exit;
	}
      }
      $result = mysqli_query($con, "select name, firstname, lastname
       from user where id= ". $_REQUEST['id']);
      $row = mysqli_fetch_array($result);
      ?>
      <table>
       <tr class='class1'>
        <td colspan='3'><h3>Change Password</h3></td>
       </tr>
       <form action="users.php" method="POST">
        <tr><td>Username</td><td><?=$row['name']?></td></tr>
        <tr>
         <td>New Password</td>
         <td><input type='password' name='p1'></td>
        </tr>
        <tr>
         <td>Re-enter new Password</td>
         <td><input type='password' name='p2'></td>
        </tr>
        <tr>
         <td>
          <input type='hidden' name='id' value='<?=$_REQUEST['id']?>'>
	  <input type='submit' name='action' value='Change'>
	  <input type='submit' name='action' value='Cancel'>
         </td>
        </tr>
       </form>
      </table>
      <?
    }
    exit;
  } elseif (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Change')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box('Please choose a user', 'users.php', 'Back');
      exit;
    }
    if (empty($_REQUEST['p1']) || empty($_REQUEST['p2'])) {
      echo msg_box('Please enter the passwords',
       "users.php?action=Change Password&id={$_REQUEST['id']}", 'Back');
        exit;
    }
    if ($_REQUEST['p1'] != $_REQUEST['p2']) {
      echo msg_box('Passwords are not equal',
       "users.php?action=Change Password&id={$_REQUEST['id']}", 'Back');
       exit;
    }
    if ($_REQUEST['id'] != $_SESSION['uid']) {
      if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
       echo msg_box("Security Alert: You cannot change someone else password ",
        'users.php', 'Back');
       exit;
      }
    }
    $sql="update user set passwd = sha1('" . $_REQUEST['p1']
      . "')  where id=" . $_REQUEST['id'];
    mysqli_query($con, $sql);
    echo msg_box('Password has been changed', 'users.php', 'Back to users');
    exit;
 } elseif (isset($_REQUEST['action']) &&
     (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))){

   if (($_REQUEST['action'] == 'Edit') && empty($_REQUEST['id'])) {
       echo msg_box("Please choose a user", 'users.php', 'Back');
       exit;
   }
   $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

   $sql="select u.passwd, u.id, u.name, u.firstname, u.lastname,
       p.name as 'permission', p.id as 'permission_id'
       from user u join (user_permissions up, permissions p)
       on (up.pid = p.id and u.id = up.uid) where u.id = $id";

   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $row = mysqli_fetch_array($result);
   ?>
   <table>
    <tr class='class1'>
     <td colspan='3'><h3><?php echo $_REQUEST['action']; ?> User</h3></td>
    </tr>
    <form name='form1' action="users.php" method="post">

    <tr>
     <td>Username</td>
     <td><input type="text" name="username" value='<?php echo $row['name'];?>'>
     </td></tr>

    <tr>
     <td>Password</td>
     <td><input type="password" name="password"
      value='<?php echo $row['password']; ?>'></td></tr>

    <tr>
     <td>Retype Password</td>
     <td><input type="password" name="password2"
      value='<?php echo $row['password2']; ?>'></td></tr>

    <tr>
     <td>Firstname</td>
     <td><input type="text" name="firstname"
       value='<?php echo $row['firstname']; ?>'></td></tr>

    <tr>
     <td>Lastname</td>
     <td><input type="text" name="lastname"
      value='<?php echo $row['lastname'];?>'></td></tr>


    <tr>
     <td>Permissions</td>
     <td>
      <?php
      $arr = array('1'=>'Administrator', '2'=>'Accounts', '4'=>'Exams',
         '5'=>'Records', '6'=>'Student');
      echo selectfield($arr, 'permissions_id', $row['permission'], '',
        'check_and_show_permissions()');
      ?>
     </td></tr>
    <!--
    <tr class='class1'><td>Subjects</td><td>Permissions</td></tr>
    <?php
    if ($row['permission'] != 'Exams') {
	echo "<tr id='ok' style='display:none;'>";
    } else {
	echo "<tr id='ok' style='display:inline;'>";
    }
    ?>
     <td colspan='2' style='width:50em;'>
      <table style='table-layout:fixed;'>
       <tr>
        <td>

         <?php
          //Get list of all subjects for this school
          $sql="select c.id as 'class_id', s.id as 'subject_id',
           c.name as 'class_name', s.name as 'subject_name' from class c
           join subject s on c.class_type_id = s.class_type_id
           where c.school_id={$_SESSION['school_id']}";

          //Do not include subjects you already have permission for
          if($_REQUEST['action'] == 'Edit') {
            $sql .= " where s.id
             not in (select subject_id from user_permissions
             where uid={$_REQUEST['id']})";
          }

          $result = mysqli_query($con, $sql) or die(mysqli_error($con));
          ?>

          <select name='class_subject_id' size='7' id='class_subject_id'>

          <?php
          while ($row = mysqli_fetch_array($result)) {
            echo "<option value='{$row['class_id']}_{$row['subject_id']}'>
             {$row['class_name']} {$row['subject_name']}</option>";
          }
          ?>
          </select>
	</td>
	<td>
	 <table style='border: solid black 0.0em;'>
	  <tr>
           <td>
	    <a name='adds' id='adds' onClick='hello();'>
             <img src='images/next.gif'></a>
	   </td>
          </tr>
          <tr>
           <td>
	    <a name='dels' id='dels' onClick='hello2();'>
             <img src='images/prev.gif'></a>
	   </td>
          </tr>
	 </table>
	</td>
	<td>
         <select size='8' id='s_permissions' name='s_permissions'>

	 <?php
	 if($_REQUEST['action'] == 'Edit'){
	   $sql ="select up.id, c.name as 'class_name', up.class_id,
             s.name as 'subject_name', up.subject_id,
	     p.name as 'permission_name' from class c join
	     (subject s, permissions p, user_permissions up) on
	     (up.subject_id = s.id and up.class_id = c.id and up.pid = p.id)
	     where up.uid={$_REQUEST['id']}";
	   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	   while ($row = mysqli_fetch_array($result)) {
	     echo "<option value='{$row['class_id']}_{$row['subject_id']}'>
		  {$row['class_name']} {$row['subject_name']}</option>";
	   }
	 }
	 ?>

         </select>
        <input type='hidden' name='s_permissions_members'>
        </td>
       </tr>
      </table>
     </td>
    </tr>
	-->
    <tr>
     <td>

     <?php
       if($_REQUEST['action'] == 'Edit') {
         echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
       }
       echo "<input name='action' type='submit' value='";
       echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
       echo " User'>";
     ?>

     </td>
     <td><input name="action" type="submit" value="Cancel"></td>
     </form>
     <script type='text/javascript'>
      get_permissions_in_s_permissions();
     </script>

    </tr>
   </table>
   <?php
    exit;
  }
?>
<div class='class1'>
 <?php
 if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
   || (!isset($_REQUEST['action']))) {
  ?>
  <a href='users.php?action=Generate All Pin'>Generate New Pins</a>
  <a href='users.php?action=Print'>Print</a>
  <?php
 }
 ?>
    <h3 class='sstyle1' style='display:inline;'>Users</h3>
   </div>

  <table class='tablesorter'>
   <thead>
   <tr>
    <th>Username</th>
    <th>Pincode</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Permission</th>
   </tr>
   </thead>
   <tbody>
   <!--Make pincode visible for Students-->
   <?php
   $sql="select u.id, u.name, u.passwd, u.firstname, u.lastname,
     p.name as 'permission'
     from user u join (user_permissions up, permissions p)
     on (up.pid = p.id and u.id = up.uid)
     where u.$extra_caution_sql group by u.id";

   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while ($row = mysqli_fetch_array($result)) {
     echo "
   <tr>";

     if ($row['permission'] == 'Student') {
	   echo "<td class='style2'>{$row['name']}</td>
        <td class='style2'>{$row['passwd']}</td>";
     } else {
	   echo "<td class='style2'><a href='users.php?action=Change Password&id={$row['id']}'>{$row['name']}<a/></td>
         <td class='style2'>.</td>";
	 }
    echo "
    <td class='style2'>{$row['firstname']}</td>
    <td class='styel2'>{$row['lastname']}</td>
    <td class='style2'>{$row['permission']}</td>
   </tr>";
   }
   echo "</tbody></table></form>";

   require_once "tablesorter_footer.inc";
   main_footer();
