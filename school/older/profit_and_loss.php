<?
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";

$con = connect();

if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
    print_header('Profit and Loss', 'profit_and_loss.php',  
      'Back', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Process')) {
    if (empty($_REQUEST['sdate']) || (empty($_REQUEST['edate']))) {
	  echo msg_box_hotel('Please enter both the start and end dates', 
	    'profit_and_loss.php', 'Back');
	  exit;
    }
    $sdate = $_REQUEST['sdate'];
	$edate = $_REQUEST['edate'];
    ?>
    <table border='1'>
      <tr>
       <td colspan="6">
        <table>
         <tr class='class1'>
         <td>
		 <h3>Profit and Loss</h3>
          <form action="profit_and_loss.php">
         <!--<input type="submit" name="action" value="Print">-->
         <input type="hidden" name="sdate" value="<?=$_REQUEST['sdate']?>">
         <input type="hidden" name="edate" value="<?=$_REQUEST['edate']?>">
        </form>
         </td>
         </tr>
        </table>
       </td>
      </tr>
     <tr>
      <td colspan='6'>
       <table>
        <tr>
         <td>Start Date<td><td><b><?=$sdate?></b></td>
         <td>End Date<td><td><b><?=$edate?></b></td>
        </tr>
       </table>
      </td>
     </tr>
  <?
  #Process School Fees
  $sql = "SELECT sf.date_of_payment, sf.amount, 
   s.firstname, s.lastname 
   FROM student_fee sf join student s 
   on s.id = sf.student_id 
   where sf.session_id={$_SESSION['session_id']}
   and sf.term_id={$_REQUEST['term_id']} and sf.date_of_payment between 
    '$sdate' and '$edate'";
  //echo "$sql<br>";
  $school_fees = 0;
  $result = mysql_query($sql) or die(mysql_error());
   if (mysql_num_rows($result) > 0) {
     echo("<tr><td><i><b>School Fees</b></i></td></tr>");
     while($rows = mysql_fetch_array($result)) {
       echo("<tr><td>{$rows['firstname']} {$rows['lastname']}</td>");
       $school_fees += $rows['amount'];
       echo("<td>" . number_format($rows['amount'], 2) . "</td></tr>");
    }
   }
  echo "<tr><td><b><i>Total School Fees</i></b></td><td>&nbsp;</td><td><b>" . number_format($school_fees, 2) . "</b></td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";

  #Process Other Income 
   $sql  = "SELECT i.id, i.session_id, i.term_id, i.date_of_receipt, 
    i.description, t.name, i.amount_paid
    FROM income i join type_of_income t 
    on t.id = i.type_of_income_id 
    where i.session_id={$_SESSION['session_id']}
    and i.term_id={$_REQUEST['term_id']} and i.date_of_receipt between 
    '$sdate' and '$edate'";
   //echo "$sql<br>";
   $other_income = 0;
   $result = mysql_query($sql, $con) or die(mysql_error());
   if (mysql_num_rows($result) > 0) {
     echo("<tr><td><i><b>Other Income</b></i></td></tr>");
     while($rows = mysql_fetch_array($result)) {
       echo("<tr><td>" . $rows['name'] ."</td>");
       $other_income += $rows['amount_paid'];
       echo("<td>" . number_format($rows['amount_paid'],2) . "</td></tr>");
    }
   }
  echo "<tr><td><b><i>Total Other Income</i></b></td><td>&nbsp;</td><td><b>" . number_format($other_income, 2) . "</b></td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";

  //Total Income
  $total_income = $school_fees + $other_income;
  echo "<tr><td><b><i>Total Income</i></b><td>&nbsp;</td></td><td><b>" 
   . number_format($total_income, 2) . "</b></td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";

  #Process Expenses
   $sql  = "SELECT e.id, e.session_id, e.term_id, e.date_of_payment, 
    e.description, t.name, e.amount 
	FROM expenses e join type_of_expenses t 
	on t.id = e.type_of_expenses_id 
	where e.session_id={$_SESSION['session_id']}
    and e.term_id={$_REQUEST['term_id']} and e.date_of_payment between 
	 '$sdate' and '$edate'";
   //echo "$sql<br>";
   $expenses = 0;
   $result = mysql_query($sql, $con) or die(mysql_error());
   if (mysql_num_rows($result) > 0) {
     echo("<tr><td><i><b>Expenses</b></i></td></tr>");
     while($rows = mysql_fetch_array($result)) {
       echo("<tr><td>" . $rows['name'] ."</td>");
       $expenses += $rows['amount'];
       echo("<td>" . number_format($rows['amount'],2) . "</td></tr>");
    }
   }
  echo "<tr><td><b><i>Total Expenses</i></b></td><td>&nbsp;</td><td><b>" . number_format($expenses, 2) . "</b></td></tr>";
  echo "<tr><td>&nbsp;</td></tr>";

  $profit_or_loss = $total_income - $expenses;
  echo "
    <tr>
     <td><h3>
	 ";
  if ($total_income > $expenses) {
    echo "Profit";
  } else if ($total_income < $expenses) {
    echo "Loss";
  }
  echo "
	</h3></td> 
     <td>&nbsp;</td>
     <td><h3>" . number_format($profit_or_loss, 2) . "</h3></td>
    </tr>
  ";
  echo "<tr><td>&nbsp;</td></tr>
	</table>";
  
  main_footer();
  exit;
 }
}
?>
  <table> 
   <tr class='class1'>
    <td colspan="4">
     <h3>Profit and Loss</h3>
     <form action="profit_and_loss.php" method="post">
    </td>
   </tr>
   <tr>
    <td>Session</td>
   <?php
    echo "<td>" . get_value('session', 'name', 'id', $_SESSION['session_id'], $con);
	echo "</td></tr>
	 <tr>
	  <td>Term</td>
	  <td>
	";
	get_table_data('term', $con);
   ?>	
   <tr>
    <td>Starting Date</td>
    <td><input type='text' name='sdate' 
	 maxlength='10' size='10' value='<?php echo date('Y-m-d'); ?>'></td>

   </tr>
   <tr>
    <td>Ending Date</td>
    <td><input type='text' name='edate' 
	maxlength='10' size='10' value='<?php echo date('Y-m-d'); ?>'></td>
   </tr>
   
   <tr>
    <td><input name="action" type="submit" value="Process">
        <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <? main_footer(); ?>
