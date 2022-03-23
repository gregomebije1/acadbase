<?php
require_once "ui.inc";
require_once "util.inc";

$con = connect();
$sql = "select * from classes";

echo "<select name='class_from' onchange='get_students();'>
  <option value='0'></option>";

$result = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result) > 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
  }
} else {
   echo "<option value='0'></option>";
}
echo "</select>";
?>
