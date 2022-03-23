<?
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";
require_once "acc.inc";

$con = connect();
if(isset($_REQUEST['action']) && ($_REQUEST['action'] =="Print")) {
    print_header('Petty Cash Book', 'petty_cashbook.php',  
      'Back', $con);
} else {
  main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con, 'Home');
}
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {
    if (empty($_REQUEST['sdate']) || (empty($_REQUEST['edate']))) { 
      echo msg_box('Please enter correct both the start and end dates', 
       'petty_cashbook.php', 'Back');
      exit;
    }
    $sdate = $_REQUEST['sdate'];
    $edate = $_REQUEST['edate'];
    ?>
    <table width='100%' >
     <tr class='class1'><td colspan='6'><h3>PETTY CASH BOOK</h3></td></tr>
     <tr>
      <td>
       <table width="100%">
        <tr>
         <td><b>Start Date</b></td><td><?=$sdate?></td>
         <td><b>End Date</b></td><td><?=$edate?></td>
        </tr>
       </table>
      </td>
     </tr>
     <tr>
      <td colspan='4'>
       <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
         <th style='text-align:center;'>Receipts</th>
         <th style='text-align:center;'>Date</th>
         <th style='text-align:center;'>Details</th>
         <th style='text-align:center;'>Total</th>
    
     <?php
      $columns = array();
      $count = 1;
      $totals = array();
      $total = 0;
	  $balance_cd = 0;
       
      $sql="select * from account where acc_type_id=" . EXPENSES. " order by id";     
      $result = mysqli_query($con, $sql) or die(mysqli_error($con));
      while($row = mysqli_fetch_array($result)) {
       echo "<th style='text-align:center;'>{$row['name']}</th>";
       $columns[$count++] = $row['id']; 
       $totals[$row['id']] = 0;
      }
	  
      echo "</tr>";

      $acc_id = get_acc_id("Petty Cash", $con);
      $sql="select * from journal where acc_id=$acc_id
       and d_entry between '{$_REQUEST['sdate']}'
       and '{$_REQUEST['edate']}' order by d_entry";

	   $totals[$acc_id] = 0;
	   
      $result = mysqli_query($con, $sql) or die(mysqli_error($con));
	  if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) { 
		  if($row['t_type'] == 'Debit' && ($total > 0)) {
		  
		    //Total of all the expenses
		    echo "<tr class='style9'>
	         <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
             <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
             <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
             <td style='text-align:center; 
			                              border-top:1px solid black;
			 font-weight:bold;'>" . number_format($total, 2) . "</td>";
	  
	        //Total of each of the expense
		    foreach($totals as $id => $amt) {
              if ($id == $acc_id)
               continue;
              echo "<td style='text-align:center; border-bottom:1px solid black; 
			   border-top:1px solid black;
			   font-weight:bold;'>" . number_format($amt, 2) . "</td>";
            }
			echo "</tr>";
			
			
			//Display Cash Entry
			echo
             "<tr class='style9'>
              <td style='border: 1px solid #ebf3ff;'>" . number_format($row['amt'], 2) . "</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['d_entry']}</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['descr']}</td>";
              $totals[$row['acc_id']] += $row['amt'];

           for($i = 1; $i <= count($columns); $i++)
            echo "<td style='border: 1px solid #ebf3ff;'>&nbsp;</td>";
           echo "</tr>";
		   
		   $totalx = 0;
		   if ($balance_cd == 0) {
		     $balance_cd = $totals[get_acc_id('Petty Cash', $con)] - $total;
			 $totalx = $totals[get_acc_id('Petty Cash', $con)];
			 $totaly = $balance_cd + $total;
		   } else {
		     $totalx = $balance_cd + $row['amt'];
			 $totaly = $balance_cd + $total;
		   }
		   
		   
           echo "
	        <tr class='style9'>
	         <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'>Balance C/D</td>
		     <td style='border: 1px solid #ebf3ff;'>" . number_format($balance_cd, 2) . "</td>
	        </tr>
			
	        <tr class='style9'>
	         <td style='border: 1px solid #ebf3ff; font-weight:bold; border-bottom:1px solid black; 
			  border-top:1px solid black;
			  '>" . number_format($totalx, 2) . "</td>
		     <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff; font-weight:bold;
			 border-bottom:1px solid black; 
			border-top:1px solid black;'>" . number_format($totaly, 2) . "</td>
	       </tr>
	       <tr class='style9'>
		   <td style='border: 1px solid #ebf3ff;'>" . number_format($balance_cd, 2) . "</td>
		    <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		    <td style='border: 1px solid #ebf3ff;'>Balance B/F</td>
			<td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
	       </tr>
	       ";
		   
		   foreach($totals as $id => $amt) {
		      if ($id == $acc_id)
               continue;
		     $totals[$id] = 0;
		   }
		   $total = 0;
		   continue;
		  }
		  
          if ($row['t_type'] == 'Debit') {
            echo
             "<tr class='style9'>
              <td style='border: 1px solid #ebf3ff;'>" . number_format($row['amt'], 2) . "</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['d_entry']}</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['descr']}</td>";
              $totals[$row['acc_id']] += $row['amt'];

           for($i = 1; $i <= count($columns); $i++)
            echo "<td style='border: 1px solid #ebf3ff;'>&nbsp;</td>";
           echo "</tr>";
		   
		  }
		  
		  if ($row['t_type'] == 'Credit') {
            echo 
             "<tr class='style9'>
              <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['d_entry']}</td>
              <td style='border: 1px solid #ebf3ff;'>{$row['descr']}</td>
              <td style='border: 1px solid #ebf3ff;'>" . number_format($row['amt'], 2) . "</td>";
            for($i = 1; $i <= count($columns); $i++) {
              $acc_id2 = get_value('journal', 'acc_id', 'id', 
              $row['folio'], $con);
              if ($columns[$i] == $acc_id2) {
                echo "<td style='border: 1px solid #ebf3ff;'>" . number_format($row['amt'], 2) . "</td>";
                $totals[$acc_id2] += $row['amt'];
                $total +=  $row['amt'];
              }
              else 
                echo "<td style='border: 1px solid #ebf3ff;'>-</td>";
            }
            echo "</tr>";
          }
           
	    }         
      }
	  /*
	  echo "<tr class='style9'>
	        <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
            <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
            <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
            <td style='text-align:center; border:1px solid #ebf3ff;'><b>" . number_format($total, 2) . "</b></td>";
	  
           foreach($totals as $id => $amt) {
             if ($id == $acc_id)
               continue;
              echo "<td style='text-align:center; border:1px solid #ebf3ff'><b>" . number_format($amt, 2) . "</b></td>";
           }
	       $balance_cd = $totals[get_acc_id('Petty Cash', $con)] - $total;
           echo "</tr>
	        <tr class='style9'>
	         <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'>Balance C/D</td>
		     <td style='border: 1px solid #ebf3ff;'><b>" . number_format($balance_cd, 2) . "</b></td>
	        </tr>
	        <tr class='style9'>
	         <td style='border: 1px solid #ebf3ff; font-weight:bold;'>" . number_format($totals[get_acc_id('Petty Cash', $con)], 2) . "</td>
		     <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		     <td style='border: 1px solid #ebf3ff;'></td>
		     <td style='border: 1px solid #ebf3ff; font-weight:bold;'>" . number_format($balance_cd + $total, 2) . "</td>
	       </tr>
	       <tr class='style9'>
	        <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		    <td style='border: 1px solid #ebf3ff;'>&nbsp;</td>
		    <td style='border: 1px solid #ebf3ff;'>Balance B/F</td>
		    <td style='border: 1px solid #ebf3ff;'>" . number_format($balance_cd, 2) . "</td>
	       </tr>
	       ";
	  */
      main_footer();
	  exit;
    }
?>
 <form method='post' action='petty_cash_book.php'>
  <table width='100%'> 
   <tr class="class1">
    <td colspan="4"><h3>PETTY CASH BOOK</h3></td>
   </tr>
   <tr>
   <td>
    <table>
	 <tr>
	  <td>Start Date</td>
	  <td><input type='text' name='sdate'
	  <?php
	   echo "value='" . date("Y-d-m", mktime(0, 0, 0, 01, 01, 2011)) . "'/></td>"; 
	  ?>
	 </tr>
	 <tr> 
	  <td>End Date</td>
	  <td><input type='text' name='edate' value='<?php echo date('Y-m-d');?>'></td>
	 </tr>
	 <tr>
	  <td>
	   <input name="action" type="submit" value="Submit">
	   <input name='action' type='submit' value='Cancel'>
	  </td>
	 </tr>
    </table>
   </td>
  </tr>
 </table>
</form>
 <?php  main_footer();  ?>
