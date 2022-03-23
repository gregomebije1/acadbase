<?php
require_once "ui.inc";
require_once "util.inc";

$con = connect();
echo "<select name='term_id'><option value='0'></option>";

$sql = "select * from term where session_id={$_REQUEST['session_id']}";
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
