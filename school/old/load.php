<?php
session_start(); 
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();
 
$file_name = "data/{$_SESSION['school_id']}/{$_SESSION['school_id']}.sql";
load_data($file_name); //Load School details
    
$file_name = "{$_SESSION['session_id']}_{$_SESSION['term_id']}_{$_SESSION['class_id']}.sql";
$file_name = "data/{$_SESSION['school_id']}/{$file_name}";
load_data($file_name); //Load Session Term Class details
  
my_redirect('index.php', '');
exit;
?>