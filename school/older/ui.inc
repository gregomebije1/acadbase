<?php 

include_once 'util.inc';
include_once 'school.inc';

function welcome_screen($type, $con) {
  $welcome = array('Records'=>'student.php', 'Exams'=>'class_result.php', 
   'Accounts'=>'profit_and_loss.php', 'Expenditure'=>'expense_report.php', 
   'Administrator'=>'users.php');
  foreach($welcome as $user_right => $url) {
    if (user_type($_SESSION['uid'], $user_right, $con)) {
      if ($type == 'location') {
        header("Location: $url");
      } else {
        include_once($url); 
	  }
    }
  }
}

function tr($arr) {
  $output = "<tr>";
  foreach($arr as $td) {
    $output .= "<td>$td</td>";
  }
  $output .= "</tr>";
  return $output;
}
function textfield() {
  $numargs = func_num_args();
  if ($numargs < 2) die("textfield second argument is missing");
  
  $output = "<input type='text' ";
  $arg_list = func_get_args();
  for ($i = 0; $i < $numargs; $i+=2) {
    $output .= " {$arg_list[$i]}='{$arg_list[$i+1]}' ";
  }
  $output .= ">";
  return $output;
}
function textarea($name, $value, $rows='5', $cols='30') {
  $numargs = func_num_args();
  if ($numargs < 2) die("textarea second argument is missing");
  return "<textarea name='$name' rows='$rows' cols='$cols'>$value</textarea>";
}

function selectfield($arr, $name, $default_id) {
  $output = "<select name='$name' id='$name'>";
  foreach($arr as $id => $value) {
    if ($id == $default_id)
      $output .= "<option value='$id' selected='selected'>$value</option>";
    else
      $output .= "<option value='$id'>$value</option>";
  }
  $output .="</select>";
  return $output;
}

function calculate_fee($fee_name, $con) {
  $sql="SELECT sum(f.amount) as 'amount' from fee f join fee_type ft 
   on f.fee_type_id = ft.id where ft.name = '$fee_name' group by ft.name";
  $result = mysql_query($sql, $con);
  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_array($result);
	return $row['amount'];
  } else {
    return 0;
  }
}
function get_row_value_by_name($table, $name, $con) {
  $sql="select id from $table where name='$name'";
  $result = mysql_query($sql, $con);
  $row = mysql_fetch_array($result);
  return $row['id'];
}
function get_row_value_by_id($table, $id, $con) {
  $sql="select name from $table where id=$id";
  $result = mysql_query($sql, $con);
  $row = mysql_fetch_array($result);
  return $row['name'];
}
function get_table_data($table, $con) {  
  $sql="SELECT * FROM $table";
  $result = mysql_query($sql, $con);
  echo "<select name='{$table}_id' id='{$table}_id'>";
  echo "<!--<option>--Select--</option>-->";
  while ($row = mysql_fetch_array($result)) {
    echo "<option value='{$row['id']}'>{$row['name']} </option>";
  } 
  echo "</select>";
}


function is_table_empty($table, $con) {
  $sql="select * from $table";
  $result = mysql_query($sql, $con);
  if (mysql_num_rows($result) <= 0) 
    return true;
   else 
     return false;
}	 
function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if (!isset($key) || ($value == '')) 
        return false;
  } 
  return true;
}

function valid_email($address) {
  // check an email address is possibly valid
  if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address))
    return true;
  else 
    return false;
}


function generate_menu($heading, $menu) {  
?>
  <li><?=$heading?></li>
  <li>
   <ul>
   <? 
    foreach($menu as $url => $name) {
      echo "<li><a href=\"$url\">$name</a></li>\n";
    } 
   ?>
   </ul>
  </li>
<?
} 
function print_header($title, $url, $urltext, $con) { 
  $result = mysql_query("SELECT * FROM school_info", $con) 
    or die("Cannot execute SQL query at print_header" . mysql_error());
  $row = mysql_fetch_array($result);
  
  ?>
    <html>
      <head>
       <title><?=$title?></title>
       <style>
       a:hover, a:active, a:visited, a:link {
         text-decoration:none;
         color:red;
       }
       .h table td {
        font: 78%/1.5 arial, helvetica, serif;
        text-align: left;
        padding: 0;
        /*margin: 2em; */
       }
	   th {
	    font: 78%/1.5 arial, helvetica, serif;
        text-align: left;
        /*padding: 0; */
        padding: 0.1em 1em;
	font-weight:bold;
        border: 1px solid #999;
	    }
       .h td {
        font: 78%/1.5 arial, helvetica, serif;
        text-align: left;
        padding: 0;
       }
       .s {
        font: 78%/1.5 arial, helvetica, serif;
        text-align: center;
        padding: 0;
        border-width:1px; border-style:solid;
       }
	   table .class1 {
		border-bottom: #ffffff 0.1em solid;
	    /*background-color:#d6e8ff;*/
        background-color:#ebf3ff;
        font-weight:bold;
       }
	  table {
       color:black;
       background-color: white;
       border-width:1px;
       text-align: left;
       padding: 0;
       width:100%;
       table-layout: float;
       border: #d6e8ff 0.1em solid;
       border-collapse:collapse;
     }
       </style>
      </head>
      <body style="text-align:center;" >
       <!--<a href='<?=$url?>'><?=$urltext?></a>-->
	   <!--
       <table class="s" align="center" width="70%" 
        cellpadding="0" cellspacing="0"> 
         <tr><td><h2><?=$row['name']?></h2></td></tr>
         <tr><td><?=$row['address']?></td></tr>
         <tr><td><?=$row['phone']?></td></tr>
         <tr><td><?php echo $row['email'] . " " . $row['web']; ?></td></tr>
         <tr><td>&nbsp;</td></tr>
       </table>
	   -->
       <table class="h" align="center" rules="rows" border="1"
        style="
          border-width:1px; 
          border-style:solid;"
         border="0" width="70%" cellspacing="0" cellpadding="0">
         <tr>
          <td style="background-color:#ebf3ff" colspan="8">
          <!--<h3><?=$title?></h3>-->
          </td>
         </tr>
  <?
}
function main_menu($uid, $name, $con) { 
 if (isset($_SESSION['session_id'])) 
   $session_name = get_value('session', 'name', 'id', $_SESSION['session_id'],$con); 
 else 
   $session_name ="";
 if (isset($_SESSION['term_id']))
   $term_name = get_value('term', 'name', 'id', $_SESSION['term_id'],$con);
 else 
   $term_name = "";
 if (isset($_SESSION['firstname'])) {
   $firstname = $_SESSION['firstname'];
   $lastname = $_SESSION['lastname'];
 } else {
   $firstname = "";
   $lastname = "";
 }
echo "
 <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
	'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
      <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
       <head>
	   <title>AcadPro</title>
        <script type='text/javascript' src='school.js'> </script>
        <link rel='stylesheet' type='text/css' href='school.css'>
       </head>
       <body>
       <div class='header'>
        <p>AcadPro</p>
        <p>Welcome - $firstname $lastname </p> 
        <p style='color:red;'>";
         echo "$session_name Session
		 </p>
		 <p style='color:red;'>"; 
         echo "$term_name Term
		 </p>
        <p><a href='faq.php'>FAQ/Help</a></p>
        <a href='index.php?action=logout'> Sign Out</a>
       </div>
       <div class='bar'></div>
       <div class='navigation'>
        <ul>
	    ";

  if (user_type($uid, 'Records', $con) ||
     user_type($uid, 'Administrator', $con) ||
     user_type($uid, 'Exams', $con)) {
    if (user_type($uid, 'Administrator', $con)) {
      $menu['class.php']='Class';
    } 
    if (user_type($uid, 'Administrator', $con) 
     || user_type($uid, 'Exams', $con)) {
      $menu['subject.php']='Subjects';
    } 
    if (user_type($uid, 'Administrator', $con) 
     || user_type($uid, 'Records', $con)) {
      $menu['student.php']='Students';
	  $menu['staff.php']='Staff';
    }
   generate_menu("Academic", $menu);
  }
  unset($menu);
  
  if (user_type($uid, 'Administrator', $con) || 
     (user_type($uid, 'Exams', $con))) {
     $menu['enter_scores.php']='Enter Scores';
     $menu['report_card.php']='Student Result';
     $menu['class_result.php']='Class Result';
     $menu['promote.php']='Promotion/Transfer';
	 $menu['enter_non_academic.php']='Students Non-Academic';
     generate_menu("Exam", $menu);
   }
  unset($menu);
  if (user_type($uid, 'Administrator', $con) ||
     user_type($uid, 'Accounts', $con)) {
	 $menu['fee.php']='List of Fees';
     $menu['fee_schedule.php']='Fee Schedule';
     $menu['pay_school_fees.php']='Pay School Fees';
     $menu['class_fee.php']='Class Receipt';
     $menu['student_fee.php']='Student Receipt'; 
	 generate_menu("School Fees", $menu);
  }
  unset($menu);

  if (user_type($uid, 'Administrator', $con) ||
     user_type($uid, 'Accounts', $con)) {
     $menu['type_of_income.php']='Types of Income';
     $menu['enter_income.php']='Enter Income';
     $menu['income_report.php']='Income Report'; 
     generate_menu("Other Income", $menu);
  }
  unset($menu);
  
  if (user_type($uid, 'Administrator', $con) ||
      user_type($uid, 'Accounts', $con) ||
      user_type($uid, 'Expenditure', $con)) {
    $menu['type_of_expenses.php']='Type of Expenses';
    $menu['enter_expenses.php']='Enter Expenses'; 
    $menu['expense_report.php']='Expense Report';
    generate_menu("Expenses", $menu);
  }
  
  unset($menu);
  
  if (user_type($uid, 'Administrator', $con) ||
      user_type($uid, 'Accounts', $con)) {
     $menu['profit_and_loss.php']='Profit and Loss';	
	 generate_menu("Report", $menu);  
  }
  unset($menu);

  if (user_type($uid, 'Administrator', $con)) {
     $menu['grade_settings.php']='Grade Settings';
	 $menu['non_academic.php']='Non-Academic Settings';
     $menu['school_info.php']='School Information';
     $menu['session.php']='Session';
     $menu['term.php']='Term';
     $menu['users.php']='Users';
	 $menu['backup_restore.php']='Backup/Restore';
	 $menu['sync_settings.php']='Sync Settings';
	 $menu['sync.php']='Sync';
     generate_menu("SetUp", $menu);
   }
  unset($menu);
   echo "
    </ul>
   </div>
   <div class='content'>";
}
function main_footer() {
  echo "
     </div> <!-- End of content -->
    </div> <!-- End of container -->
   </body>
  </html>";
}
