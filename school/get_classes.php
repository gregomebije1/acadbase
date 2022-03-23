<?php
require_once "util.inc";
$con = connect();

?>
<select name='class_from' onchange='get_students();'>
  <option value='0'></option>

$result = mysqli_query($con, "select * from classes") or die(mysqli_error($con));
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result))
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
} else {
   echo "<option value='0'></option>";
}
?>
</select>
