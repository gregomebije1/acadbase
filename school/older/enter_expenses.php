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

if (!(user_type($_SESSION['uid'], 'Administrator', $con)
  || user_type($_SESSION['uid'], 'Accounts', $con)
  || user_type($_SESSION['uid'], 'Expenditure', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Post')) {
   if (empty($_REQUEST['amount'])) {
     echo msg_box('Please enter the amount of the expenses', 
      'enter_expenses.php', 'Back');
     exit;
   } 
   if(!is_numeric($_REQUEST['amount'])) {
     echo msg_box('Please enter correct amount of the expenses', 
      'enter_expenses.php', 'Back');
     exit;
   } 
   if (empty($_REQUEST['date_of_payment']) || empty($_REQUEST['voucher_number'])
     || empty($_REQUEST['description'])) {
     echo msg_box("Please fill all missing fields", 'enter_expenses.php', 
      'Back');
     exit;
   }
   $sql = "insert into expenses(session_id, term_id,
     date_of_payment, description, type_of_expenses_id, amount, voucher_number) 
     values({$_SESSION['session_id']}, 
     {$_REQUEST['term_id']}, '{$_REQUEST['date_of_payment']}', 
     '{$_REQUEST['description']}', {$_REQUEST['type_of_expenses_id']},  
    '{$_REQUEST['amount']}', '{$_REQUEST['voucher_number']}')";
   $result = mysql_query($sql) or die(mysql_error());
   echo msg_box('Successfully Posted', "enter_expenses.php", 'Continue');
   exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an expense to delete", 'enter_expenses.php', 'Back');
	exit;
  } 
  $sql="select * from expenses where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("The expenses does not exist in the database", 
     'enter_expenses.php', 'Back');
    exit;
  }
  echo msg_box("Are you sure you want to delete this expense", 
   "enter_expenses.php?action=confirm_delete&id={$_REQUEST['id']}", 'Back');
  exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an expense to delete", 'enter_expense.php', 'Back');
	exit;
  } 
  $sql="select * from expenses where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("The expenses does not exist in the database", 
      'enter_expenses.php', 'Back');
    exit;
  }
  $sql="delete from expenses where id={$_REQUEST['id']}";
  mysql_query($sql) or die(mysql_error());
  
  echo msg_box("Successfully deleted", 'enter_expenses.php', 'Back');
  exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an expense to delete", 'enter_expenses.php', 'Back');
	exit;
  } 
  $sql="select * from expenses where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("This expenses does not exist in the database", 
      'enter_report.php', 'Back');
    exit;
  }
  if (empty($_REQUEST['amount'])) {
    echo msg_box('Please enter the amount of the expenses', 
      'enter_expenses.php', 'Back');
     exit;
  }
  if(!is_numeric($_REQUEST['amount'])) {
     echo msg_box('Please enter correct amount of the expenses', 
       'enter_expenses.php', 'Back');
     exit;
  }
  if (empty($_REQUEST['date_of_payment']) || empty($_REQUEST['voucher_number'])
     || empty($_REQUEST['description'])) {
     echo msg_box("Please fill all missing fields", 'enter_expenses.php', 
      'Back');
     exit;
  }
  $sql="update expenses set date_of_payment='{$_REQUEST['date_of_payment']}',
   description='{$_REQUEST['description']}', 
   type_of_expenses_id={$_REQUEST['type_of_expenses_id']}, 
   amount='{$_REQUEST['amount']}', term_id={$_REQUEST['term_id']}, 
   voucher_number='{$_REQUEST['voucher_number']}' where id={$_REQUEST['id']}";
  mysql_query($sql) or die(mysql_error());
  echo msg_box("Successfully Updated", 'enter_expenses.php', 'Back');
  exit;
} else if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Details')) {
  if (isset($_REQUEST['action']) &&($_REQUEST['action'] == 'Details')) {
    $sql="select * from expenses where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	if (mysql_num_rows($result) > 0) {
	  $row_exp = mysql_fetch_array($result);
	  $id = $_REQUEST['id'];
	  $date_of_payment = $row_exp['date_of_payment'];
	  $description = $row_exp['description'];
	  $amount = $row_exp['amount'];
	  $type_of_expenses_id = $row_exp['type_of_expenses_id'];
	  $term_id = $row_exp['term_id'];
	  $session_id = $row_exp['session_id'];
	  $voucher_number = $row_exp['voucher_number'];
	} else {
	  echo msg_box("This expense does not exist in the database", 
	   'enter_expenses.php', 'Back');
	  exit;
	}
  } else {
      $id = "";
	  $date_of_payment = date('Y-m-d');
	  $description = "";
	  $amount = "";
	  $type_of_expenses_id = "";
	  $term_id = "";
	  $session_id = "";
          $voucher_number = "";
	}
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4">
     <h3>Enter Expenses</h3>
    </td>
   </tr>
   <form name='form1' action="enter_expenses.php" method="post">
   <tr>
    <td>Session</td>
    <td>
    <?php 
     echo get_value('session', 'name', 'id', $_SESSION['session_id'], $con);
     echo "</td></tr><tr><td>Term</td><td>";
     echo "<select name='term_id'>";
     $result = mysql_query("select * from term") or die(mysql_error());
     while ($row = mysql_fetch_array($result)) {
	   if($term_id == $row['id']) 
	     echo "<option value='{$row['id']}' selected='selected'>{$row['name']}</option>";
	   else 
	     echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     echo "</select>";
    ?>
   </td>
   <tr>
    <td>Date</td>
    <td>
     <input type="text" name="date_of_payment" value='<?php echo $date_of_payment ?>'
      maxlength='10' size='10'>
    </td>
   </tr>
   <tr>
    <td>Type of Expenses</td>
    <td><select name='type_of_expenses_id'>
     <?php
     $result = mysql_query("select * from type_of_expenses") or die(mysql_error());
     while ($row = mysql_fetch_array($result)) {
	   if($type_of_expenses_id == $row['id']) 
	     echo "<option value='{$row['id']}' selected='selected'>{$row['name']}</option>";
	   else 
	     echo "<option value='{$row['id']}'>{$row['name']}</option>";
     }
     ?>
     </select>
    </td>
   </tr>
   <?php echo tr(array('Voucher Number', textfield('name', 'voucher_number', 
     'value', $voucher_number))); ?>
   <tr>
    <td>Description</td>
	<td><textarea name='description' rows='5' cols='30'><?php echo $description; ?></textarea></td>
   </tr>
   <tr>
    <td>Amount</td>
    <td><input type="text" name='amount' value='<?php echo $amount; ?>'></td>
   </tr>
   <tr>
    <td>
   <?php
   if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Details')) {
     echo "<input name='action' type='submit' value='Update'>
	   <input name='action' type='submit' value='Delete'>
	   <input type='hidden' name='id' value='$id'>";
   } else if (!isset($_REQUEST['action'])) {
     echo "<input name='action' type='submit' value='Post'>";
   }
   ?>
     <!--<input name="action" type="submit" value="Cancel"> -->
    </td>
   </tr>
  </table>
  <? 
  }
  main_footer(); ?>
