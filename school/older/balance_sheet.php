<?
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

//require_once "hotel.inc";
require_once "ui.inc";
require_once "util.inc";
require_once "acc.inc";


$con = connect();

if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
    print_header('Balance Sheet', 'balance_sheet.php',  
      'Back', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'],
      $_SESSION['entity_id'], $_SESSION['shift'], $con);

  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Process')) {
    if (!check_date($_REQUEST['sdday'], $_REQUEST['sdmonth'], 
          $_REQUEST['sdyear'])) { 
       echo msg_box_hotel('Please enter correct starting date', 
        'balance_sheet.php', 'Back');
       exit;
    } 
    if (!check_date($_REQUEST['edday'], $_REQUEST['edmonth'],
          $_REQUEST['edyear'])) {
       echo msg_box_hotel('Please enter correct ending date',
        'balance_sheet.php', 'Back');
       exit;
    }
	if (empty($_REQUEST['sdday']) || (empty($_REQUEST['edday']))) {
	  echo msg_box_hotel('Please enter both the start and end dates', 
	    'balance_sheet.php', 'Back');
	  exit;
    }
   
    $sddate = make_date($_REQUEST['sdyear'], $_REQUEST['sdmonth'], $_REQUEST['sdday']);
    $eddate = make_date($_REQUEST['edyear'], $_REQUEST['edmonth'], $_REQUEST['edday']);
    ?>
    <table>
      <tr>
       <td colspan="6">
        <table>
         <tr class='class1'>
         <td>
		 <h3>Balance Sheet</h3>
          <form action="balance_sheet.php">
           <input type="submit" name="action" value="Print">
         <input type="hidden" name="sdday" value="<?=$_REQUEST['sdday']?>">
         <input type="hidden" name="sdmonth" value="<?=$_REQUEST['sdmonth']?>">
         <input type="hidden" name="sdyear" value="<?=$_REQUEST['sdyear']?>">
         <input type="hidden" name="edday" value="<?=$_REQUEST['edday']?>">
         <input type="hidden" name="edmonth" value="<?=$_REQUEST['edmonth']?>">          
		 <input type="hidden" name="edyear" value="<?=$_REQUEST['edyear']?>">
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
         <td>Start Date<td><td><b><?=$sddate?></b></td>
         <td>End Date<td><td><b><?=$eddate?></b></td>
        </tr>
       </table>
      </td>
     </tr>
  <?
  #Process Fixed Assets
  $sql = "SELECT * FROM account where 
     entity_id = " . $_SESSION['entity_id'] . " and acc_type_id = 1";
  $t_assets = print_accounts($sql, 'Assets', $_SESSION['entity_id'], 
   $sddate, $eddate, $con);

  echo "<tr><td>&nbsp;</td></tr>";

  #Process Liabilities 
   $sql  = "SELECT * FROM account where 
     entity_id = " . $_SESSION['entity_id'] . " and acc_type_id = 2";
   $t_liabilities = print_accounts($sql, 'Liabilities', $_SESSION['entity_id'],
    $sddate, $eddate, $con);
  echo "<tr><td>&nbsp;</td></tr>";

  #Process Equity 
  $sql = "SELECT * FROM account where 
     entity_id = " . $_SESSION['entity_id'] . " and acc_type_id = 3";
  $t_equities = print_accounts($sql, 'Equity', $_SESSION['entity_id'], 
    $sddate, $eddate, $con);

  echo "</table>";
  main_footer();
  exit;
 }
}
?>
  <table> 
   <tr class='class1'>
    <td colspan="4">
     <h3>Balance Sheet</h3>
     <form action="balance_sheet.php" method="post">
    </td>
   </tr>
   <tr>
    <td>Starting Date</td>
  <? gen_date('sd'); ?>

   </tr>
   <tr>
    <td>Ending Date</td>
   <? gen_date('ed'); ?>
   </tr>
   <tr>
    <td><input name="action" type="submit" value="Process">
        <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <? main_footer(); ?>
