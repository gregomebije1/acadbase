<?php
session_start(); 
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'backup_restore.inc';

$con = connect();

//Should check if someone is currently logged in
//If not save/delete/logout 
//else save/logout

//Backup School information
$tables = array('account', 'fee', 'fee_class', 'grade_settings', 'journal', 'non_academic', 'subject');
foreach($tables as $table_name) 
  $st[$table_name] = "select * from $table_name where school_id={$_SESSION['school_id']}";
  
store_data($st, "data/{$_SESSION['school_id']}/{$_SESSION['school_id']}.sql");
unset($st);


//Backup up Session/Term/Class information
$sql = "school_id={$_SESSION['school_id']} and session_id={$_SESSION['session_id']} and term_id={$_SESSION['term_id']} and class_id={$_SESSION['class_id']}";  

$tables = array('student', 'student_comment', 'student_fees', 'student_non_academic','student_subject');
foreach($tables as $table_name) {
  if ($table_name == 'student')
    $stc[$table_name] = "select * from $table_name where class_id={$_SESSION['class_id']}";
  else
    $stc[$table_name] = "select * from $table_name where $sql";
}

$stc_file = "{$_SESSION['session_id']}_{$_SESSION['term_id']}_{$_SESSION['class_id']}.sql";
$stc_file = "data/{$_SESSION['school_id']}/{$stc_file}";  
store_data($stc, $stc_file);
unset($stc);

my_redirect('index.php', '');
exit;
?>
