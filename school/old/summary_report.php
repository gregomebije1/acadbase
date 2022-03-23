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

$user = array('Administrator','Accounts', 'Proprietor');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if(isset($_REQUEST['command']) && ($_REQUEST['command'] =="Print")) {
    print_header('Summary Report', 'summary_report.php',  
      'Back', $con);
} else {
  main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

$extra_caution_sql0 = " class_id={$_SESSION['class_id']} and school_id={$_SESSION['school_id']}";

 //Make sure that Session/Term/Class has been created and 
 //that the session variables representing them have been set
check_session_variables('summary_report.php', $con); 

$sql="SELECT sum(amount) as 'sum' FROM fee_class WHERE $extra_caution_sql0";
$result_x = mysqli_query($con, $sql) or die(mysqli_error($con));
$rowx = mysqli_fetch_array($result_x);
$amount_due = $rowx['sum'];

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Process')) {

  check($_REQUEST['Start_Date'], "Please enter Start Date", 
    'summary_report.php');

  check($_REQUEST['End_Date'], "Please enter Start Date", 
    'summary_report.php');

  ?>
  <table border='1' style='table-layout:row;'>
   <tr class='class1'><td colspan='6'><h3>Summary Report</h3></td></tr>

   <?php
  if (!isset($_REQUEST['command'])) {

    echo "
     <tr>
      <td>
       <span style='position:absolute;top:0px;left:200px;'>
	<a style='cursor:hand;'; onclick='window.open(\"summary_report.php?action=Process&Start_Date={$_REQUEST['Start_Date']}&End_Date={$_REQUEST['End_Date']}&class_id={$_REQUEST['class_id']}&command=Print\", \"smallwin\", 
	\"width=1200,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'>
	<img src='images/icon_printer.gif'></a>
       </span>
      </td>
     </tr>";
   }

   if ($_REQUEST['class_id'] == 'All') {
     $sql = "select s.id, s.admission_number, s.firstname, s.lastname, 
       s.class_id from student s join student_fees sf 
       on s.admission_number = sf.admission_number where sf.date 
       between '{$_REQUEST['Start_Date']}' 
       and '{$_REQUEST['End_Date']}' 
       and s.school_id={$_SESSION['school_id']} group by s.id
       order by s.class_id";

     $class_name = "ALL";
  } else if (($_REQUEST['class_id'] == 'JSS') || 
     ($_REQUEST['class_id'] == 'SSS')) {

     $sql = "select s.id, s.admission_number, s.firstname, s.lastname, 
      s.class_id  from student s join (class c, class_type ct, student_fees sf) 
      on (s.class_id = c.id and s.admission_number = sf.admission_number 
       and c.class_type_id = ct.id) 
       where ct.name= '{$_REQUEST['class_id']}'
       and s.school_id={$_SESSION['school_id']}
       group by ct.name order by s.class_id";

       $class_name = $_REQUEST['class_id'];
  } else {
    $sql="select s.id, s.admission_number, s.firstname, s.lastname, 
     s.class_id from student s join student_fees sf
	 on s.school_id = sf.school_id where s.class_id={$_REQUEST['class_id']} 
	 and (sf.date between '{$_REQUEST['Start_Date']}' and '{$_REQUEST['End_Date']}') group by s.id
	 order by s.class_id";

       $class_name = get_value('class', 'name', 'id', 
          $_REQUEST['class_id'], $con);
     }
     ?>
     <tr>
      <td colspan='6'>
       <table>
        <tr>
	 <td><b>Start Date</b></td><td><?=$_REQUEST['Start_Date']?></td>
	 <td><b>End Date</b></td><td><?=$_REQUEST['End_Date']?></td>
	 <td><b>Class</b><td><td><?=$class_name?></td>
	</tr>
       </table>
      </td>
     </tr>
	 <tr>
	  <th style='width:0.1%;'>S/N</th>
	  <th>Names</th>
	  <th>Class</th>
	  <th>Amount Due</th>
	  <th>Amount Paid</th>
	  <th>Amount Outstanding</th>
	 </tr>
	  
     <?
     $total_ad = 0;
     $total_ap = 0;
     $total_ao = 0;
	 
     $result = mysqli_query($con, $sql) or die(mysqli_error($con));
     if (mysqli_num_rows($result) <= 0) {
       echo "<tr><td colspan='6' style='text-align:center; font-weight:bold;'>
         No Records</td></tr>";
       main_footer();
       exit;
     }	   
     $i = 1;
     while($row = mysqli_fetch_array($result)) {
       echo "
       <tr style='text-align:center;'>
        <td style='width:0.01%'>$i</td>
	<td style='text-align:left;'>
       {$row['admission_number']} {$row['firstname']} {$row['lastname']}</td>";

       echo "<td>" 
        . get_value('class', 'name', 'id', $row['class_id'], $con) . "</td>";

       $sql1 = "SELECT  sum(amount_paid) as 'amount_paid'
	 from student_fees where admission_number={$row['admission_number']}  and date 
         between '{$_REQUEST['Start_Date']}' and '{$_REQUEST['End_Date']}' 
		 and school_id={$_SESSION['school_id']} order by id asc";		   
	   
       $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
       $row1 = mysqli_fetch_array($result1);

       echo "<td>".number_format($amount_due, 2) . "</td>";
       echo "<td>".number_format($row1['amount_paid'], 2) ."</td>";
       echo "<td>"
        .number_format($amount_due - $row1['amount_paid'], 2) ."</td>";

       echo "</tr>";
       $total_ad += $amount_due;
       $total_ap += $row1['amount_paid'];
       $total_ao += $amount_due - $row1['amount_paid'];
       $i++;
     }
	 
     echo "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
      <tr><th colspan='2'>Total Due</th><td><h3>" 
         . number_format($total_ad, 2) . "</h3></td></tr>

      <tr><th colspan='2'>Total Paid</th><td><h3>" 
         . number_format($total_ap, 2) . "</h3></td></tr>

      <tr><th colspan='2'>Total Outstanding</th><td><h3>" 
         . number_format($total_ao, 2) . "</h3></td></tr>
     ";
         
    exit;  //Dont process Process beyond this point
} // end of 'action=Process'
?>
<form action="summary_report.php" method="post">
<table> 
 <tr class="class1">
  <td colspan="4"><h3>Summary Report</h3></td>
 </tr>
  <tr>
   <td>Start Date</td>
   <td><input type='text' name='Start_Date' 
      id='Start_Date', value='<?php echo date('Y-m-d');?>'></td>
  </tr>
  <tr> 
   <td>End Date</td>
   <td><input type='text' name='End_Date' 
     id='End_Date' value='<?php echo date('Y-m-d');?>'></td>
  </tr>
  <tr>
   <td>Class</td>
   <td>
   <?php
     //$a = array("All"=>"All", "JSS"=>"JSS", "SSS"=>"SSS");
     $sql="select * from class where school_id={$_SESSION['school_id']}";
     echo selectfield(my_query($sql, 'id', 'name'), 'class_id', '');
   ?>
   </td>
  </tr>
  <tr>
   <td>
    <input name="action" type="submit" value="Process">
    <input name='action' type='submit' value='Cancel'>
   </td>
  </tr>
</table>
 </form>
<?php  main_footer(); ?>
