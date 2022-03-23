<?php
session_start(); 
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();

save_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'],$con);
close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

session_unset();  //Unset all of the session variables
session_destroy(); //Destroy the session
my_redirect('index.php', '');
exit;
?>