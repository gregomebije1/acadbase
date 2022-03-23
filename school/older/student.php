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
  print_header('Student List', 'student.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student.php', 'Back');
    exit;
  }
  echo msg_box("Deleting a Student will delete all his
   Academic and Financial records", 
   "student.php?action=confirm_delete&id={$_REQUEST['id']}", 
   'Continue to Delete?');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student.php', 'Back');
     exit;
  }
  $sql="select * from student where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("Student does not exist in the database", 'student.php', 'OK');
    exit;
  }
  $sql="delete from student_subject where student_id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  $sql="delete from student_fee where student_id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  $sql="delete from student where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  echo msg_box("Student has been deleted", 'student.php', 'OK');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Student')) {
  if (empty($_REQUEST['admission_number']))  {
    echo msg_box('Please enter Admission Number', 
     'student.php?action=Add', 'Back');
    exit;
  }
  if (empty($_REQUEST['firstname']) || empty($_REQUEST['lastname']))  {
    echo msg_box('Please enter correct firstname or lastname', 
      'student.php?action=Add', 'Back');
    exit;
  }
  if (empty($_REQUEST['class_id'])) {
    echo msg_box('Please choose a class for this student', 
      'student.php?action=Add', 'Back');
    exit;
  }
  //Todo:Cross check date
  //Do not register the student if He/She has the same 
  //admission number as someone else in the database
  $sql="select * from student where 
     admission_number='{$_REQUEST['admission_number']}'";
  $result = mysql_query($sql);
  if (mysql_num_rows($result) > 0) {
    echo msg_box("There is already a student with the same
      admission number.<br>Please choose another admission number<br>", 
      'student.php?action=Add', 'Back to adding student');
    exit;
  }
  if (!empty($_FILES['passport']['name'])) {
  //Lets upload the file
    if ($_FILES['passport']['error'] > 0) {
      switch($_FILES['passport']['error']) {
        case 1: echo msg_box('File exceeded upload max_filesize', 
         'student.php?action=Add', 'OK'); break;
        case 2: echo msg_box('File exceeded max_file_size', 
         'student.php?action=Add', 'OK'); break;
        case 3: echo msg_box('File only partially uploaded', 
          'student.php?action=Add', 'OK'); break;
        case 4: echo msg_box('No file uploaded', 
          'student.php?action=Add', 'OK'); break;
      }
      exit;
    } elseif ($_FILES['passport']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
      echo msg_box('Prolem: file is not an image', 'student.php?action=Add', 'OK');
      exit;
    } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
      $upfile = "upload/". $_FILES['passport']['name'];
      if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
        if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
          echo msg_box('Problem: Could not move file to destination directory',
           'student.php?action=Add', 'OK');
          exit;
        }
      } else {
        echo msg_box("Problem: Possible file upload attack. Filename: " .
        $_FILES['passport']['name'], 'student.php?action=Add', 'OK');
        exit;
      }
    }
  }
   
   
  //Go ahead and register the student
  $sql="insert into student (admission_number, firstname, lastname, address, 
    current_class_id, date_of_admission, gender, phone, last_school_attended, 
    highest_class_passed, date_of_birth, parent_guardian_phone, 
    parent_guardian_name, passport, state_of_origin, local_govt_area, 
	house, first_term_times_present, first_term_times_absent, 
	second_term_times_present, second_term_times_absent, 
	third_term_times_present, third_term_times_absent, scholarship)
    values('{$_REQUEST['admission_number']}', '{$_REQUEST['firstname']}',
    '{$_REQUEST['lastname']}', '{$_REQUEST['address']}',
    {$_REQUEST['class_id']}, '{$_REQUEST['date_of_admission']}', 
    '{$_REQUEST['gender_id']}', '{$_REQUEST['phone']}', 
    '{$_REQUEST['last_school_attended']}', 
    '{$_REQUEST['highest_class_passed']}', '{$_REQUEST['date_of_birth']}', 
    '{$_REQUEST['parent_guardian_phone']}', 
    '{$_REQUEST['parent_guardian_name']}', '{$_FILES['passport']['name']}', 
    '{$_REQUEST['state_of_origin']}', '{$_REQUEST['local_govt_area']}', 
	'{$_REQUEST['house']}', '{$_REQUEST['first_term_times_present']}', 
	'{$_REQUEST['first_term_times_absent']}', '{$_REQUEST['second_term_times_present']}', 
	'{$_REQUEST['second_term_times_absent']}', '{$_REQUEST['third_term_times_present']}', 
	'{$_REQUEST['third_term_times_absent']}', '{$_REQUEST['scholarship']}')";
  mysql_query($sql) or die(mysql_error());
  
  
  echo msg_box('Student successfully entered', 'student.php', 'Continue');
  exit;
} else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Student')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student.php', 'Back');
     exit;
  }
  if (empty($_REQUEST['admission_number']))  {
    echo msg_box('Please enter Admission Number', 'student.php', 'Back');
    exit;
  }
  if (empty($_REQUEST['firstname']) || empty($_REQUEST['lastname']))  {
    echo msg_box('Please enter correct firstname or lastname', 
      'student.php', 'Back');
     exit;
  }
  if (empty($_REQUEST['class_id'])) {
      echo msg_box('Please choose a class for this student', 
       'student.php', 'Back');
      exit;
  }
  //Todo:Cross check date

  if (isset($_REQUEST['delete_previous'])) {
    //Get previous current_class_id
    //echo "Delete Previous <br>";
    $sql = "select * from student where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
    $old_class_id = $row['current_class_id'];
    //echo "$sql<br>";
 
    //Get the class type (jss or sss)
    $sql = "select type from class where id=$old_class_id";
    $result = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($result);
    //echo "$sql<br>";

    //Get all the subjects of this type of class
    $sql="select * from subject where type='{$row['type']}'";
    $result = mysql_query($sql) or die(mysql_error());
    //echo "$sql<br>";

    //De-register then register the following subjects for this student
    //For the old class
    while($row = mysql_fetch_array($result)) {
      $sql="delete from student_subject where 
       session_id={$_SESSION['session_id']}
       and term_id={$_SESSION['term_id']} 
       and class_id=$old_class_id
       and student_id={$_REQUEST['id']}
       and subject_id={$row['id']}";
      mysql_query($sql) or die(mysql_error());
      //echo "$sql<br>";
    }
  }
  if ($_FILES['passport']['error'] != 4) {  
    //Lets upload the file
    if ($_FILES['passport']['error'] > 0) {
      switch($_FILES['passport']['error']) {
        case 1: echo msg_box('File exceeded upload max_filesize', 
          'student.php?action=Add', 'OK'); break;
        case 2: echo msg_box('File exceeded max_file_size', 
          'student.php?action=Add', 'OK'); break;
        case 3: echo msg_box('File only partially uploaded', 
          'student.php?action=Add', 'OK'); break;
      }
      exit;
    } elseif ($_FILES['passport']['type']
      != ('image/jpeg' || 'image/gif' || 'image/png')) {
     echo msg_box('Prolem: file is not an image', 
      'student.php?action=Add', 'OK');
     exit;
    } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
	  
	  $sql="update student set passport='{$_FILES['passport']['name']}'
	  where id={$_REQUEST['id']}";
	  mysql_query($sql) or die(mysql_error());
	  
	  $upfile = "upload/". $_FILES['passport']['name'];
      if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
        if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
          echo msg_box('Problem: Could not move file to destination directory',
           'student.php?action=Add', 'OK');
          exit;
        }
      } else {
        echo msg_box("Problem: Possible file upload attack. Filename: " .
          $_FILES['passport']['name'], 'student.php?action=Add', 'OK');
        exit;
      }
    }
  }
  
   //nl2br --  Inserts HTML line breaks before all newlines in a string 
   //htmlentities --  Convert all applicable characters to HTML entities 
    foreach ($_REQUEST as $key => $value) {
	  if($key == 'Add' || ($key == 'Edit') || ($key == 'View')
	    || ($key == 'Delete') || ($key == 'Print') || ($key == 'Update Student')
		|| ($key == 'Add Student') || ($key == 'delete_previous')) 
	    continue;
      $_REQUEST[$key] = nl2br(htmlentities($value, ENT_QUOTES));
    }
	
  //Now update other student's details
  $sql="update student set 
   admission_number='{$_REQUEST['admission_number']}',      
   firstname='{$_REQUEST['firstname']}', 
   lastname='{$_REQUEST['lastname']}',
   address='{$_REQUEST['address']}', 
   current_class_id={$_REQUEST['class_id']}, 
   date_of_admission='{$_REQUEST['date_of_admission']}', 
   gender='{$_REQUEST['gender_id']}', 
   phone='{$_REQUEST['phone']}', 
   last_school_attended='{$_REQUEST['last_school_attended']}', 
   highest_class_passed='{$_REQUEST['highest_class_passed']}', 
   date_of_birth='{$_REQUEST['date_of_birth']}', 
   parent_guardian_phone='{$_REQUEST['parent_guardian_phone']}', 
   parent_guardian_name='{$_REQUEST['parent_guardian_name']}',
   state_of_origin='{$_REQUEST['state_of_origin']}',
   local_govt_area='{$_REQUEST['local_govt_area']}',
   house='{$_REQUEST['house']}', 
   first_term_times_present='{$_REQUEST['first_term_times_present']}', 
   first_term_times_absent='{$_REQUEST['first_term_times_absent']}',
   second_term_times_present='{$_REQUEST['second_term_times_present']}', 
   second_term_times_absent='{$_REQUEST['second_term_times_absent']}', 
   third_term_times_present='{$_REQUEST['third_term_times_present']}', 
   third_term_times_absent='{$_REQUEST['third_term_times_absent']}', 
   scholarship='{$_REQUEST['scholarship']}'
   where id={$_REQUEST['id']}";
  //echo "$sql<br>";
  mysql_query($sql) or die(mysql_error());
  echo msg_box('Successfully updated', 'student.php', 'Continue');
  exit;
} else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {

  if (($_REQUEST['action'] != 'Add') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a student to edit or view', 
       'student.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] != 'Add') && isset($_REQUEST['id'])){
    $sql = "select * from student where id={$_REQUEST['id']}";
    $result = mysql_query($sql);
	$row = mysql_fetch_array($result);
   
	$admission_number=$row['admission_number'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $address = html_entity_decode($row['address'], ENT_QUOTES);  
	//$address = $row['address'];
    $class_id = $row['current_class_id'];  
    $date_of_admission = $row['date_of_admission'];  
    $date_of_birth = $row['date_of_birth'];  
    $gender = $row['gender'];  
    $phone = $row['phone'];  
    $parent_guardian_name = $row['parent_guardian_name'];  
    $parent_guardian_phone = $row['parent_guardian_phone'];  
    $last_school_attended = $row['last_school_attended'];
    $highest_class_passed = $row['highest_class_passed'];  
    $passport = $row['passport'];
    $state_of_origin = $row['state_of_origin'];
    $local_govt_area = $row['local_govt_area'];
	$house = $row['house'];
	$first_term_times_present = $row['first_term_times_present'];
	$first_term_times_absent = $row['first_term_times_absent'];
	$second_term_times_present = $row['second_term_times_present'];
	$second_term_times_absent = $row['second_term_times_absent'];
	$third_term_times_present = $row['third_term_times_present'];
	$third_term_times_absent = $row['third_term_times_absent'];
	$scholarship = $row['scholarship'];
	
  } else {
    $admission_number="";
    $firstname = "";
    $lastname = "";
    $address = "";
    $class_id = "";
    $date_of_admission = "";
    $date_of_birth = "";
    $gender = "";
    $phone = "";
    $parent_guardian_name = "";
    $parent_guardian_phone = "";
    $last_school_attended = "";
    $highest_class_passed = "";
    $passport="";
    $state_of_origin = "";
    $local_govt_area = "";
	$house = "";
	$first_term_times_present = "";
	$first_term_times_absent = "";
	$second_term_times_present = "";
	$second_term_times_absent = "";
	$third_term_times_present = "";
	$third_term_times_absent = "";
	$scholarship = "";
  }
  
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Student</h3></td>
   </tr>
   <form action="student.php" method="post" name='form1' 
    enctype="multipart/form-data" >
   <?php 
   $class_result = mysql_query("select * from class");
   if (mysql_num_rows($class_result) <= 0) {
     echo msg_box("No Class has been defined<br>
      Please add a class before registering a Student<br>", 
      'class.php', 'Add a Class');
     exit;
   }
   echo "
   <tr>
    <td valign='top' style='width:45em;'>
     <table>
      <tr>
       <td>Admission Number</td>
       <td>
      <input type='text' name='admission_number' value='$admission_number' size='40'></td>
      </tr>
      <tr>
       <td>FirstName</td>
       <td><input type='text' name='firstname' value='$firstname' size='40'></td>
      </tr>
      <tr>
       <td>LastName</td>
       <td><input type='text' name='lastname' value='$lastname' size='40'></td>
      </tr>
      <tr>
       <td>Class</td>
       <td>
   ";
       echo "<select name='class_id' onChange='activate();'>";
       while ($row = mysql_fetch_array($class_result)) {
         echo "<option value='{$row['id']}'";
         if ($row['id'] == $class_id) 
           echo "selected='selected'";
           echo ">{$row['name']}</option>";
         }
         echo "</select>";
         if ($_REQUEST['action'] != 'Add') {
           echo "<input type='checkbox' name='delete_previous'>
            Delete academic record for previous class?
           ";
         }
       echo "
       </td>
      </tr>
      <tr>
       <td>Date of Admission</td>
       <td><input type='text' name='date_of_admission' size='10' maxlength='10'
        value='";
        echo empty($date_of_admission) ? date('Y-m-d'): $date_of_admission;
        echo "'>
       </td>
      </tr>
      <tr>
       <td>Address</td>
       <td> <textarea rows='4' cols='30' name='address'>$address</textarea></td>
      </tr>
      <tr>
       <td>Gender</td>
       <td>
        <select name='gender_id'>
         <option value='Male'
        ";
        echo ($gender == 'Male') ? "selected='selected'" : "";
        echo ">Male</option>
         <option value='Female'
        ";
        echo ($gender == 'Female') ? "selected='selected'": "";
        echo ">Female</option>
        </select>
       </td>
      </tr>
      <tr>
       <td>Date of birth</td>
       <td><input type='text' name='date_of_birth' size='10' maxlength='10' 
        value='";
        echo empty($date_of_birth) ? date('Y-m-d') : $date_of_birth;
        echo "'>
       </td>
      </tr> 
      <tr>
       <td>Phone</td>
       <td><input type='text' name='phone' value='$phone' size='40'></td>
      </tr>
      <tr>
       <td>State of origin</td>
       <td>
        <input type='text' name='state_of_origin' value='$state_of_origin' size='40'>
       </td>
      </tr>
      <tr>
       <td>Local Government Area</td>
       <td>
        <input type='text' name='local_govt_area' value='$local_govt_area' size='40'>
       </td>
      </tr>
	  <tr>
       <td>Parent/Guardian Name</td>
       <td><input type='text' name='parent_guardian_name' size='40' 
        value='$parent_guardian_name'></td>
      </tr>
      <tr>
       <td>Parent/Guardian Phone</td>
       <td><input type='text' name='parent_guardian_phone' 
       value='$parent_guardian_phone' size='40'></td>
      </tr>  
	  <tr>
       <td>Last School Attended</td>
       <td> <textarea rows='4' cols='30' name='last_school_attended'>$last_school_attended</textarea></td>
      </tr>
	  <tr>
       <td>Highest Class Passed</td>
       <td> <textarea rows='4' cols='30' name='highest_class_passed'>$highest_class_passed</textarea></td>
      </tr>
	  
     </table>
    </td>
    <td style='vertical-align:top;'>
     <table>
      <tr>
       <td colspan='3'>
        <img src='upload/$passport' width='200' height='200'></td>
      </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
       <td>Passport</td>
       <td><input type='file' name='passport'></td>
      </tr>
	  <tr><td>House</td><td><input type='text' name='house' value='$house'></td></tr>
	  <tr>
	   <td>Scholarship</td>
	   <td>
	    <select name='scholarship'>
	";
		 if ($scholarship == 'No') {
		   echo "<option selected='selected'>No</option>
		         <option>Yes</option>";
		 } else if ($scholarship == 'Yes') {
		   echo "<option selected='selected'>Yes</option>
		         <option>No</option>";
		 } else {
		   echo "<option>No</option>
		         <option>Yes</option>
				";
	    }
	  echo "</select></td>
	  <tr>
	   <td colspan='2'>
	    <fieldset>
         <legend>First Term</legend>
         <table style='border: 0.1px solid black;'>
          <tr><td>Times Present</td><td><input type='text' name='first_term_times_present' value='$first_term_times_present'></td></tr>
		  <tr><td>Times Absent</td><td><input type='text' name='first_term_times_absent' value='$first_term_times_absent'></td></tr>
		 </table>
		</fieldset>
	   </td>
	  </tr> 
	  <tr>
	   <td colspan='2'>
	    <fieldset>
         <legend>Second Term</legend>
         <table style='border: 0.1px solid black;'>
          <tr><td>Times Present</td><td><input type='text' name='second_term_times_present' value='$second_term_times_present'></td></tr>
		  <tr><td>Times Absent</td><td><input type='text' name='second_term_times_absent' value='$second_term_times_absent'></td></tr>
		 </table>
		</fieldset>
	   </td>
	  </tr>  
	  <tr>
	   <td colspan='2'>
	    <fieldset>
         <legend>Third Term</legend>
         <table style='border: 0.1px solid black;'>
          <tr><td>Times Present</td><td><input type='text' name='third_term_times_present' value='$third_term_times_present'></td></tr>
		  <tr><td>Times Absent</td><td><input type='text' name='third_term_times_absent' value='$third_term_times_absent'></td></tr>
		 </table>
		</fieldset>
	   </td>
	  </tr>  
	  
	  </table>
    </td>
   </tr>
      <tr>
       <td colspan='2' style='text-align:center;'>";
       if ($_REQUEST['action'] != 'View') {
         if($_REQUEST['action'] == 'Edit') { 
           echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
         }
         echo "<input name='action' type='submit' value='"; 
         echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
         echo " Student'>";
       }
       ?>
       <input name="action" type="submit" value="Cancel">
       </td>
      </tr>
	 </form>
  </table>
  <?
  exit;
  } 
  /*
  else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Search')) {
    echo "<h1>Weldone Oh</h1>";
	
   }
   */
  if (!isset($_REQUEST['action']) || 
   (isset($_REQUEST['filter']) && ($_REQUEST['filter'] == 'student_class'))
    ||($_REQUEST['action'] == 'Cancel') || ($_REQUEST['action'] == 'Print')
	|| ($_REQUEST['action'] == 'Search')) {
  ?>
  <table border='1'>
   <tr class='class1'>
    <?php 
    if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
      echo "<td></td>";
    } else {
      echo "<td>
    <form name='form1' action='student.php' method='post'>
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
     <h3>Students List</h3>
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
     <?php
	 if (isset($_REQUEST['count'])) {
	   $count = $_REQUEST['count'];
	   $count += 20;
	 } else {
	   $count = 0;
	 }
	 $sql = "select * from student ";
	 $sql2="";
     if (isset($_REQUEST['filter']) && ($_REQUEST['filter']== 'student_class')){
       $sql2 = " 
         current_class_id={$_REQUEST['class_id']}";
     }
	 $sql3 = "";
	 if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'Search')){
	  $sql3 = " admission_number like '%{$_REQUEST['search']}%' 
	    or firstname LIKE '%{$_REQUEST['search']}%'
		or lastname LIKE '%{$_REQUEST['search']}%'
		or gender LIKE '%{$_REQUEST['search']}%'
		or address LIKE '%{$_REQUEST['search']}%'
	    or state_of_orign LIKE '%{$_REQUEST['search']}%'
		or local_govt_area LIKE '%{$_REQUEST['search']}%'
		or house LIKE '%{$_REQUEST['search']}%'
		";
	 }
	 if ((!empty($sql2)) && (!empty($sql3))) {
	   $sql .= " where $sql2 and $sql3 order by lastname limit $count, 20 ";
	 } else if (empty($sql2) && (!empty($sql3))) {
	   $sql .= " where $sql3 order by lastname limit $count, 20 ";
	 } else if ((!empty($sql2)) && (empty($sql3))) {
	   $sql .= " where $sql2 order by lastname limit $count, 20 ";
	 } else if (empty($sql2) && empty($sql3)) {
	   $sql .= " order by lastname limit $count, 20 ";
	 }
	 //echo "$sql<br>";
     ?>
   <tr>
    <th></th>
    <th>Admission Number</th>
    <th>Lastname</th>
	<th>Firstname</th>
    <th>Current Class</th>
   </tr>
   <?
   //echo "$sql<br>";
   $result = mysql_query($sql, $con) or die(mysql_error() . 'Error here');
   if (mysql_num_rows($result) <= 0) {
     echo "<tr style='text-align:center;'>
       <td colspan='5'><h4>No Student Found</h4></td></tr></form></table>";
     exit;
   }
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td style='width:1px;'><input type='radio' name='id' value='<?php echo $row['id'];?>'></td>
     <td><?php echo $row['admission_number'];?></td>
	 <td><?php echo $row['lastname'];?></td>
     <td><?php echo $row['firstname'];?></td>
     <td><?php echo 
       get_value('class', 'name', 'id', $row['current_class_id'], $con);
      ?>
     </td>
    </tr>
    <?
    }
	$student_class = "";
	if (isset($_REQUEST['filter']) && ($_REQUEST['filter']== 'student_class')){
      echo "<input type='hidden' name='filter' value='student_class'>
         <input type='hidden' name='class_id' value='{$_REQUEST['class_id']}'>";
	  $student_class = "&filter=student_class&class_id={$_REQUEST['class_id']}";
    }
	if (!empty($sql2)) 
	  $sql="select count(*) as 'count' from student where $sql2";
	else 
	  $sql = "select count(*) as 'count' from student";
	  
	//echo "$sql<br>";
	$result = mysql_query($sql) or die(mysql_error());
	
	$row = mysql_fetch_array($result);
	
	echo "<tr class='class1' style='text-align:center;'>
		 <td>Page " . (($count/20) + 1) . "</td>";
	
	if (isset($_REQUEST['search'])) {
	  echo "<td colspan='6'>&nbsp;</td>";
	} else if (($row['count'] > 20) && ($row['count'] > ($count+20))) {
	   echo "<td colspan='6'><a href='student.php?count=$count{$student_class}'>More>></a></td>";
	} else {
	  echo "<td colspan='6'>&nbsp;</td>";
	}
	echo "</tr>";
	if (isset($_REQUEST['filter']) && ($_REQUEST['filter']== 'student_class')){
      echo "<input type='hidden' name='filter' value='student_class'>
         <input type='hidden' name='class_id' value='{$_REQUEST['class_id']}'>";
    }
    echo '</form></table>';
    main_footer();
}
?>
