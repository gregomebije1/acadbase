<?php 
session_start();
error_reporting(E_ALL);

require_once 'ui.inc';
require_once 'util.inc';
require_once 'school.inc';
require_once 'report_card.inc';

$con = connect();
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {
 check($_REQUEST['session_id'], 'Please enter correct values', '');
/*
function report_card($school_id, $session_id, $term_id, $class_id, 
  $admission_number, $command, $url, $con) {
*/

  if ($_REQUEST['from'] == 'check_result2.php') {
   echo "<a href='../check_result2.php?action=Submit&code={$_REQUEST['code']}'>Back</a>";
   $previous_sessid = 0;
  } else {
   echo "<a href='academic_history.php'>Back</a>";
   $previous_sessid = $_SESSION['sessid'];
  }
  
  $_SESSION['sessid'] = mt_rand();
  $file_name = "data/{$_REQUEST['school_id']}/{$_REQUEST['session_id']}_{$_REQUEST['class_id']}.sql";
  open_session($_SESSION['sessid'], $file_name, $con);
  
  report_card($_SESSION['sessid'], $_REQUEST['school_id'], $_REQUEST['session_id'], $_REQUEST['term_id'], 
   $_REQUEST['class_id'], $_REQUEST['admission_number'], 'Print', 'report_card.php', $con);
  
  close_acadbase_session($_SESSION['sessid'], $_REQUEST['school_id'], $_REQUEST['session_id'], $_REQUEST['class_id'], $con);
  
  $_SESSION['sessid'] = "$previous_sessid";
  
  exit;
}
?> 
