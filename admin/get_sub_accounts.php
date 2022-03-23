<?php
require_once "util.inc";

$con = connect();
echo "<select name='sub_account'><option value='0'></option>";

$sql = "select * from account where sub={$_REQUEST['account_id']}";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_array($result)) {
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
  }
} else {
   echo "<option value='0'>No Sub Account</option>";
}
echo "</select>";
?>
