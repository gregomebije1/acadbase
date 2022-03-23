<?php
include_once("util.inc");

if (!search_table('user', 'school_id', $con)) {
  version_one_updates($con);
}
$school_id = 1;

//These are version two updates
if(!search_table('class_type', 'school_id', $con))  {
  version_two_updates($school_id, $con);
}

function version_two_updates($school_id, $con) {
  //Version two updates
  $sql="alter table class_type add column school_id integer";
  mysqli_query($con, $sql) or die(mysqli_error($con));
     
  $sql="update class_type set school_id={$school_id}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
 
  $sql="update subject set school_id='1'";
  mysqli_query($con, $sql) or die(mysql_errorr());

  $sql="alter table term change name name enum('FIRST', 'SECOND', 'THIRD')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="update term set name = 'FIRST' where name='First'";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="update term set name = 'SECOND' where name='Second'";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="update term set name = 'THIRD' where name='Third'";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="alter table student_fees drop column amount_due";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Lets create a user for each student, with their pincode
  $sql="select * from student where school_id={$school_id}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  $student = array();
  while($row = mysqli_fetch_array($result))
    $student[$row['admission_number']] = $row['id'];

  foreach($student as $admission => $id) {
    $pincode = mt_rand() + $school_id;
    $sql="insert into user(name, passwd, school_id)
      values('$admission', '$pincode', '$school_id')";
    mysqli_query($con, $sql) or die(mysqli_error($con));

    $sql="insert into user_permissions(uid, pid, school_id)
      values('$id', '6', '$school_id')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }
}
function version_one_updates($con) {

  //Please note that this update is just run once,
  //in the life time of this program
  //It was created to add school_id column field to all the tables
  //and set the school_id field value with the ID of the school table

  global $database;
  $db = "Tables_in_$database";

  //Get School ID
  //This is assuming that there is only one school in the database.
  //which should happen if this is run on karshi database or GITC database
  $result = mysql_query("select * from school") or die(mysqli_error($con));
  $row = mysqli_fetch_array($result);
  $school_id = $row['id'];

  if (!search_table('user', 'school_id', $con)) { 
    //if school_id field not in user table then

    $result = mysql_query("show tables", $con) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($result)) {
      if ($row[$db] == 'permissions') //Skip permissions table
        continue;

      if ($row[$db] == 'school') //Skip school table
        continue;

      //Add column school_id to this table
      $sql="alter table {$row[$db]} add column school_id integer";
      mysqli_query($con, $sql) or die(mysqli_error($con));

      //update school_id column for this table
      $sql="update {$row[$db]} set school_id=$school_id";
      mysqli_query($con, $sql) or die(mysqli_error($con));

    }
  }  

  $arr = array();
  $arr['student_comment'] = "create table student_comment ( 
      id integer auto_increment primary key, 
      session_id integer, 
      term_id integer,
      class_id integer,   
      student_id integer,
      teacher text, 
      principal text,
      school_id integer
     )";
	 
  $arr['student_fees'] ="CREATE TABLE student_fees (
      id int(11) NOT NULL auto_increment primary key,
      session_id int(11) default NULL,
      term_id int(11) default NULL,
      class_id int(11) default NULL,
      student_id int(11) default NULL,
      date date,
      amount_paid varchar(100),
      school_id integer
     )";	 


  $arr['class_type'] = "create table class_type (
    id integer auto_increment primary key,
    name varchar(100),
    description text)";
	
  
  //Since this is an upgrade, we need to check if this table exist
  //If it doesn't exist then create it automatically
  $result = mysql_query("show tables", $con) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    if(array_key_exists($row[$db], $arr)) {
      unset($arr[$row[$db]]);
    }
  }
  foreach($arr as $t => $sql) 
    mysqli_query($con, $sql) or die(mysqli_error($con));
  
  unset($arr);
  
  ///General Updates
  $arr[] ="truncate table account";
  $arr[] ="truncate table journal";
  $arr[] ="truncate table audit_trail";
  $arr[] ="insert into permissions(name) values('Proprietor')";
  $arr[] = "insert into class_type(name, description, school) 
    values('JSS', 'Junior Secondary School', 1),
          ('SSS', 'Senior Secondary School', 1)";
  $arr[] = "drop table staff";
  
  foreach($arr as $sql) {
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }
  
  
  //Drop all these tables. We want to use a standard set of columns for 
  //student table
  //and another for staff table
  $arr = array('gender', 'address', 'date_of_birth', 'place_of_birth', 
    'address', 'home_town','nationality', 'religious_denomination', 
    'father_name', 'father_address', 'father_phone', 'father_email', 
    'mother_name', 'mother_address', 'mother_phone', 'mother_email', 
    'guardian_name', 'guardian_address', 'guardian_phone','guardian_email', 
    'guardian_relationship', 
    'last_school_attended', 'highest_class_passed', 
    'class_seeking_admission_into', 'previous_school_attended',
    'last_class_in_previous_school','hobbies', 'games_sporting_skill', 
    'medical_problem', 'special_diet', 'acc_id', 'status',
    'guardian_relationship_with_student','other_information', 
    'state_of_origin', 'passport_image', 'house', 'state_of_origin', 
    'local_govt_area','parent_guardian_name', 'parent_guardian_phone', 
    'last_school_attended', 'highest_class_passed', 'any_other_information',
    'passport');

  foreach($arr as $column) {
    if(search_table('student', $column, $con)) {
      mysql_query("alter table student drop column $column", $con) 
       or die(mysqli_error($con));
    }
  }
	  
  //Lets add these new columns to the student table
  unset($arr);
  
  $sql="ALTER TABLE student CHANGE current_class_id class_id integer";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="alter table class change type class_type_id integer";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $sql="update class set class_type_id=1";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="update subject set type='1' where type='jss'";
  mysqli_query($con, $sql) or die(mysql_errorr());
  
  $sql="update subject set type='2' where type='sss'";
  mysqli_query($con, $sql) or die(mysql_errorr());

  
  $sql="alter table subject change type class_type_id varchar(100)";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  
  $arr['gender'] = "alter table student 
    add column gender enum('Male', 'Female') after class_id";
  $arr['house'] = "alter table student 
    add column state_of_origin varchar(100) after age";
  
  $arr['state_of_origin'] = "alter table student 
    add column state_of_origin varchar(100) after house";

  $arr['local_govt_area'] = "alter table student 
    add column house varchar(100) after state_of_origin";
  
  $arr['parent_guardian_name'] = "alter table student 
    add column parent_guardian_name text after state_of_origin";

  $arr['parent_guardian_phone'] = "alter table student 
    add column parent_guardian_phone text after parent_guardian_name";

  $arr['parent_guardian_address'] = "alter table student 
    add column parent_guardian_address text after parent_guardian_phone";
  
  $arr['last_school_attended'] = "alter table student 
    add column last_school_attended text";

  $arr['highest_class_passed'] = "alter table student 
    add column highest_class_passed text";

  $arr['any_other_information'] = "alter table student 
    add column any_other_information text";

  $arr['passport_image'] = "alter table student 
    add column passport_image varchar(100)";
  
  foreach($arr as $column => $sql)
    if(!search_table('student', $column, $con))
      mysqli_query($con, $sql) or die(mysqli_error($con));
	  
}

function search_table($table, $field, $con) {
  $result = mysql_query("describe $table",  $con);
  while($row = mysqli_fetch_array($result))
    if ($row[0] == $field)
	  return true;
  return false;
}

