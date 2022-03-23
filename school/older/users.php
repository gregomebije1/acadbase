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
if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('User List', 'users.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
       echo msg_box('Only Administrator can do that!', 
        'users.php', 'Back');
       exit;
    }
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a user", 'users.php', 'Back');
       exit;
    }
    if ($_REQUEST['id'] == $_SESSION['uid']) {
      echo msg_box("Deletion denied<br>
       You cannot delete this user while logged in ", 'users.php', 'Back');
      exit;
    }
    if (user_type($_REQUEST['id'], 'Administrator', $con)) {
      echo msg_box("Deletion denied<br>
       You cannot delete an Administrator ", 'users.php', 'Back');
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
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("User does not exist in the database", 'users.php', 'OK');
      exit;
    }
    $sql="delete from user where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
	
    mysql_query("DELETE FROM user_permissions where uid=". $_REQUEST['id']) 
     or die(mysql_error());
	
    echo msg_box("User has been deleted", 'users.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update User')) {
    if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
       echo msg_box('Only Administrator can do that!', 
        'users.php', 'Back');
       exit;
    }
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a user", 'users.php', 'Back');
       exit;
    }
    if ($_REQUEST['id'] == $_SESSION['uid']) {
      echo msg_box("Update denied<br>
       Cannot change user detials while logged in  ", 'users.php', 'Back');
      exit;
    }
    if (user_type($_REQUEST['id'], 'Administrator', $con)) {
      echo msg_box("Update denied<br>
       You cannot change Administrator details", 'users.php', 'Back');
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
      mysql_query($sql) or die(mysql_error());
	  
      $sql="update user_permissions set pid={$_REQUEST['permissions_id']}
       where uid={$_REQUEST['id']}";
      //echo "$sql<br>";
	  mysql_query($sql) or die(mysql_error());
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
	  mysql_query($sql) or die(mysql_error());
	  
      //First delete all the permissions for this user
      $sql="delete from user_permissions where uid={$_REQUEST['id']}";
      //echo "$sql<br>";
      mysql_query($sql) or die(mysql_error());
     
      //Then loop through class subject data
      $data = explode("|", $_REQUEST['s_permissions_members']);
      foreach ($data as $class_subject) {
        $data2 = explode("_", $class_subject);

        //There should be a more efficient way
        $sql="insert into user_permissions(uid, pid, class_id, subject_id) 
         values ({$_REQUEST['id']}, {$_REQUEST['permissions_id']}, {$data2[0]}, 
          {$data2[1]})";
        //echo "$sql<br>";
        mysql_query($sql) or die(mysql_error());
      }
    }
    echo msg_box("User details have been changed", 'users.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add User')) {
    if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
      echo msg_box('Only Administrator can do that!', 
        'users.php', 'Back');
      exit;
    }
    if ($_REQUEST['permissions_id'] == '1') {
      echo msg_box("You cannot have more than one Administrative User", 
       'users.php?action=Add', 'Back');
      exit;
    }
    if (empty($_REQUEST['username']) || empty($_REQUEST['firstname']) 
      || empty($_REQUEST['lastname'])) {
      echo msg_box("Please fill out the form", 'users.php?action=Add', 'Back');
      exit;
    }
    if ($_REQUEST['permissions_id'] == '0') {
      echo msg_box("Please choose a Permission", 'users.php?action=Add', 
       'Back');
      exit;
    }
    if (empty($_REQUEST['password']) || empty($_REQUEST['password2'])) {
      echo msg_box('Please enter the passwords','users.php?action=Add', 'Back');
        exit;
    }
    if ($_REQUEST['password'] != $_REQUEST['password2']) {
      echo msg_box('Passwords are not equal', 'users.php?action=Add', 'Back');
       exit;
    }
	
    $sql = "select * from user where name='{$_REQUEST['username']}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      echo msg_box("There is already another user with the same username<b>
       Please choose another user", 'users.php?action=Add', 'Back');
      exit;
    }
    if ($_REQUEST['permissions_id'] != '4') {
	  $sql="insert into user(name, passwd, entity_id, firstname, lastname)
       values('{$_REQUEST['username']}', sha('{$_REQUEST['password']}'), 
       '1', '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}')";
      $result = mysql_query($sql) or die(mysql_error());
      $uid = mysql_insert_id();
     
      $sql="insert into user_permissions(uid, pid, class_id, subject_id) 
         values ($uid, {$_REQUEST['permissions_id']}, '', '')";
	  mysql_query($sql) or die(mysql_error());
    } else {
	  if (empty($_REQUEST['s_permissions_members'])) {
	    echo msg_box('Please choose the subjects that the user has access to', 
	      'users.php?action=Add', 'Back');
		exit;
	  }
	  $sql="insert into user(name, passwd, entity_id, firstname, lastname)
       values('{$_REQUEST['username']}', sha('{$_REQUEST['password']}'), 
       '1', '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}')";
      $result = mysql_query($sql) or die(mysql_error());
      $uid = mysql_insert_id();
     
	 $data = explode("|", $_REQUEST['s_permissions_members']);
     foreach ($data as $class_subject) {
      $data2 = explode("_", $class_subject);
      $sql="insert into user_permissions(uid, pid, class_id, subject_id) 
        values ($uid, {$_REQUEST['permissions_id']}, {$data2[0]}, 
        {$data2[1]})";
	  mysql_query($sql) or die(mysql_error());
     } 
    }
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
      $result = mysql_query("select name, firstname, lastname 
       from user where id= ". $_REQUEST['id'], $con);
      $row = mysql_fetch_array($result);
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
    mysql_query($sql, $con);
    echo msg_box('Password has been changed', 'users.php', 'Back to users');
    exit;
 } elseif (isset($_REQUEST['action']) && 
     (($_REQUEST['action'] == 'Add') 
     || ($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View'))) {
   if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
       echo msg_box('Only Administrator can do that!', 
        'users.php', 'Back');
       exit;
   }
   if ($_REQUEST['action'] != 'Add') {
     if (empty($_REQUEST['id'])) {
       echo msg_box("Please choose a user", 'users.php', 'Back');
       exit;
     }
     $sql="select u.passwd, u.id, u.name, u.firstname, u.lastname, 
       p.name as 'permission' 
       from user u join (user_permissions up, permissions p) 
       on (up.pid = p.id and u.id = up.uid) where u.id = {$_REQUEST['id']}";
	 $result = mysql_query($sql) or die(mysql_error());
     $row = mysql_fetch_array($result);
     $username = $row['name'];
     $password = $row['passwd'];  
     $firstname = $row['firstname'];
     $lastname = $row['lastname'];
     $permission = $row['permission'];
   } else {
     $username = "";
     $password = "";
     $firstname = "";
     $lastname = "";
     $permission = "";
   } 
   ?>
   <table> 
    <tr class='class1'>
     <td colspan='3'><h3><?php echo $_REQUEST['action']; ?> User</h3></td>
    </tr>
    <form name='form1' action="users.php" method="post">
    <tr>
     <td>Username</td>
     <td><input type="text" name="username"
     <?php 
     if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) 
       echo "value = '$username' disabled='disabled'>";
     else 
       echo ">";
     echo "</td></tr>";
     ?>
    <tr>
     <td>Password</td>
     <td><input type="password" name="password"
     <?php 
     if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) 
       echo "value = '$password' disabled='disabled'>";
     else 
       echo ">";
     echo "</td></tr>";
     ?>
    <tr>
     <td>Retype Password</td>
     <td><input type="password" name="password2" 
     <?php 
     if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) 
       echo "value = '$password' disabled='disabled'>";
     else 
       echo ">";
     echo "</td></tr>";
     ?>
    </tr>
    <tr>
     <td>Firstname</td>
     <td>
      <input type="text" name="firstname" value='<?php echo $firstname; ?>'>
     </td>
    </tr>
    <tr>
     <td>Lastname</td>
     <td>
      <input type="text" name="lastname" value='<?php echo $lastname; ?>'>
     </td>
    </tr>
    <tr>
     <td>Permissions</td>
     <td>
      <select name='permissions_id' id='permissions_id'
        onchange='check_and_show_permissions();'>
        <option value='0'></option>
      <?php
      if (!empty($permission)) {
        if ($permission == 'Administrator') { 
         echo "<option value='1' selected='selected'>Administrator</option>
           <option value='2'>Accounts</option>
	   <option value='3' >Expenditure</option>
	   <option value='4'>Exams</option>
	   <option value='5'>Records</option>";
        } else if ($permission == 'Accounts') {
          echo "<option value='1'>Administrator</option>
            <option value='2' selected='selected'>Accounts</option>
	    <option value='3' >Expenditure</option>
	    <option value='4'>Exams</option>
	    <option value='5'>Records</option>";
	} else if ($permission == 'Expenses') {
          echo "<option value='1'>Administrator</option>
            <option value='2' >Accounts</option>
	    <option value='3' selected='selected'>Expenditure</option>
	    <option value='4'>Exams</option>
	    <option value='5'>Records</option>";
        } else if ($permission == 'Exams') {
          echo "<option value='1'>Administrator</option>
           <option value='2'>Accounts</option>
	   <option value='3' >Expenditure</option>
	   <option value='4' selected='selected'>Exams</option>
	   <option value='5'>Records</option>";
        } else if ($permission == 'Records') {
	  echo "<option value='1'>Administrator</option>
           <option value='2'>Accounts</option>
	   <option value='3' >Expenditure</option>
	   <option value='4'>Exams</option>
	   <option value='5' selected='selected'>Records</option>";
	} 
      } else {
        echo "<option value='1'>Administrator</option>
         <option value='2'>Accounts</option>
	 <option value='3' >Expenditure</option>
	 <option value='4'>Exams</option>
	 <option value='5'>Records</option>";
      } 
      ?>
      </select>
     </td>
    </tr>
    <tr class='class1'><td>Subjects</td><td>Permissions</td></tr>  
    <?php
    if ($permission != 'Exams') {
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
	if (($_REQUEST['action'] == 'Add')||($_REQUEST['action'] == 'Edit')
         || ($_REQUEST['action'] == 'View')){
          //Get list of all subjects for all class
          $sql="select c.id as 'class_id', s.id as 'subject_id', 
           c.name as 'class_name', s.name as 'subject_name' from class c 
           join subject s on c.type = s.type";
          if(($_REQUEST['action'] == 'Edit')||($_REQUEST['action'] == 'View')) {
            $sql .= " where s.id 
             not in (select subject_id from user_permissions 
             where uid={$_REQUEST['id']})";
          }
          $result = mysql_query($sql) or die(mysql_error());
          echo "<select name='class_subject_id' size='7' 
            id='class_subject_id'>";
          while ($row = mysql_fetch_array($result)) {
            echo "<option value='{$row['class_id']}_{$row['subject_id']}'>
             {$row['class_name']} {$row['subject_name']}</option>";
          }
          echo "
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
	";
	}
	?>
	<td>
         <select size='8' id='s_permissions' name='s_permissions'>
	 <?php 
	 if(($_REQUEST['action'] == 'View')||($_REQUEST['action'] == 'Edit')){
	   $sql ="select up.id, c.name as 'class_name', up.class_id, 
             s.name as 'subject_name', up.subject_id, 
	     p.name as 'permission_name' from class c join 
	     (subject s, permissions p, user_permissions up) on 
	     (up.subject_id = s.id and up.class_id = c.id and up.pid = p.id)
	     where up.uid={$_REQUEST['id']}";
	   $result = mysql_query($sql) or die(mysql_error());
	   while ($row = mysql_fetch_array($result)) {
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
    <tr>
     <td>
     <?php  
     if ($_REQUEST['action'] != 'View') {
       if($_REQUEST['action'] == 'Edit') { 
         echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
       }
       echo "<input name='action' type='submit' value='"; 
       echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
       echo " User'>";
     }
     ?>
     </td>
     <td><input name="action" type="submit" value="Cancel"></td>
     </form>
     <?php 
      echo "<script type='text/javascript'>
                get_permissions_in_s_permissions();
               </script>";
     ?>

    </tr>
   </table>
   <?php
    exit;
  }
  if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Cancel')
   || ($_REQUEST['action'] == 'Print')) {
  ?>
  <table border='1'>
   <tr class='class1'>
     <?php
       if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
         echo "<td></td>";
       } else {
        echo "<td>
     <form name='form1' action='users.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
           <option value='Add'>Add</option>
	   <option value='View'>View</option>
	   <option value='Edit'>Edit</option>
	   <option value='Delete'>Delete</option>
	   <option value='Change Password'>Change Password</option>
	   <option value='Print'>Print</option>
	  ";
	}
      ?> 
     </select>
    </td>
    <td colspan='5' style='text-align:center;'><h3>Users List</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Username</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Permission</th>
   </tr>
   <?php
   $sql="select u.id, u.name, u.firstname, u.lastname, p.name as 'permission' 
      from user u join (user_permissions up, permissions p) 
      on (up.pid = p.id and u.id = up.uid) group by u.id";
   /*
     $sql="select u.id, u.name, u.firstname, u.lastname, p.name as 'permission' 
      from user u join (user_permissions up, permissions p) 
      on (up.pid = p.id and u.id = up.uid) where u.id={$_SESSION['uid']}
	 group by u.id ";
   */ 
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     echo "
   <tr>
    <td><input type='radio' name='id' value='{$row['id']}'></td>
    <td>{$row['name']}</td>
    <td>{$row['firstname']}</td>
    <td>{$row['lastname']}</td>
    <td>{$row['permission']}</td>
   </tr>";
   }
   echo "</form></table>";
   main_footer();
}
?>
