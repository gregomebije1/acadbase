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
  || user_type($_SESSION['uid'], 'Accounts', $con)
  || user_type($_SESSION['uid'], 'Expenditure', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "Print")) {
  print_header('Expense Report', 'expense_report.php', 'Back to Main Menu', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}
if (isset($_REQUEST['action']) && 
  (($_REQUEST['action'] == 'Generate') || ($_REQUEST['action'] == 'Print'))) {
  $sql="select e.id, e.session_id, e.term_id, e.date_of_payment, 
   e.voucher_number, e.description, t.name, e.amount from expenses e join 
   type_of_expenses t on e.type_of_expenses_id = t.id where 
   e.session_id = {$_SESSION['session_id']}    
   and e.term_id = {$_REQUEST['term_id']}";
		   
  if (mysql_num_rows(mysql_query($sql)) <= 0) {
    echo msg_box("There is no data for " . 
      get_value('session', 'name', 'id', $_SESSION['session_id'],$con).  
      " Session, " . get_value('term','name','id',$_REQUEST['term_id'], $con).
      " Term", 'enter_expenses.php', 'Back');
    exit;
  }
  echo "
   <table>
    <tr class='class1'>
     <td><h3>Expenses Report</h3></td>
      <table>
       <tr>
        <td><b>Session:</b> ".
        get_value('session', 'name', 'id', $_SESSION['session_id'],$con). "</td>        <td><b>Term:</b> " . 
	get_value('term', 'name', 'id', $_REQUEST['term_id'], $con) . "</td>
  ";
  if ($_REQUEST['action'] == 'Generate') {
    echo "<td><a style='cursor:hand;'; onclick='window.open(\"expense_report.php?action=Print&term_id={$_REQUEST['term_id']}\", \"smallwin\",
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
        <th>Date Of Payment</th>
        <th>Type of Expense</th>
        <th>Voucher Number</th>
        <th>Amount</th>
       </tr>
      </table>
     </td>
    </tr> ";
   $total = 0;
   $result = mysql_query($sql) or die(mysql_error());
   while ($row = mysql_fetch_array($result)) {
     $total += $row['amount'];
     echo "
    <tr>
     <td>
      <table border='1' style='table-layout:fixed; padding: 0.1em 1em;'>
      <tr>
       <td>{$row['date_of_payment']}</td>
     ";
     if ($_REQUEST['action'] == 'Generate') {
       echo "<td><a href='enter_expenses.php?action=Details&id={$row['id']}'>{$row['name']}</a></td>";
     } else {
       echo "<td>{$row['name']}</td>";
     }
     echo "
       <td>{$row['voucher_number']}</td>
       <td>" . number_format($row['amount'], 2) . "</td>
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
        <td>" . number_format($total, 2) . "</td>
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
   <td colspan='3'><h3>Generate Expense Report</h3></td>
  </tr>
  <form action="expense_report.php" method="post">
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
	  
