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
  print_header('Student List', 'student_fosla.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student_fosla.php', 'Back');
    exit;
  }
  echo msg_box("Deleting a Student will delete all his
   Academic and Financial records", 
   "student_fosla.php?action=confirm_delete&id={$_REQUEST['id']}", 
   'Continue to Delete?');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student_fosla.php', 'Back');
     exit;
  }
  $sql="select * from student_fosla where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
  if (mysql_num_rows($result) <= 0) {
    echo msg_box("Student does not exist in the database", 'student_fosla_fosla.php', 'OK');
    exit;
  }
  $sql="delete from student_subject where student_id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  $sql="delete from student_fee where student_id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  $sql="delete from student_fosla where id={$_REQUEST['id']}";
  $result = mysql_query($sql) or die(mysql_error());
	
  echo msg_box("Student has been deleted", 'student_fosla.php', 'OK');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Student')) {
  if (empty($_REQUEST['admission_number']))  {
    echo msg_box('Please enter Admission Number', 
     'student_fosla.php?action=Add', 'Back');
    exit;
  }
  if (empty($_REQUEST['firstname']) || empty($_REQUEST['lastname']))  {
    echo msg_box('Please enter correct firstname or lastname', 
      'student_fosla.php?action=Add', 'Back');
    exit;
  }
  if (empty($_REQUEST['class_id'])) {
    echo msg_box('Please choose a class for this student', 
      'student_fosla.php?action=Add', 'Back');
    exit;
  }
  //Todo:Cross check date
  //Do not register the student_fosla if He/She has the same 
  //admission number as someone else in the database
  $sql="select * from student_fosla where 
     admission_number='{$_REQUEST['admission_number']}'";
  $result = mysql_query($sql);
  if (mysql_num_rows($result) > 0) {
    echo msg_box("There is already a student with the same
      admission number.<br>Please choose another admission number<br>", 
      'student_fosla.php?action=Add', 'Back to adding student');
    exit;
  }
    if (!empty($_FILES['passport']['name'])) {
  //Lets upload the file
    if ($_FILES['passport']['error'] > 0) {
      switch($_FILES['passport']['error']) {
        case 1: echo msg_box('File exceeded upload max_filesize', 
         'student_fosla.php?action=Add', 'OK'); break;
        case 2: echo msg_box('File exceeded max_file_size', 
         'student_fosla.php?action=Add', 'OK'); break;
        case 3: echo msg_box('File only partially uploaded', 
          'student_fosla.php?action=Add', 'OK'); break;
        case 4: echo msg_box('No file uploaded', 
          'student_fosla.php?action=Add', 'OK'); break;
      }
      exit;
    } elseif ($_FILES['passport']['type']
            != ('image/jpeg' || 'image/gif' || 'image/png')) {
      echo msg_box('Prolem: file is not an image', 'student_fosla.php?action=Add', 'OK');
      exit;
    } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
      $upfile = "upload/". $_FILES['passport']['name'];
      if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
        if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
          echo msg_box('Problem: Could not move file to destination directory',
           'student_fosla.php?action=Add', 'OK');
          exit;
        }
      } else {
        echo msg_box("Problem: Possible file upload attack. Filename: " .
        $_FILES['passport']['name'], 'student_fosla.php?action=Add', 'OK');
        exit;
      }
    }
  }
  //Go ahead and register the student
  /*
  $sql="insert into student (admission_number, firstname, lastname, address, 
    current_class_id, date_of_admission, gender, phone, last_school_attended, 
    highest_class_passed, date_of_birth, parent_guardian_phone, 
    parent_guardian_name, passport, state_of_origin, local_govt_area, 
	house, times_present, times_absent)
    values('{$_REQUEST['admission_number']}', '{$_REQUEST['firstname']}',
    '{$_REQUEST['lastname']}', '{$_REQUEST['address']}',
    {$_REQUEST['class_id']}, '{$_REQUEST['date_of_admission']}', 
    '{$_REQUEST['gender_id']}', '{$_REQUEST['phone']}', 
    '{$_REQUEST['last_school_attended']}', 
    '{$_REQUEST['highest_class_passed']}', '{$_REQUEST['date_of_birth']}', 
    '{$_REQUEST['parent_guardian_phone']}', 
    '{$_REQUEST['parent_guardian_name']}', '{$_FILES['passport']['name']}', 
    '{$_REQUEST['state_of_origin']}', '{$_REQUEST['local_govt_area']}', 
	'{$_REQUEST['house']}', '{$_REQUEST['times_present']}', 
	'{$_REQUEST['times_absent']}')";
  */
  $sql="insert into student_fosla (admission_number, firstname, lastname,
   current_class_id, date_of_admission, date_of_birth, gender, 
   place_of_birth, home_town, state_of_origin, nationality, 
   religious_denomination, father_name, father_address, father_email, 
   father_phone, mother_name, mother_address, mother_email, mother_phone, 
   guardian_name, guardian_address, guardian_email, guardian_phone, 
   guardian_relationship_with_student, class_seeking_admission_into, 
   previous_school_attended, last_class_in_previous_school, hobbies, 
   games_sporting_skill, medical_problem, special_diet, other_information, 
   passport, house, times_present, 
   times_absent) values 
    ('{$_REQUEST['admission_number']}', '{$_REQUEST['firstname']}',
    '{$_REQUEST['lastname']}', 
    {$_REQUEST['class_id']}, '{$_REQUEST['date_of_admission']}', 
    '{$_REQUEST['date_of_birth']}', '{$_REQUEST['gender_id']}', 
	'{$_REQUEST['place_of_birth']}', '{$_REQUEST['home_town']}', 
    '{$_REQUEST['state_of_origin']}', '{$_REQUEST['nationality']}', 
	'{$_REQUEST['religious_denomination']}', '{$_REQUEST['father_name']}', 
    '{$_REQUEST['father_address']}', '{$_REQUEST['father_email']}',
	'{$_REQUEST['father_phone']}', '{$_REQUEST['mother_name']}', 
    '{$_REQUEST['mother_address']}', '{$_REQUEST['mother_email']}',
	'{$_REQUEST['mother_phone']}',
	'{$_REQUEST['guardian_name']}', 
    '{$_REQUEST['guardian_address']}', '{$_REQUEST['guardian_email']}',
	'{$_REQUEST['guardian_phone']}',
	'{$_REQUEST['guardian_relationship_with_student']}', 
	'{$_REQUEST['class_seeking_admission_into']}',
	'{$_REQUEST['previous_school_attended']}',
	'{$_REQUEST['last_class_in_previous_school']}', '{$_REQUEST['hobbies']}',
	'{$_REQUEST['games_sporting_skill']}',
	'{$_REQUEST['medical_problem']}',	'{$_REQUEST['special_diet']}',	
	'{$_REQUEST['other_information']}',	
	'{$_FILES['passport']['name']}', 
	'{$_REQUEST['house']}', '{$_REQUEST['times_present']}', 
	'{$_REQUEST['times_absent']}')";
  //echo "$sql<br>";
  mysql_query($sql) or die(mysql_error());
  $student_id = mysql_insert_id(); //Get Student ID
   
  //Get the type of class
  $sql = "select type from class where id={$_REQUEST['class_id']}";
  $result = mysql_query($sql) or die(mysql_error());
  $row = mysql_fetch_array($result);

  //Get all the subjects of this type of class
  $sql="select * from subject where type='{$row['type']}'";
  $result = mysql_query($sql) or die(mysql_error());

  //Register the following subjects for this student
  while($row = mysql_fetch_array($result)) {
    //Make sure there are no subjects registered for this student for this
    //class and this subject
    $sql="delete from student_subject where 
     session_id={$_SESSION['session_id']}
     and term_id={$_SESSION['term_id']} 
     and class_id={$_REQUEST['class_id']}
     and student_id=$student_id
     and subject_id={$row['id']}";
    mysql_query($sql) or die(mysql_error());

    //Now register the subject for this student
    $sql="insert into student_subject(session_id, term_id, class_id,
      student_id, subject_id, test, exam)
      values({$_SESSION['session_id']},
      {$_SESSION['term_id']}, {$_REQUEST['class_id']}, $student_id,
      {$row['id']}, '0','0')";
    mysql_query($sql) or die(mysql_error());
  }
  echo msg_box('Student successfully entered', 'student_fosla.php', 'Continue');
  exit;
} else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Student')) {
  if (empty($_REQUEST['id'])) {
    echo msg_box("Please choose a student", 'student_fosla.php', 'Back');
     exit;
  }
  if (empty($_REQUEST['admission_number']))  {
    echo msg_box('Please enter Admission Number', 'student_fosla.php', 'Back');
    exit;
  }
  if (empty($_REQUEST['firstname']) || empty($_REQUEST['lastname']))  {
    echo msg_box('Please enter correct firstname or lastname', 
      'student_fosla.php', 'Back');
     exit;
  }
  if (empty($_REQUEST['class_id'])) {
      echo msg_box('Please choose a class for this student', 
       'student_fosla.php', 'Back');
      exit;
  }
  //Todo:Cross check date

  if (isset($_REQUEST['delete_previous'])) {
    //Get previous current_class_id
    //echo "Delete Previous <br>";
    $sql = "select * from student_fosla where id={$_REQUEST['id']}";
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
          'student_fosla.php?action=Add', 'OK'); break;
        case 2: echo msg_box('File exceeded max_file_size', 
          'student_fosla.php?action=Add', 'OK'); break;
        case 3: echo msg_box('File only partially uploaded', 
          'student_fosla.php?action=Add', 'OK'); break;
      }
      exit;
    } elseif ($_FILES['passport']['type']
      != ('image/jpeg' || 'image/gif' || 'image/png')) {
     echo msg_box('Prolem: file is not an image', 
      'student_fosla.php?action=Add', 'OK');
     exit;
    } else {
      //Delete previous file
      //unlink("upload/". $row['logo']);
	  
	  $sql="update student_fosla set passport='{$_FILES['passport']['name']}'
	  where id={$_REQUEST['id']}";
	  mysql_query($sql) or die(mysql_error());
	  
	  $upfile = "upload/". $_FILES['passport']['name'];
      if(is_uploaded_file($_FILES['passport']['tmp_name'])) {
        if(!move_uploaded_file($_FILES['passport']['tmp_name'], $upfile)) {
          echo msg_box('Problem: Could not move file to destination directory',
           'student_fosla.php?action=Add', 'OK');
          exit;
        }
      } else {
        echo msg_box("Problem: Possible file upload attack. Filename: " .
          $_FILES['passport']['name'], 'student_fosla.php?action=Add', 'OK');
        exit;
      }
    }
  }
  //Now update other student's details
  $sql="update student_fosla set 
   admission_number='{$_REQUEST['admission_number']}',      
   firstname='{$_REQUEST['firstname']}', 
   lastname='{$_REQUEST['lastname']}',
   date_of_birth='{$_REQUEST['date_of_birth']}',
   current_class_id={$_REQUEST['class_id']}, 
   date_of_admission='{$_REQUEST['date_of_admission']}', 
   gender='{$_REQUEST['gender_id']}', 
   place_of_birth='{$_REQUEST['place_of_birth']}',
   home_town='{$_REQUEST['home_town']}', 
   state_of_origin='{$_REQUEST['state_of_origin']}', 
   nationality='{$_REQUEST['nationality']}', 
   religious_denomination='{$_REQUEST['religious_denomination']}', 
   father_name='{$_REQUEST['father_name']}', 
   father_address='{$_REQUEST['father_address']}',
   father_email='{$_REQUEST['father_email']}', 
   father_phone='{$_REQUEST['father_phone']}', 
   
   mother_name='{$_REQUEST['mother_name']}', 
   mother_address='{$_REQUEST['mother_address']}',
   mother_email='{$_REQUEST['mother_email']}', 
   mother_phone='{$_REQUEST['mother_phone']}', 
   
   guardian_name='{$_REQUEST['guardian_name']}', 
   guardian_address='{$_REQUEST['guardian_address']}',
   guardian_email='{$_REQUEST['guardian_email']}', 
   guardian_phone='{$_REQUEST['guardian_phone']}', 

   guardian_relationship_with_student = '{$_REQUEST['guardian_relationship_with_student']}', 
   class_seeking_admission_into = '{$_REQUEST['class_seeking_admission_into']}',
   previous_school_attended='{$_REQUEST['previous_school_attended']}',
   last_class_in_previous_school = '{$_REQUEST['last_class_in_previous_school']}', 
   hobbies='{$_REQUEST['hobbies']}',
   games_sporting_skill='{$_REQUEST['games_sporting_skill']}',
   medical_problem='{$_REQUEST['medical_problem']}',
   special_diet='{$_REQUEST['special_diet']}',	
   other_information='{$_REQUEST['other_information']}',	 	
   house='{$_REQUEST['house']}', 
   times_present='{$_REQUEST['times_present']}', 
   times_absent='{$_REQUEST['times_absent']}'
   where id={$_REQUEST['id']}";
  //echo "$sql<br>";
  mysql_query($sql) or die(mysql_error());
  echo msg_box('Successfully updated', 'student_fosla.php', 'Continue');
  exit;
} else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit') || 
    ($_REQUEST['action'] == 'View'))) {

  if (($_REQUEST['action'] != 'Add') && (!isset($_REQUEST['id']))){
    echo msg_box('Please choose a student to edit or view', 
       'student_fosla.php', 'Back');
    exit;
  }
  if (($_REQUEST['action'] != 'Add') && isset($_REQUEST['id'])){
    $sql = "select * from student_fosla where id={$_REQUEST['id']}";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $admission_number=$row['admission_number'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $class_id = $row['current_class_id'];  
    $date_of_admission = $row['date_of_admission'];  
    $date_of_birth = $row['date_of_birth'];  
    $gender = $row['gender'];  
	$place_of_birth = $row['place_of_birth'];  
	$home_town = $row['home_town'];  
	$state_of_origin = $row['state_of_origin'];
	$nationality = $row['nationality'];
	$religious_denomination = $row['religious_denomination'];
	
    $father_name = $row['father_name'];  
	$father_address = $row['father_address'];  
	$father_email = $row['father_email'];  
	$father_phone = $row['father_phone'];  
	
	$mother_name = $row['mother_name'];  
	$mother_address = $row['mother_address'];  
	$mother_email = $row['mother_email'];  
	$mother_phone = $row['mother_phone'];  
	
	$guardian_name = $row['guardian_name'];  
	$guardian_address = $row['guardian_address'];  
	$guardian_email = $row['guardian_email'];  
	$guardian_phone = $row['guardian_phone'];  
	
    $guardian_relationship_with_student = $row['guardian_relationship_with_student'];  
    $class_seeking_admission_into = $row['class_seeking_admission_into'];  
    $previous_school_attended = $row['previous_school_attended'];  
	$last_class_in_previous_school = $row['last_class_in_previous_school'];
	$hobbies = $row['hobbies'];
	$games_sporting_skill = $row['games_sporting_skill'];
	$medical_problem = $row['medical_problem'];
	$special_diet = $row['special_diet'];
    $other_information=$row['other_information'];	
    $passport = $row['passport'];
	$house = $row['house'];
	$times_present = $row['times_present'];
	$times_absent = $row['times_absent'];
  } else {
  
    $admission_number="";
    $firstname = "";
    $lastname = "";
    $class_id = "";  
    $date_of_admission = "";  
    $date_of_birth = "";  
    $gender = "";  
	$place_of_birth = "";  
	$home_town = "";  
	$state_of_origin = "";
	$nationality = "";
	$religious_denomination = "";
	
    $father_name = "";  
	$father_address = "";  
	$father_email = "";  
	$father_phone = "";  
	
	$mother_name = "";  
	$mother_address = "";  
	$mother_email = "";  
	$mother_phone = "";  
	
	$guardian_name = "";  
	$guardian_address = "";  
	$guardian_email = "";  
	$guardian_phone = "";  
	
    $guardian_relationship_with_student = "";  
    $class_seeking_admission_into = "";  
    $previous_school_attended = "";  
	$last_class_in_previous_school = "";
	$hobbies = "";
	$games_sporting_skill = "";
	$medical_problem = "";
	$special_diet = "";
	$other_information="";
    $passport = "";
    $house = "";
	$times_present = "";
	$times_absent = "";
  }
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Student</h3></td>
   </tr>
   <form action="student_fosla.php" method="post" name='form1' 
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
    <td style='width:50em;'>
     <table>
      <tr>
       <td>Admission Number</td>
       <td>
      <input type='text' name='admission_number' value='$admission_number'></td>
      </tr>
      <tr>
       <td>FirstName</td>
       <td><input type='text' name='firstname' value='$firstname'></td>
      </tr>
      <tr>
       <td>LastName</td>
       <td><input type='text' name='lastname' value='$lastname'></td>
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
       <td>Place of birth</td>
       <td><input type='text' name='place_of_birth' size='10' maxlength='10' 
        value='$place_of_birth'>
       </td>
      </tr> 
	  <tr>
       <td>Home Town</td>
       <td><input type='text' name='home_town' value='$home_town'></td>
      </tr>
	  <tr>
       <td>State of origin</td>
       <td>
        <input type='text' name='state_of_origin' value='$state_of_origin'>
       </td>
      </tr>
	  <tr>
       <td>Nationality</td>
       <td>
        <input type='text' name='nationality' value='$nationality'>
       </td>
      </tr>
	  <tr>
       <td>Religious Denomination</td>
       <td>
        <input type='text' name='religious_denomination' value='$religious_denomination'>
       </td>
      </tr>
	  <tr>
       <td>Father Name</td>
       <td>
        <input type='text' name='father_name' value='$father_name'>
       </td>
      </tr>
	  <tr>
       <td>Father Address</td>
       <td> <textarea rows='4' cols='30' name='father_address'>$father_address</textarea></td>
      </tr>
      <tr>
       <td>Father Phone</td>
       <td><input type='text' name='father_phone' value='$father_phone'></td>
      </tr>
      <tr>
       <td>Father Email</td>
       <td><input type='text' name='father_email' value='$father_email'></td>
      </tr>
	  <tr>
       <td>Mother Name</td>
       <td>
        <input type='text' name='mother_name' value='$mother_name'>
       </td>
      </tr>
	  <tr>
       <td>mother Address</td>
       <td> <textarea rows='4' cols='30' name='mother_address'>$mother_address</textarea></td>
      </tr>
      <tr>
       <td>mother Phone</td>
       <td><input type='text' name='mother_phone' value='$mother_phone'></td>
      </tr>
      <tr>
       <td>mother Email</td>
       <td><input type='text' name='mother_email' value='$mother_email'></td>
      </tr>
	  <tr>
       <td>Guardian Name</td>
       <td>
        <input type='text' name='guardian_name' value='$guardian_name'>
       </td>
      </tr>
	  <tr>
       <td>guardian Address</td>
       <td> <textarea rows='4' cols='30' name='guardian_address'>$guardian_address</textarea></td>
      </tr>
      <tr>
       <td>guardian Phone</td>
       <td><input type='text' name='guardian_phone' value='$guardian_phone'></td>
      </tr>
      <tr>
       <td>guardian Email</td>
       <td><input type='text' name='guardian_email' value='$guardian_email'></td>
      </tr>
      <tr>
       <td>Guardian relationship with the Student</td>
       <td>
        <input type='text' name='guardian_relationship_with_student' value='$guardian_relationship_with_student'>
       </td>
      </tr>
	  <tr>
       <td>Class seeking admission into </td>
       <td><input type='text' name='class_seeking_admission_into' size='40' 
        value='$class_seeking_admission_into'></td>
      </tr>
      <tr>
       <td>Previous School Attended</td>
       <td><input type='text' name='previous_school_attended' 
       value='$previous_school_attended'></td>
      </tr>  
	  <tr>
       <td>Last class in previous school</td>
       <td><input type='text' name='last_class_in_previous_school' 
       value='$last_class_in_previous_school'></td>
      </tr>  
	  <tr>
       <td>Hobbies</td>
       <td><input type='text' name='hobbies' value='$hobbies'></td>
      </tr>
	  <tr>
       <td>Games Sporting Skill</td>
       <td><input type='text' name='games_sporting_skill' value='$games_sporting_skill'></td>
      </tr>
	  <tr>
       <td>Medical Problem</td>
       <td><input type='text' name='medical_problem' value='$medical_problem'></td>
      </tr>
	  <tr>
       <td>Special Diet</td>
       <td><input type='text' name='special_diet' value='$special_diet'></td>
      </tr>
	  <tr>
       <td>Other Information</td>
       <td><input type='text' name='other_information' value='$other_information'></td>
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
	  <tr><td>Times Present</td><td><input type='text' name='times_present' value='$times_present'></td></tr>
	  <tr><td>Times Absent</td><td><input type='text' name='times_absent' value='$times_absent'></td></tr>
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
  </table>
  <?
  exit;
  } 
  if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'student_class')
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
    <form name='form1' action='student_fosla.php' method='post'>
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
     <h3>List of Students </h3>
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
	 $sql = "select * from student_fosla ";
	 $sql2="";
     if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'student_class')){
       $sql2 = " where 
         current_class_id={$_REQUEST['class_id']}";
     } 
	 $sql3 = "";
	 if (isset($_REQUEST['action']) && ($_REQUEST['action']== 'Search')){
	  $sql3 = " admission_number like '%{$_REQUEST['search']}%' 
	    or firstname LIKE '%{$_REQUEST['search']}%'
		or lastname LIKE '%{$_REQUEST['search']}%'";
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
	 //$sql .= " $sql2 order by lastname limit $count, 20 ";
     ?>
     
   
   <tr>
    <th></th>
    <th>Admission Number</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Current Class</th>
   </tr>
   <?
   $result = mysql_query($sql, $con);
   if (mysql_num_rows($result) <= 0) {
     echo "<tr style='text-align:center;'>
       <td colspan='5'><h4>No Student Found</h4></td></tr></form></table>";
     exit;
   }
   while($row = mysql_fetch_array($result)) {
   ?>
    <tr>
     <td><input type='radio' name='id' value='<?php echo $row['id'];?>'></td>
     <td><?php echo $row['admission_number'];?></td>
     <td><?php echo $row['firstname'];?></td>
     <td><?php echo $row['lastname'];?></td>
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
	
	$sql="select count(*) as 'count' from student_fosla where $sql2";
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	echo "<tr class='class1' style='text-align:center;'>
		 <td>Page " . (($count/20) + 1) . "</td>";
	
	if (isset($_REQUEST['search'])) {
	  echo "<td colspan='6'>&nbsp;</td>";
	} else if (($row['count'] > 20) && ($row['count'] > ($count+20))) {
	   echo "<td colspan='6'><a href='student_fosla.php?count=$count{$student_class}'>More>></a></td>";
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