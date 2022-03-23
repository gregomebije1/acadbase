<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
require_once 'util.inc';
require_once 'ui.inc';
require_once 'backup_restore.inc';

$con = connect();

if (isset($_SESSION['sessid'])) {
  if (isset($_SESSION['session_id']) && isset($_SESSION['class_id'])) {
    close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);
    unset($_SESSION['session_id']);
    unset($_SESSION['class_id']);
  }
}

$_SESSION['sessid'] = mt_rand();
error_reporting(E_ALL);


if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'OK')) {

  if(($_REQUEST['session_id1'] == '0') || ($_REQUEST['class_id1'] == '0')) {
    $text = "";
    if (isset($_REQUEST['REFERER']))
	  $text = "<input type='hidden' name='REFERER' value='{$_REQUEST['REFERER']}'/>";
    my_redirect('choose_session_term_class.php', $text);
	exit;
  }
  $_SESSION['session_id'] = $_REQUEST['session_id1'];
  $_SESSION['term_id'] = $_REQUEST['term_id1'];
  $_SESSION['class_id'] = $_REQUEST['class_id1'];

  close_acadbase_session($_SESSION['sessid'], $_SESSION['school_id'], $_SESSION['session_id'], $_SESSION['class_id'], $con);

  $file_name = "data/{$_SESSION['school_id']}/{$_SESSION['session_id']}_{$_SESSION['class_id']}.sql";

  open_session($_SESSION['sessid'], $file_name, $con);

  if (isset($_REQUEST['REFERER']))
    my_redirect($_REQUEST['REFERER'], '');
  else
    my_redirect('student.php', '');
  exit;
}
//Close any existing session

main_menu($_SESSION['uid'], '', $con);
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
     //$( "#monthpicker" ).datepicker({ dateFormat: "mm", monthNames: ['Januar','Februar','Marts','April','Maj','Juni','Juli','August','September','Oktober','November','December'] });
    });
   </script>

   <script language='javascript' src='js/school.js'></script>
   <script type="text/javascript" src="js/custom.js"></script>

  <link rel="stylesheet" href="js/themes/base/jquery.ui.all.css">
 <style>
  body { font-size: 62.5%; }
  label, input { display:block; }
  input.text { margin-bottom:12px; width:95%; padding: .4em; }
  fieldset { padding:0; border:0; margin-top:25px; }
  h1 { font-size: 1.2em; margin: .6em 0; }
  div#users-contain { width: 350px; margin: 20px 0; }
  div#users-contain table {
   margin: 1em 0; border-collapse: collapse; width: 100%; }
  div#users-contain table td, div#users-contain table th {
   border: 1px solid #eee; padding: .6em 10px; text-align: left; }
 .ui-dialog .ui-state-error { padding: .3em; }
 .validateTips { border: 1px solid transparent; padding: 0.3em; }
 </style>
 <script>
  $(function() {

  var counter = $("#counter");

  // a workaround for a flaw in the
  //demo system (http://dev.jqueryui.com/ticket/4375), ignore!
  //$( "#dialog:ui-dialog" ).dialog( "destroy" );

  var session_id = $( "#session_id" ),
   term_id = $("#term_id"),
   class_id  = $( "#class_id" ),
   allFields = $( [] ).add( session_id ).add(term_id).add( class_id ),
   tips = $( ".validateTips" );

   function updateTips( t ) {
     tips
       .text( t )
       .addClass( "ui-state-highlight" );
     setTimeout(function() {
      tips.removeClass( "ui-state-highlight", 1500 );
     }, 500 );
   }

   function ifValid(o) {
     if (o.val() == 0) {
       o.addClass("ui-state-error" );
       updateTips("Please choose an option: ");
       return false;
     } else
       return true;
   }

   $( "#dialog-form" ).dialog({
     autoOpen: true,
     height: 300,
     width: 300,
     modal: true,
     buttons: {
       "OK": function() {
         var bValid = true;
	 allFields.removeClass( "ui-state-error" );
	 bValid = bValid && ifValid(session_id);
	 bValid = bValid && ifValid(term_id);
	 bValid = bValid && ifValid(class_id);

         if (bValid) {
           document.form1.submit();
           //$( this ).dialog( "close" );
         }
       },
       Cancel: function() {
         $( this ).dialog( "close" );
           location.href='welcome.php';
       },
     },
     close: function() {
       allFields.val( "" ).removeClass( "ui-state-error" );
       location.href='welcome.php';
     }
 });
 });
 </script>
 </head>
 <body>
 <div id="dialog-form" title="Acadbase" >
  <p class="validateTips">Please make a choice</p>
   <form name='form1' method='post' method='choose_session_term.php'>
    <table border="0">
     <tr class='class1'><td colspan='2'
   style='text-align:center; font-size:2em; font-weight:normal;'>
  </td></tr>

  <tr>
   <td>Session</td>
   <td>
   <?php
    $sql="select * from session where school_id={$_SESSION['school_id']} order by id asc";
    $arr = array('0'=>'Choose Session') + my_query($sql, 'id', 'name');
    echo selectfield($arr, 'session_id1','',
     'display:inline', "get_terms(\"session\", \"terms\");");
    if (isset($_REQUEST['REFERER']))
     echo "<input type='hidden' name='REFERER' value='{$_REQUEST['REFERER']}'>";
   ?>
   </td>
  </tr>
  <tr>
   <td>Term</td>
   <td><div id='terms'></div></td>
  </tr>
  <tr>
   <td>Class</td>
   <td>
  <?php
    $sql="select * from class where school_id={$_SESSION['school_id']} order by id asc";
    $arr = array('0'=>'Choose Class') + my_query($sql, 'id', 'name');
    echo selectfield($arr, 'class_id1','');
  ?>
  </td>
  </tr>
  <input type='hidden' name='action' value='OK'/>
 </form>
 </table>
 </div>
</body>
</html>
