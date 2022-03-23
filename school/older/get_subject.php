<?
require_once "ui.inc";
require_once "util.inc";

$con = connect();
if (user_type($_REQUEST['uid'], Administrator, $con)) {
  $sql="select s.id, s.name from subject s join class c 
   on s.type = c.type where c.id = {$_REQUEST['class_id']}";
} else {
  $sql = "select s.id, s.name, up.subject_id from user_permissions up
   join subject s on up.subject_id = s.id 
   where uid={$_REQUEST['uid']} and class_id={$_REQUEST['class_id']}";
}
echo "<select name='subject_id'>";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
  }
} else {
   echo "<option value='0'></option>";
}
echo "</select>";
?>
