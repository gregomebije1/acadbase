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
  || user_type($_SESSION['uid'], 'Accounts', $con))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
  $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Post')) {
   if (empty($_REQUEST['amount_due'])) {
     echo msg_box('Please enter the amount of the income due',
     'enter_income.php', 'Back');
     exit;
   } 
   if(!is_numeric($_REQUEST['amount_due'])) {
     echo msg_box('Please enter correct amount of the income', 
      'enter_income.php', 'Back');
     exit;
   } 
   if (empty($_REQUEST['amount_paid'])) {
     echo msg_box('Please enter the amount of the income paid',
     'enter_income.php', 'Back');
     exit;
   }
   if(!is_numeric($_REQUEST['amount_paid'])) {
     echo msg_box('Please enter correct amount of the income', 
      'enter_income.php', 'Back');
     exit;
   }
   if (empty($_REQUEST['date_of_receipt']) || empty($_REQUEST['teller_number'])
     || empty($_REQUEST['description']) || empty($_REQUEST['source_of_fund'])) {
     echo msg_box("Please fill all missing fields", 'enter_expenses.php', 
      'Back');
     exit;
   }
   $sql = "insert into income(session_id, term_id,
     date_of_receipt, description, type_of_income_id, teller_number, 
     amount_due, amount_paid, source_of_fund) 
     values({$_SESSION['session_id']}, 
     {$_REQUEST['term_id']}, '{$_REQUEST['date_of_receipt']}', 
     '{$_REQUEST['description']}', {$_REQUEST['type_of_income_id']},  
    '{$_REQUEST['teller_number']}', 
    '{$_REQUEST['amount_due']}', '{$_REQUEST['amount_paid']}', 
    '{$_REQUEST['source_of_fund']}')";
   $result = mysql_query($sql) or die(mysql_error());
   echo msg_box('Successfully Posted', "enter_income.php", 'Continue');
   exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an income to delete", 'enter_income.php', 'Back');
	exit;
  } 
  $sql="select * from income where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("The income does not exist in the database", 
     'enter_income.php', 'Back');
    exit;
  }
  echo msg_box("Are you sure you want to delete this income", 
   "enter_income.php?action=confirm_delete&id={$_REQUEST['id']}", 'Back');
  exit;
}else if (isset($_REQUEST['action'])&&($_REQUEST['action']=='confirm_delete')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an income to delete", 'enter_income.php', 'Back');
	exit;
  } 
  $sql="select * from income where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("The income does not exist in the database", 
      'enter_income.php', 'Back');
    exit;
  }
  $sql="delete from income where id={$_REQUEST['id']}";
  mysql_query($sql) or die(mysql_error());
  
  echo msg_box("Successfully deleted", 'enter_income.php', 'Back');
  exit;
} else if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Update')) {
  if (empty($_REQUEST['id'])) {
    msg_box("Please choose an income to delete", 'enter_income.php', 'Back');
	exit;
  } 
  $sql="select * from income where id={$_REQUEST['id']}";
  if (mysql_num_rows(mysql_query($sql)) == 0) {
    echo msg_box("This income does not exist in the database", 
     'enter_income.php', 'Back');
    exit;
  }
  if (empty($_REQUEST['amount_due'])) {
     echo msg_box('Please enter the amount of the income due',
     'enter_income.php', 'Back');
     exit;
  } 
  if(!is_numeric($_REQUEST['amount_due'])) {
     echo msg_box('Please enter correct amount of the income', 
      'enter_income.php', 'Back');
     exit;
  } 
  if (empty($_REQUEST['amount_paid'])) {
     echo msg_box('Please enter the amount of the income paid',
     'enter_income.php', 'Back');
     exit;
  }
  if(!is_numeric($_REQUEST['amount_paid'])) {
     echo msg_box('Please enter correct amount of the income', 
      'enter_income.php', 'Back');
     exit;
   }
   if (empty($_REQUEST['date_of_receipt']) || empty($_REQUEST['teller_number'])
     || empty($_REQUEST['description']) || empty($_REQUEST['source_of_fund'])) {
     echo msg_box('Please fill all the missing fields', 'enter_income.php', 
      'Back');
     exit;
   }
  $sql="update income set date_of_receipt='{$_REQUEST['date_of_receipt']}',
   description='{$_REQUEST['description']}', 
   type_of_income_id={$_REQUEST['type_of_income_id']},
   term_id={$_REQUEST['term_id']}, 
   teller_number='{$_REQUEST['teller_number']}', 
   amount_due='{$_REQUEST['amount_due']}',
   amount_paid='{$_REQUEST['amount_paid']}', 
   source_of_fund='{$_REQUEST['source_of_fund']}' 
   where id={$_REQUEST['id']}";
  mysql_query($sql) or die(mysql_error());
  echo msg_box("Successfully Updated", 'enter_income.php', 'Back');
  exit;
} else if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Details')) {
  if (isset($_REQUEST['action']) &&($_REQUEST['action'] == 'Details')) {
    $sql="select * from income where id={$_REQUEST['id']}";
    $result = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
      $row_inc = mysql_fetch_array($result);
      $id = $_REQUEST['id'];
      $date_of_receipt = $row_inc['date_of_receipt'];
      $description = $row_inc['description'];
      $amount_due = $row_inc['amount_due'];
      $amount_paid = $row_inc['amount_paid'];
      $source_of_fund = $row_inc['source_of_fund'];
      $type_of_income_id = $row_inc['type_of_income_id'];
      $term_id = $row_inc['term_id'];
      $session_id = $row_inc['session_id'];
      $teller_number = $row_inc['teller_number'];
    } else {
      echo msg_box("This income does not exist in the database", 
       'enter_income.php', 'Back');
      exit;
    }
  } else {
    $id = "";
    $date_of_receipt = date('Y-m-d');
    $description = "";
    $amount_due = "";
    $amount_paid = "";
    $source_of_fund = "";
    $type_of_income_id = "";
    $term_id = "";
    $session_id = "";
    $teller_number = "";
  }
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4">
     <h3>Enter Income</h3>
    </td>
   </tr>
   <form name='form1' action="enter_income.php" method="post">
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
     <input type="text" name="date_of_receipt" value='<?php echo $date_of_receipt ?>'
      maxlength='10' size='10'>
    </td>
   </tr>
   <tr>
    <td>Type of Income</td>
    <td><select name='type_of_income_id'>
     <?php
     $result = mysql_query("select * from type_of_income") or die(mysql_error());
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
   <?php echo tr(array('Teller Number', textfield('name', 'teller_number', 
     'value', $teller_number))); ?>
   <tr>
    <td>Description</td>
	<td><textarea name='description' rows='5' cols='30'><?php echo $description; ?></textarea></td>
   </tr>
   <tr>
    <td>Amount Due</td>
    <td><input type="text" name='amount_due' value='<?php echo $amount_due; ?>'></td>
   </tr>
   <tr>
    <td>Amount Paid</td>
    <td><input type="text" name='amount_paid' value='<?php echo $amount_paid; ?>'></td>
   </tr>
   <tr>
    <td>Source Of Fund</td>
    <td><textarea name='source_of_fund' rows='5' cols='30'><?php echo $source_of_fund; ?></textarea></td>
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
