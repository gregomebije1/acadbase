<?php
session_start();
if (!isset($_SESSION['uid'])) {
  header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";

if (isset($_SESSION['uid']) && (isset($_SESSION['session_id'])))
  my_redirect('student.php', '');
else
  my_redirect('../index-4.html', '');

?>
