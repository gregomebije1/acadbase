<?php
require_once "ui.inc";
require_once "util.inc";

$con = connect();
$sql = "select * from student where current_class_id={$_REQUEST['class_id']}";

echo "<select";
if (isset($_REQUEST['size'])) 
  echo " size='{$_REQUEST['size']}' ";
echo " name='student_id' onchange='get_student_fees();'>";
if (isset($_REQUEST['all'])) {
  echo "	<option value='0'>All Students</option>";
} else if (isset($_REQUEST['size'])) {
  echo "";
} else {
  echo "	<option value='0'></option>";
}
$result = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result) > 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<option value='{$row['id']}'>
    {$row['admission_number']} {$row['firstname']} {$row['lastname']}</option>";
  }
} else {
   echo "<option value='0'></option>";
}
echo "</select>";
?>
