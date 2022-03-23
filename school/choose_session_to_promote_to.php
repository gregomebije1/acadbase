<?php
session_start(); 

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once 'util.inc';
require_once 'ui.inc';
require_once 'backup_restore.inc';

$con = connect();

main_menu($_SESSION['uid'], '', $con);
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'OK')) {
  if ($_REQUEST['session_id1'] == $_SESSION['session_id']) {
    echo msg_box("Cannot Promote/Demote to the same session<br>Please choose another session or create a new Session"
	, 'choose_session_to_promote_to.php', 'Back'); 
	exit;
  }
  my_redirect('change_class.php', "<input type='hidden' name='session_id1' value='{$_REQUEST['session_id1']}'>");
}


?>
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
   allFields = $( [] ).add( session_id ),
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
     height: 200,
     width: 350,
     modal: true,
     buttons: {
       "OK": function() {
         var bValid = true;
	 allFields.removeClass( "ui-state-error" );
	 bValid = bValid && ifValid(session_id);
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
 <div id="dialog-form" title="Acadbase" >
  <p class="validateTips">Please choose a Session you wish to promote to</p>
   <form name='form1' method='post' method='change_class.php'>
    <table border="0">
     <tr class='class1'><td colspan='2' 
   style='text-align:center; font-size:2em; font-weight:normal;'>
  </td></tr>
  <tr>
   <td>Session</td>
   <td>
   <?php
    $sql="select * from session where school_id={$_SESSION['school_id']} order by id asc";
    echo selectfield(my_query($sql, 'id', 'name'), 'session_id1','',
     'display:inline', "get_terms(\"session\", \"terms\");");
    
   ?>
   </td>
  </tr>
  <input type='hidden' name='action' value='OK'/>
 </form>
 </table>
 </div>
</body>
</html>
