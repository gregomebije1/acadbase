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

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || user_type($_SESSION['uid'], 'Accounts', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "Print")) {
  print_header('Income Report', 'income_report.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && 
  (($_REQUEST['action'] == 'Generate') || ($_REQUEST['action'] == 'Print'))) {
  $sql="select i.id, i.session_id, i.term_id, i.date_of_receipt, 
   i.teller_number, i.description, t.name, i.amount_due, i.amount_paid, 
   i.source_of_fund from income i join 
   type_of_income t on i.type_of_income_id = t.id where 
   i.session_id = {$_SESSION['session_id']}    
   and i.term_id = {$_REQUEST['term_id']}";
		   
  if (mysql_num_rows(mysql_query($sql)) <= 0) {
    echo msg_box("There is no data for " . 
      get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
      " Session, " . get_value('term','name','id',$_REQUEST['term_id'], $con).
      " Term", 'enter_income.php', 'Back');
    exit;
  }
  echo "
   <table>
    <tr class='class1'>
     <td><h3>Income Report</h3></td>
      <table>
       <tr>
        <td><b>Session:</b> ".
        get_value('session', 'name', 'id', $_SESSION['session_id'],$con). "</td>        <td><b>Term:</b> " . 
	get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
  ";
  if ($_REQUEST['action'] == 'Generate') {
    echo "<td><a style='cursor:hand;'; onclick='window.open(\"income_report.php?action=Print&term_id={$_REQUEST['term_id']}\", \"smallwin\",
                   \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
                 <img src='images/icon_printer.gif'></a></td>
    ";
   }
   echo "
       </tr> 
      </table>
     </td>
    </tr>
    <tr>
     <td>
      <table border='1' style='table-layout:fixed;'>
       <tr class='class1'>
        <th>Date</th>
        <th>Type of Income</th>
        <th>Teller Number</th>
        <th>Amount Due</th>
        <th>Amount Paid</th>
       </tr>
      </table>
     </td>
    </tr> ";
   $total_due = 0;
   $total_paid = 0;
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     $total_due += $row['amount_due'];
     $total_paid += $row['amount_paid'];
     echo "
    <tr>
     <td>
      <table border='1' style='table-layout:fixed; padding: 0.1em 1em;'>
      <tr>
       <td>{$row['date_of_receipt']}</td>
     ";
     if ($_REQUEST['action'] == 'Generate') {
       echo "<td><a href='enter_income.php?action=Details&id={$row['id']}'>{$row['name']}</a></td>";
     } else {
       echo "<td>{$row['name']}</td>";
     }
     echo "
       <td>{$row['teller_number']}</td>
       <td>" . number_format($row['amount_due'], 2) . "</td>
       <td>" . number_format($row['amount_paid'], 2) . "</td>
      </tr>
     </table>
    </td>
   </tr>";
   }
   echo "<tr>
     <td>
      <table border='1' style='table-layout:fixed;'>
       <tr class='class1'>
        <td colspan='3'>Total</td>
        <td>" . number_format($total_due, 2) . "</td>
        <td>" . number_format($total_paid, 2) . "</td>
       </tr>
      </table>
     </td>
    </tr> ";
   echo "</table>";
   exit;
 }
 ?> 
 <table style='table-layout:fixed;'> 
  <tr class="class1">
   <td colspan='3'><h3>Generate Income Report</h3></td>
  </tr>
  <form action="income_report.php" method="post">
  <tr>
   <td>Term</td>
   <td>
    <select name='term_id'>
     <?php
     $sql ="select * from term where session_id={$_SESSION['session_id']}";
     $result = mysql_query($sql);
     while ($row = mysql_fetch_array($result)) { 
       echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
    </select>
   </td>
  </tr>
  <tr>
   <td>
    <input name='action' type='submit' value='Generate'>
    <input name="action" type="submit" value="Cancel">
   </td>
  </tr>
  </form>
 </table>
<? main_footer(); ?>
	  
