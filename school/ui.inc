<?php

require_once 'school.inc';


function welcome_screen($con) {
  header("Location: choose_session_term_class.php");

}
function print_header($title, $url, $urltext, $con) {
  $result = mysqli_query($con, "SELECT * FROM school")
    or die("Cannot execute SQL query at print_header" . mysqli_error($con));
  $row = mysqli_fetch_array($result);

  ?>
    <html>
      <head>
       <title><?=$title?></title>
       <link rel='stylesheet' type='text/css' href='css/print.css'>
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
         <tr><td><?php echo $row['email'] . " " . $row['website']; ?></td></tr>
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
  <?php
}
function main_menu($uid, $name, $con) {
  global $school_name;

  $session = isset($_SESSION['session_id']) ?
    get_value('session', 'name', 'id', $_SESSION['session_id'], $con) : "";

  $term = isset($_SESSION['term_id']) ?
    get_value('term', 'name', 'id', $_SESSION['term_id'], $con) : "";

  $class = isset($_SESSION['class_id']) ?
    get_value('class', 'name', 'id', $_SESSION['class_id'], $con) : "";

  $host_school_name = isset($_SESSION['school_id']) ?
    get_value('school', 'name', 'id', $_SESSION['school_id'], $con) : "";

  ?>

  <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
  <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
   <head>
   <title>AcadBase</title>

   <link rel="stylesheet" type="text/css" href="js/themes/base/jquery.ui.all.css">

    <!-- For Table sorter -->
   <link rel='stylesheet' type='text/css' href="css/tablesorter/style.css"
     media="print, projection, screen" />

   <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
   <script src="js/ui/jquery.ui.core.js"></script>
   <script src="js/ui/jquery.ui.widget.js"></script>
   <script src="js/ui/jquery.ui.datepicker.js"></script>
   <script src="js/ui/jquery.ui.mouse.js"></script>
   <script src="js/ui/jquery.ui.button.js"></script>
   <script src="js/ui/jquery.ui.draggable.js"></script>
   <script src="js/ui/jquery.ui.position.js"></script>
   <script src="js/ui/jquery.ui.resizable.js"></script>
   <script src="js/ui/jquery.ui.dialog.js"></script>
   <script src="ui/jquery.effects.core.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>


   <script type='text/javascript'
      src='js/jquery.tablesorter.min.js'></script>
   <script type='text/javascript'
      src='js/jquery.tablesorter.pager.js'></script>
   <script type='text/javascript' src='js/chili-1.8b.js'></script>
   <script type='text/javascript' src='js/docs.js'></script>
   <script type='text/javascript'>
   $(function() {
     $("table")
       .tablesorter({widthFixed: true, widgets: ['zebra']})
       .tablesorterPager({container: $("#pager")});
     });
   </script>

   <script>
    $(function() {
     $( "#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
     $( "#Start_Date").datepicker({ dateFormat: "yy-mm-dd" });
     $( "#End_Date").datepicker({ dateFormat: "yy-mm-dd" });
	 $( "#date_of_admission").datepicker({ dateFormat: "yy-mm-dd" });
	 $( "#date_of_birth").datepicker({ dateFormat: "yy-mm-dd" });
     //$( "#monthpicker" ).datepicker({ dateFormat: "mm", monthNames: ['Januar','Februar','Marts','April','Maj','Juni','Juli','August','September','Oktober','November','December'] });
    });
   </script>

   <style>
    .ui.autocomplete-loading { background: url('images/ui-anim_basic16x16.gif')
      right center no-repeat; }
   </style>

   <link rel='stylesheet' type='text/css' href="css/school.css">		   <link rel="stylesheet" type="text/css"
      href="css/ui-lightness/jquery-ui-1.8.custom.css">
   <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
   <script language='javascript' src='js/school.js'></script>
   <script type="text/javascript" src="js/custom.js"></script>

   </head>
   <body>
    <div class='header'>
  <?php
    echo "
     <p>AcadBase</p>
     <p>Welcome - {$_SESSION['firstname']} {$_SESSION['lastname']} </p>
     <p>$host_school_name</p>
     <p style='color:red;'>Session: $session </p>
     <p style='color:red;'>Term: $term </p>
     <p style='color:red;'>Class: $class </p>";
    if (isset($_SESSION['message']))
      echo "<p>{$_SESSION['message']}</p>";
    ?>
    </p>
     <a style='float:right; color:red;' href='logout.php'> Sign Out</a>

       </div>
       <div class='bar'></div>
       <div class='navigation'>
        <ul>

  <?php
  $user = array('Records', 'Administrator', 'Exams', 'Proprietor');
  $user1 = array('Administrator', 'Proprietor');
  if (user_type($uid, $user, $con)) {
    if (user_type($uid, array('Administrator','Records','Proprietor'), $con)) {
      $menu["student.php"]='Students';
	  $menu["attendance.php"]='Attendance';
	  $menu['choose_session_to_promote_to.php']='Promote/Demote';
      $menu['class_type.php']='Class Type';
      $menu['class.php']='Class';

    if (user_type($uid, array('Administrator','Exams','Proprietor'), $con))
      $menu['subject.php']='Subjects';
    }
   generate_menu("Academic", $menu);
  }
  unset($menu);

  if (user_type($uid, array('Administrator', 'Exams', 'Proprietor'), $con)) {
     $menu['class_result.php?action=Generate']='Result';
     //$menu['report_card.php']='Student Result';
     $menu['enter_scores.php']='Enter Scores';

     $menu['enter_non_academic.php']='Enter Non-Academic';
     $menu['enter_comment.php']='Enter Comment';
	 $menu['academic_history.php']='Academic History';
     generate_menu("Exam", $menu);
   }
  unset($menu);

  
  if (user_type($uid, array('Administrator', 'Accounts', 'Proprietor'), $con)) {
    $menu['fee_class.php']='Specify School Fees';
    $menu['enter_fees.php']='Enter Fees';
    $menu['financial_history.php']='Financial History';
    generate_menu("School Fees", $menu);
  }
  unset($menu);


  if (user_type($uid, $user1, $con)) {
    $menu['choose_session_term_class.php']='Change Session/Term/Class';
    $menu['grade_settings.php']='Grade Settings';
    $menu['non_academic.php']='Non-Academic Settings';
    $menu['school.php']='School Information';
    $menu['session.php']='Session';
    $menu['term.php']='Term';
    $menu['users.php']='Users';
    generate_menu("Settings", $menu);
   }
  unset($menu);
   echo "
    </ul>
   </div>
   <div class='content'>";

}
function main_footer() {
?>
     </div> <!-- End of content -->
    </div> <!-- End of container -->
   </body>
  </html>
<?php
}
?>
