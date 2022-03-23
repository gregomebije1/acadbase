<?
error_reporting(E_ALL);

require_once "school.inc";

$con = connect();

$sql[] = "alter table student change age date_of_birth date";
$sql[] = "alter table student drop column state_of_origin";
$sql[] = "alter table student drop column parent_guardian_name";
$sql[] = "alter table student drop column parent_guardian_phone";
$sql[] = "alter table student drop column parent_guardian_address";
$sql[] = "alter table student drop column house";
$sql[] = "alter table student drop column last_school_attended";
$sql[] = "alter table student drop column highest_class_passed";
$sql[] = "alter table student add column house varchar(100) after gender";
$sql[] = "alter table student add column state_of_origin varchar(100) 
    after house";
$sql[] = "alter table student add column parent_guardian_info varchar(100) 
    after scholarship";
$sql[] = "drop table student_history";

foreach ($sql as $q) {
  echo "$q<br>\n";
  mysql_query($q, $con) or die(mysqli_error($con));
}

$tables = array('student_subject', 'student_comment', 'student_fees', 
   'student_non_academic');
foreach ($tables as $table) {
  $sql="alter table $table change student_id admission_number
     varchar(100)";
  echo "$sql<br>\n";
  mysqli_query($con, $sql) or die(mysqli_error($con));
}
exit;
?>
