<?php
if ($_SESSION['age'] == '0') {
  echo msg_box(SUBSCRIPTION_MESSAGE, ".", "");
  exit;
}
?>
