<?php 
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once 'ui.inc';
require_once 'util.inc';
require_once 'report_card.inc';

$con = connect();
$position = array();

$user = array('Administrator','Proprietor', 'Exams');
if (!user_type($_SESSION['uid'], $user, $con)) { 
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['command']) && ($_REQUEST['command'] == 'Print')) {
  print_starter('Report Card', 'report.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . ' ' . $_SESSION['lastname'], $con);
}

//Make sure that Session/Term/Class has been created and 
 //that the session variables representing them have been set
 check_session_variables('report_card.php', $con); 

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {
  if ($_SESSION['class_id'] == '0') {
    echo msg_box("Please choose a class", 'report_card.php', 'Back');
	exit;
  }
  if (isset($_REQUEST['command']) && ($_REQUEST['command'] == 'Print')) {
    $admission_number = $_REQUEST['student_name'];
    $command = $_REQUEST['command'];
  } else {
    if ($_REQUEST['student_name'] == 'All')
      //$student_id = 0;
      $admission_number = 0;
    else {
      //$student_id = decode_student_id($_REQUEST['student_name'], $con);
       $data = explode("_", $_REQUEST['student_name']);
       $admission_number = $data[0];

      if ($admission_number == 0) {
        echo msg_box("Please enter correct student information", 
          'report_card.php', 'Back');
	exit;
      }
    }
    $command = NULL;
  }
    report_card($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], 
      $_SESSION['term_id'], $_SESSION['class_id'], 
      $admission_number, $command, 'report_card.php', $con);  
  
  exit;
}
 
?>
<table> 
 <tr class='class1'>
  <td colspan='3'><h3>Generate Report Card</h3></td>
 </tr>
 <form name='form1' action='report_card.php' method='post'>
 <input type='hidden' name='class_id1' value='<?=$_SESSION['class_id']?>'/>
 <input type='hidden' name='school_id' value='<?php echo $_SESSION['school_id'];?>'>
 <tr>
  <div class='ui-widget'>
   <td>Student</td>
   <td><input id='student_name' name='student_name' size='40'>
     Start typing one of the Student's Name</td>
  </div>
 </tr>
 <tr>
  <td>
   <input name='action' type='submit' value='Submit'>
   <input name='action' type='submit' value='Cancel'>
  </td>
 </tr>
</form>
</table>
<? main_footer(); ?>
  
