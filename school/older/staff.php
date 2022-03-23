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

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || (user_type($_SESSION['uid'], 'Records', $con)))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}


if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Staff List', 'staff.php', 'Back to Main Menu', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff.php', 'Back');
       exit;
    }
    echo msg_box("Are you sure you want to delete " . 
     get_value('staff', 'firstname', 'id', $_REQUEST['id'], $con)
     . " ?" , "staff.php?action=confirm_delete&id={$_REQUEST['id']}", 
     'Continue to Delete');
     exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff.php', 'Back');
      exit;
    }
    $sql="select * from staff where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("Staff does not exist in the database", 'staff.php', 'OK');
      exit;
    }
    $sql="delete from staff where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
	
    echo msg_box("Staff has been deleted", 'staff.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update Staff')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff.php', 'Back');
       exit;
    }
    if ($_FILES['passport']['error'] != 4) {  
      //Lets upload the file
      if ($_FILES['passport']['error'] > 0) {
        switch($_FILES['passport']['error']) {
          case 1: echo msg_box('File exceeded upload max_filesize', 
            'staff.php?action=Add', 'OK'); break;
          case 2: echo msg_box('File exceeded max_file_size', 
            'staff.php?action=Add', 'OK'); break;
          case 3: echo msg_box('File only partially uploaded', 
            'staff.php?action=Add', 'OK'); break;
        }
        exit;
      } elseif ($_FILES['passport']['type']
        != ('image/jpeg' || 'image/gif' || 'image/png')) {
       echo msg_box('Prolem: file is not an image', 
        'staff.php?action=Add', 'OK');
       exit;
      } else {
        //Delete previous file
        //unlink("upload/". $row['logo']);
	  
	    $sql="update staff set passport='{$_FILES['passport']['name']}'
	     where id={$_REQUEST['id']}";
	    mysql_query($sql) or die(mysql_error());
	  
	    $upfile = "upload/". $_FILES['passport']['name'];
        if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
          if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
            echo msg_box('Problem: Could not move file to destination directory',
             'staff.php?action=Add', 'OK');
            exit;
          }
        } else {
          echo msg_box("Problem: Possible file upload attack. Filename: " .
            $_FILES['passport']['name'], 'staff.php?action=Add', 'OK');
          exit;
        }
      }
    }
    $sql="update staff set staff_number='{$_REQUEST['staff_number']}', 
     title='{$_REQUEST['title']}', 
     firstname='{$_REQUEST['firstname']}', lastname='{$_REQUEST['lastname']}', 
     gender='{$_REQUEST['gender']}', address='{$_REQUEST['address']}', 
     phone='{$_REQUEST['phone']}', 
     state_of_origin='{$_REQUEST['state_of_origin']}', 
     date_of_birth='{$_REQUEST['date_of_birth']}', 
     marital_status='{$_REQUEST['marital_status']}', 
     spouse_name='{$_REQUEST['spouse_name']}', 
     spouse_phone='{$_REQUEST['spouse_phone']}', 
     department='{$_REQUEST['department']}', 
     post='{$_REQUEST['post']}', 
     qualification='{$_REQUEST['qualification']}', 
     appointment_date='{$_REQUEST['appointment_date']}', 
     resignation_retirement_date='{$_REQUEST['resignation_retirement_date']}' 
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());

    echo msg_box("Staff details have been changed", 'staff.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Staff')) {
    if (empty($_REQUEST['staff_number']) || empty($_REQUEST['firstname']) 
      || empty($_REQUEST['lastname'])) {
      echo msg_box("Please fill out the form", 'staff.php?action=Add', 'Back');
      exit;
    }
    $sql = "select * from staff where 
      staff_number='{$_REQUEST['staff_number']}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      echo msg_box("There is already another Staff with the same Staff Number<b>
       Please choose another Staff", 'staff.php?action=Add', 'Back');
      exit;
    }
    if (!empty($_FILES['passport']['name'])) {
    //Lets upload the file
     if ($_FILES['passport']['error'] > 0) {
       switch($_FILES['passport']['error']) {
         case 1: echo msg_box('File exceeded upload max_filesize', 
           'staff.php?action=Add', 'OK'); break;
         case 2: echo msg_box('File exceeded max_file_size', 
          'staff.php?action=Add', 'OK'); break;
         case 3: echo msg_box('File only partially uploaded', 
          'staff.php?action=Add', 'OK'); break;
         case 4: echo msg_box('No file uploaded', 
          'staff.php?action=Add', 'OK'); break;
       }
       exit;
     } elseif ($_FILES['passport']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
       echo msg_box('Prolem: file is not an image', 'staff.php?action=Add', 'OK');
       exit;
     } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
       $upfile = "upload/". $_FILES['passport']['name'];
       if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
         if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
           echo msg_box('Problem: Could not move file to destination directory',
            'staff.php?action=Add', 'OK');
           exit;
         }
       } else {
         echo msg_box("Problem: Possible file upload attack. Filename: " .
          $_FILES['passport']['name'], 'staff.php?action=Add', 'OK');
         exit;
       }
     } 
    }
    $sql="insert into staff(staff_number, title, firstname, lastname,
      gender, address, phone, state_of_origin, date_of_birth,
      marital_status, spouse_name, spouse_phone, department,
      post, qualification, appointment_date, resignation_retirement_date,
	  passport)
      values('{$_REQUEST['staff_number']}', '{$_REQUEST['title']}', 
      '{$_REQUEST['firstname']}', '{$_REQUEST['lastname']}', 
      '{$_REQUEST['gender']}', '{$_REQUEST['address']}', 
      '{$_REQUEST['phone']}', '{$_REQUEST['state_of_origin']}', 
      '{$_REQUEST['date_of_birth']}', '{$_REQUEST['marital_status']}', 
      '{$_REQUEST['spouse_name']}', '{$_REQUEST['spouse_phone']}', 
      '{$_REQUEST['department']}', '{$_REQUEST['post']}', 
      '{$_REQUEST['qualification']}', '{$_REQUEST['appointment_date']}', 
      '{$_REQUEST['resignation_retirement_date']}',
	  '{$_FILES['passport']['name']}')";
    $result = mysql_query($sql) or die(mysql_error());

    echo msg_box("{$_REQUEST['staff_number']} {$_REQUEST['firstname']} 
      {$_REQUEST['lastname']} successfully added", 
      'staff.php?action=Add', 'Back');
     exit;
 } elseif (isset($_REQUEST['action']) && 
     (($_REQUEST['action'] == 'Add') 
     || ($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View'))) {

   if ($_REQUEST['action'] != 'Add') {
     if (empty($_REQUEST['id'])) {
       echo msg_box("Please choose a Staff", 'staff.php', 'Back');
       exit;
     }
    }
    $id = empty($_REQUEST['id']) ? '0' : $_REQUEST['id'];
    $sql="select * from staff where id = $id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $av = array();

    $staff_number =  $row['staff_number'] ? $row['staff_number'] : "";
    $av['staff_number'] = $staff_number;
    $av['title'] = $row['title'] ? $row['title'] : "";
    $av['firstname'] = $row['firstname'] ? $row['firstname'] : "";
    $av['lastname'] = $row['lastname'] ? $row['lastname'] : "";
    $av['gender'] = $row['gender'] ? $row['gender'] : "";
    $av['address'] = $row['address'] ? $row['address'] : "";
    $av['phone'] = $row['phone'] ? $row['phone'] : "";
    $av['state_of_origin'] =$row['state_of_origin']?$row['state_of_origin']:"";
    $av['date_of_birth']= $row['date_of_birth']? $row['date_of_birth']:
      date('Y-m-d');
    $av['marital_status'] = $row['marital_status']?$row['marital_status'] : "";
    $av['spouse_name'] = $row['spouse_name'] ? $row['spouse_name'] : "";
    $av['spouse_phone'] = $row['spouse_phone'] ? $row['spouse_name'] : "";
    $av['department'] = $row['department'] ? $row['department'] : "";
    $av['post'] = $row['post'] ? $row['post'] : "";
    $av['qualification'] = $row['qualification'] ? $row['qualification'] : "";
    $av['appointment_date'] = $row['appointment_date'] 
      ? $row['appointment_date']: date('Y-m-d');
    $av['resignation_retirement_date'] = 
      $row['resignation_retirement_date'] 
     ? $row['resignation_retirement_date']: date('Y-m-d');
	$av['passport'] = $row['passport'] ? $row['passport'] : "";
    ?>
    <table> 
     <tr class='class1'>
      <td colspan='3'><h3><?php echo $_REQUEST['action']; ?> Staff</h3></td>
     </tr>
     <form name='form1' action="staff.php" method="post"
	 enctype="multipart/form-data" >
	 <tr>
      <td style='width:50em;'>
       <table>
       
     <?php
     if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) {
         echo tr(array('Staff Number', textfield('name', 'staff_number','value',
           $staff_number, 'readonly', 'readonly')));
         unset($av['staff_number']);
     } 
      foreach($av as $name => $value) 
       if ($name == 'gender') {
         echo tr(array('Gender', 
         selectfield(array('Male'=>'Male','Female'=>'Female'),
          $name,$value)));
       } else if ($name == 'marital_status') {
         echo tr(array('Martial Status', 
         selectfield(array('Married'=>'Married','Single'=>'Single'),
          $name,$value)));
       }else if ($name == 'address') {
         echo tr(array('Address', textarea('address', $value) ));
	   } else if ($name == 'passport') {
	     continue;
       } else { 
         echo tr(array($name, textfield('name', $name, 'value', $value)));
       }
     echo "
	 </table>
     </td>
	 <td style='vertical-align:top;'>
     <table>
      <tr>
       <td colspan='3'>
        <img src='upload/{$av['passport']}' width='200' height='200'></td>
      </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
       <td>Passport</td>
       <td><input type='file' name='passport'></td>
      </tr>
	 </table>
	</td>
    </tr>
	<tr>
     <td colspan='2' style='text-align:center;'>
     ";
     if ($_REQUEST['action'] != 'View') {
       if($_REQUEST['action'] == 'Edit') { 
         echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
       }
       echo "<input name='action' type='submit' value='"; 
       echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
       echo " Staff'>";
     }
     ?>
     <input name="action" type="submit" value="Cancel">
	 </td>
    </tr>
	</form>
   </table>
   <?php
    exit;
  }
  if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Cancel')
   || ($_REQUEST['action'] == 'Print') || ($_REQUEST['action'] == 'Search')) {
  ?>
  <table border='1'>
   <tr class='class1'>
     <?php 
       if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
         echo "<td></td>";
       } else {
        echo "<td>
     <form name='form1' action='staff.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
     
      <option value=''>Choose option</option>
      <option value='Add'>Add</option>
      <option value='View'>View</option>
      <option value='Edit'>Edit</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
     </td>
     ";
      }
    ?>
    <td colspan='2' style='text-align:center;'>
     <h3>Staff List </h3>
    </td>
	<td colspan='2'>
	 <table>
	  <tr class='class1'>
       <td>Search</td>
	   <td>
	    <input type='text' name='search'>
		<input type='submit' name='action' value='Search'></td>
	  </tr>
	 </table>
	</td>
   </tr>
   <tr>
    <th></th>
    <th>Staff Number</th>
	<th>Lastname</th>
    <th>Firstname</th>
    <th>Phone Number</th>
   </tr>
   <?php
   if (isset($_REQUEST['count'])) {
	   $count = $_REQUEST['count'];
	   $count += 20;
   } else {
	   $count = 0;
   }
   $sql="select * from staff";
   $sql3 = "";
	 if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'Search')){
	  $sql3 = " staff_number like '%{$_REQUEST['search']}%' 
	    or firstname LIKE '%{$_REQUEST['search']}%'
		or lastname LIKE '%{$_REQUEST['search']}%'";
	 }
	 if (!empty($sql3)) {
	   $sql .= " where $sql3 order by lastname limit $count, 20 ";
	 } else {
	   $sql .= " order by lastname limit $count, 20 ";
	 }
   //$sql="select * from staff order by lastname limit $count, 20";
   $result = mysql_query($sql, $con);
   if (mysql_num_rows($result) <= 0) {
     echo "<tr style='text-align:center;'>
       <td colspan='5'><h4>No Staff Found</h4></td></tr></form></table>";
     exit;
   }
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     echo "
   <tr>
    <td style='width:1px;'><input type='radio' name='id' value='{$row['id']}'></td>
    <td style='width:2em;'>{$row['staff_number']}</td>
	<td>{$row['lastname']}</td>
    <td>{$row['firstname']}</td>
    <td>{$row['phone']}</td>
   </tr>";
   }
   $sql="select count(*) as 'count' from staff";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	echo "<tr class='class1' style='text-align:center;'>
		 <td>Page " . (($count/20) + 1) . "</td>";
	if (isset($_REQUEST['search'])) {
	  echo "<td colspan='6'>&nbsp;</td>";
	} else if (($row['count'] > 20) && ($row['count'] > ($count+20))) {
	   echo "<td colspan='6'><a href='staff.php'>More>></a></td>";
	} else {
	  echo "<td colspan='6'>&nbsp;</td>";
	}
	echo "</tr>";
   echo "</form></table>";
   main_footer();
  } 
?>
