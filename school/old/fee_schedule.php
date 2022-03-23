<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";

$con = connect();

$user = array('Administrator','Accounts', 'Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
} 

if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
  print_header('Fee Schedule', 'fee_schedule.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

//Make sure that Session/Term/Class has been created and 
//that the session variables representing them have been set
check_session_variables('fee_schedule.php', $con); 

if (isset($_REQUEST['action']) &&
  ($_REQUEST['action'] == 'Update Fee Schedule')) {
  
  $sql="select * from fee_class where school_id={$_SESSION['school_id']}
      and session_id={$_SESSION['session_id']} 
	  and term_id={$_SESSION['term_id']} 
	  and class_id = {$_SESSION['class_id']}
	  ";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while ($row = mysqli_fetch_array($result)) { 
    $amount = "amount_" . $row['id'];
    $sql="update fee_class set amount='{$_REQUEST[$amount]}'
      where id={$row['id']} and school_id={$_SESSION['school_id']}
	  and session_id={$_SESSION['session_id']} 
	  and term_id={$_SESSION['term_id']} 
	  and class_id={$_SESSION['class_id']}";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }

} else if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Edit')) {

  ?>
  <table border='1'> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Fee</h3></td>
   </tr>
   <form action="fee_schedule.php" method="post">
   <tr>
    <td>Class</td>
   <?php
    echo "
      <td> " . get_value("class", "name", "id", $_SESSION['class_id'], $con);
      
    $sql = "select f.name, fc.amount, fc.id from fee_class fc join fee f
      on f.id = fc.fee_id where fc.school_id={$_SESSION['school_id']} 
	  and fc.session_id={$_SESSION['session_id']} 
	  and fc.term_id={$_SESSION['term_id']} 
	  and fc.class_id={$_SESSION['class_id']} 
      order by f.id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($result)) {
       echo "<tr>
        <td>{$row['name']}</td>
        <td>
         <input type='text' name='amount_{$row['id']}' value='{$row['amount']}'>
        </td>
       </tr>
       ";
     }
    ?>
   <tr>
    <td>
     <input name="action" type="submit" value="Update Fee Schedule">
     <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <?
  exit;
  } 
  ?>
<div class='class1'>
<?php 
if (!((isset($_REQUEST['action'])) && ($_REQUEST['action'] == 'Print'))) {
  echo "<a href='fee_schedule.php?action=Print'>Print</a>";  
  echo "<a href='fee_schedule.php?action=Edit'>Edit</a>";  
}
?>
<h3 class='sstyle1' style='display:inline;'>Fee Schedule</h3></div>
 <table class='tablesorter'>
  <thead>
   <tr>
    <?
    $sql = "select * from fee where school_id={$_SESSION['school_id']} 
     order by id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($result)) {
      echo "<th>{$row['name']}</th>";
    }
    echo "</tr></thead><tbody>";

   $sql="select * from class where id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']} 
     order by id";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $row = mysqli_fetch_array($result);
     echo "<tr>";

     $sql="select f.id, c.name, fc.amount from 
       fee_class fc join (fee f, class c) on 
       (fc.fee_id = f.id and fc.class_id = c.id)
	   where fc.session_id={$_SESSION['session_id']} and fc.term_id={$_SESSION['term_id']} and fc.class_id = {$row['id']} order by f.id";
   
     $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
     while ($row2 = mysqli_fetch_array($result2)) {
       echo "<td>{$row2['amount']}</td>";
     }
     echo "</tr>";	 
   
   echo '</table>';
  include "tablesorter_footer.inc"; 
?>
