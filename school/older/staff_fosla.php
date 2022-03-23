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
  print_header('Staff List', 'staff_fosla.php', 'Back to Main Menu', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff_fosla.php', 'Back');
       exit;
    }
    echo msg_box("Are you sure you want to delete " . 
     get_value('staff', 'firstname', 'id', $_REQUEST['id'], $con)
     . " ?" , "staff_fosla.php?action=confirm_delete&id={$_REQUEST['id']}", 
     'Continue to Delete');
     exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff_fosla.php', 'Back');
      exit;
    }
    $sql="select * from staff_fosla where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) <= 0) {
      echo msg_box("Staff does not exist in the database", 'staff_fosla.php', 'OK');
      exit;
    }
    $sql="delete from staff_fosla where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
	
    echo msg_box("Staff has been deleted", 'staff_fosla.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update Staff')) {
    if (empty($_REQUEST['id'])) {
      echo msg_box("Please choose a Staff", 'staff_fosla.php', 'Back');
       exit;
    }
    if ($_FILES['passport']['error'] != 4) {  
      //Lets upload the file
      if ($_FILES['passport']['error'] > 0) {
        switch($_FILES['passport']['error']) {
          case 1: echo msg_box('File exceeded upload max_filesize', 
            'staff_fosla.php?action=Add', 'OK'); break;
          case 2: echo msg_box('File exceeded max_file_size', 
            'staff_fosla.php?action=Add', 'OK'); break;
          case 3: echo msg_box('File only partially uploaded', 
            'staff_fosla.php?action=Add', 'OK'); break;
        }
        exit;
      } elseif ($_FILES['passport']['type']
        != ('image/jpeg' || 'image/gif' || 'image/png')) {
       echo msg_box('Prolem: file is not an image', 
        'staff_fosla.php?action=Add', 'OK');
       exit;
      } else {
        //Delete previous file
        //unlink("upload/". $row['logo']);
	  
	    $sql="update staff_fosla set passport='{$_FILES['passport']['name']}'
	     where id={$_REQUEST['id']}";
	    mysql_query($sql) or die(mysql_error());
	  
	    $upfile = "upload/". $_FILES['passport']['name'];
        if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
          if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
            echo msg_box('Problem: Could not move file to destination directory',
             'staff_fosla.php?action=Add', 'OK');
            exit;
          }
        } else {
          echo msg_box("Problem: Possible file upload attack. Filename: " .
            $_FILES['passport']['name'], 'staff_fosla.php?action=Add', 'OK');
          exit;
        }
      }
    }
	 
    $sql="update staff_fosla set name='{$_REQUEST['name']}', 
     gender='{$_REQUEST['gender']}', date_of_birth='{$_REQUEST['date_of_birth']}', 
     place_of_birth='{$_REQUEST['place_of_birth']}', 
     
     home_town='{$_REQUEST['home_town']}', 
     local_govt_area='{$_REQUEST['local_govt_area']}', 
     marital_status='{$_REQUEST['marital_status']}', 
     name_of_spouse='{$_REQUEST['name_of_spouse']}', 
     no_of_children='{$_REQUEST['no_of_children']}', 
     present_address='{$_REQUEST['present_address']}', 
     phone='{$_REQUEST['phone']}', 
	 
     name_of_child1='{$_REQUEST['name_of_child1']}', 
     date_of_birth_child1='{$_REQUEST['date_of_birth_child1']}',
	 
	 name_of_child2='{$_REQUEST['name_of_child2']}', 
     date_of_birth_child2='{$_REQUEST['date_of_birth_child2']}',
	 
	 name_of_child3='{$_REQUEST['name_of_child3']}', 
     date_of_birth_child3='{$_REQUEST['date_of_birth_child3']}',
	 
	 name_of_child4='{$_REQUEST['name_of_child4']}', 
     date_of_birth_child4='{$_REQUEST['date_of_birth_child4']}',
	 
	 name_next_of_kin='{$_REQUEST['name_next_of_kin']}',
	 address_next_of_kin='{$_REQUEST['address_next_of_kin']}',
	 phone_next_of_kin='{$_REQUEST['phone_next_of_kin']}' 
     where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());

    echo msg_box("Staff details have been changed", 'staff_fosla.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Staff')) {
    if (empty($_REQUEST['name'])) {
      echo msg_box("Please fill out the form", 'staff_fosla.php?action=Add', 'Back');
      exit;
    }
    $sql = "select * from staff_fosla where 
      name='{$_REQUEST['name']}'";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      echo msg_box("There is already another Staff with the same Staff Name<b>
       Please choose another Staff", 'staff_fosla.php?action=Add', 'Back');
      exit;
    }
    if (!empty($_FILES['passport']['name'])) {
    //Lets upload the file
     if ($_FILES['passport']['error'] > 0) {
       switch($_FILES['passport']['error']) {
         case 1: echo msg_box('File exceeded upload max_filesize', 
           'staff_fosla.php?action=Add', 'OK'); break;
         case 2: echo msg_box('File exceeded max_file_size', 
          'staff_fosla.php?action=Add', 'OK'); break;
         case 3: echo msg_box('File only partially uploaded', 
          'staff_fosla.php?action=Add', 'OK'); break;
         case 4: echo msg_box('No file uploaded', 
          'staff_fosla.php?action=Add', 'OK'); break;
       }
       exit;
     } elseif ($_FILES['passport']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
       echo msg_box('Prolem: file is not an image', 'staff_fosla.php?action=Add', 'OK');
       exit;
     } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
       $upfile = "upload/". $_FILES['passport']['name'];
       if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
         if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
           echo msg_box('Problem: Could not move file to destination directory',
            'staff_fosla.php?action=Add', 'OK');
           exit;
         }
       } else {
         echo msg_box("Problem: Possible file upload attack. Filename: " .
          $_FILES['passport']['name'], 'staff_fosla.php?action=Add', 'OK');
         exit;
       }
     } 
    }	
    $sql="insert into staff_fosla(name, gender, date_of_birth, place_of_birth,
      home_town, local_govt_area, marital_status,
	  name_of_spouse, no_of_children, present_address, phone, 
	  name_of_child1, date_of_birth_child1, name_of_child2, date_of_birth_child2, 
	  name_of_child3, date_of_birth_child3, name_of_child4, date_of_birth_child4, 
	  name_next_of_kin, address_next_of_kin, phone_next_of_kin, 
	  passport)
      values('{$_REQUEST['name']}', '{$_REQUEST['gender']}', 
      '{$_REQUEST['date_of_birth']}', '{$_REQUEST['place_of_birth']}', 
      '{$_REQUEST['home_town']}', 
      '{$_REQUEST['local_govt_area']}', '{$_REQUEST['marital_status']}', 
      '{$_REQUEST['name_of_spouse']}', '{$_REQUEST['no_of_children']}', 
      '{$_REQUEST['present_address']}', '{$_REQUEST['phone']}', 
      '{$_REQUEST['name_of_child1']}', '{$_REQUEST['date_of_birth_child1']}', 
	  '{$_REQUEST['name_of_child2']}', '{$_REQUEST['date_of_birth_child2']}', 
	  '{$_REQUEST['name_of_child3']}', '{$_REQUEST['date_of_birth_child3']}', 
	  '{$_REQUEST['name_of_child4']}', '{$_REQUEST['date_of_birth_child4']}', 
	  '{$_REQUEST['name_next_of_kin']}', '{$_REQUEST['address_next_of_kin']}', 
	  '{$_REQUEST['phone_next_of_kin']}', '{$_FILES['passport']['name']}')";
    $result = mysql_query($sql) or die(mysql_error());

    echo msg_box("{$_REQUEST['name']} successfully added", 
      'staff_fosla.php?action=Add', 'Back');
     exit;
 } elseif (isset($_REQUEST['action']) && 
     (($_REQUEST['action'] == 'Add') 
     || ($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View'))) {

   if ($_REQUEST['action'] != 'Add') {
     if (empty($_REQUEST['id'])) {
       echo msg_box("Please choose a Staff", 'staff_fosla.php', 'Back');
       exit;
     }
    }
    $id = empty($_REQUEST['id']) ? '0' : $_REQUEST['id'];
    $sql="select * from staff_fosla where id = $id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $av = array();

    $name =  $row['name'] ? $row['name'] : "";
	$av['name'] = $row['name'] ? $row['name'] : "";
	$av['gender'] = $row['gender'] ? $row['gender'] : "";
	$av['date_of_birth'] = $row['date_of_birth'] ? $row['date_of_birth'] : "";
	$av['place_of_birth'] = $row['place_of_birth'] ? $row['place_of_birth'] : "";
	$av['home_town'] = $row['home_town'] ? $row['home_town'] : "";
	$av['local_govt_area'] = $row['local_govt_area'] ? $row['local_govt_area'] : "";
    $av['marital_status'] = $row['marital_status'] ? $row['marital_status'] : "";
	$av['name_of_spouse'] = $row['name_of_spouse'] ? $row['name_of_spouse'] : "";
	$av['no_of_children'] = $row['no_of_children'] ? $row['no_of_children'] : "";
	$av['present_address'] = $row['present_address'] ? $row['present_address'] : "";
	$av['phone'] = $row['phone'] ? $row['phone'] : "";
	$av['name_of_child1'] = $row['name_of_child1'] ? $row['name_of_child1'] : "";
	$av['date_of_birth_child1'] = $row['date_of_birth_child1'] ? $row['date_of_birth_child1'] : "";
	
	$av['name_of_child2'] = $row['name_of_child2'] ? $row['name_of_child2'] : "";
	$av['date_of_birth_child2'] = $row['date_of_birth_child2'] ? $row['date_of_birth_child2'] : "";
	
	$av['name_of_child3'] = $row['name_of_child3'] ? $row['name_of_child3'] : "";
	$av['date_of_birth_child3'] = $row['date_of_birth_child3'] ? $row['date_of_birth_child3'] : "";
	
	$av['name_of_child4'] = $row['name_of_child4'] ? $row['name_of_child4'] : "";
	$av['date_of_birth_child4'] = $row['date_of_birth_child4'] ? $row['date_of_birth_child4'] : "";
	
	$av['name_next_of_kin'] = $row['name_next_of_kin'] ? $row['name_next_of_kin'] : "";
	$av['address_next_of_kin'] = $row['address_next_of_kin'] ? $row['address_next_of_kin'] : "";
	
	$av['phone_next_of_kin'] = $row['phone_next_of_kin'] ? $row['phone_next_of_kin'] : "";
	$av['passport'] = $row['passport'] ? $row['passport'] : "";
	?>
    <table> 
     <tr class='class1'>
      <td colspan='3'><h3><?php echo $_REQUEST['action']; ?> Staff</h3></td>
     </tr>
     <form name='form1' action="staff_fosla.php" method="post"
	 enctype="multipart/form-data" >
	 <tr>
      <td style='width:50em;'>
       <table>
       
     <?php 
	 if (($_REQUEST['action'] == 'Edit') || ($_REQUEST['action'] == 'View')) {
         echo tr(array('Name', textfield('name', 'name','value',$name, 'readonly', 'readonly', 
		 'size', '40')));
         unset($av['name']);
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
       }else if ($name == 'present_address') {
         echo tr(array('Present Address', textarea('present_address', $value) ));
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
   || ($_REQUEST['action'] == 'Print')
   || ($_REQUEST['action'] == 'Search')) {
  ?>
  <table border='1'>
   <tr class='class1'>
     <?php 
       if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
         echo "<td></td>";
       } else {
        echo "<td>
     <form name='form1' action='staff_fosla.php' method='post'>
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
    <td style='text-align:center;'><h3>Staff List</h3></td>
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
	<th>Name</th>
    <th>Phone Number</th>
   </tr>
   <?php
   if (isset($_REQUEST['count'])) {
	   $count = $_REQUEST['count'];
	   $count += 20;
   } else {
	   $count = 0;
   }
   $sql="select * from staff_fosla ";
   $sql3 = "";
	 if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'Search')){
	  $sql3 = " name LIKE '%{$_REQUEST['search']}%'";
	 }
	
	 if (!empty($sql3)) {
	   $sql .= " where $sql3 order by name limit $count, 20 ";
	 } else {
	   $sql .= " order by name limit $count, 20 ";
	 }
   
   //$sql="select * from staff_fosla order by name limit $count, 20";
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
    <td>{$row['name']}</td>
	<td>{$row['phone']}</td>
   </tr>";
   }
   $sql="select count(*) as 'count' from staff_fosla";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	echo "<tr class='class1' style='text-align:center;'>
		 <td>Page " . (($count/20) + 1) . "</td>";
	if (($row['count'] > 20) && ($row['count'] > ($count+20))) {
	   echo "<td colspan='6'><a href='staff_fosla.php'>More>></a></td>";
	} else {
	  echo "<td colspan='6'>&nbsp;</td>";
	}
	echo "</tr>";
   echo "</form></table>";
   main_footer();
  } 
?>
