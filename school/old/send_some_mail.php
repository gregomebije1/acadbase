<?php
error_reporting(E_ALL);

require_once '../accounting/acc.inc';
require_once 'util.inc';
require_once 'ui.inc';

$con = connect();

$people = array('13'=>'dimla.adenrele@yahoo.com', '14'=>'gssjikwoyi@yahoo.com');

foreach ($people as $school_id => $email) {
  $school_name = get_value('school', 'name', 'id', $school_id, $con);
  $subject = "Welcome to Acadbase, " . $school_name;

  $msg = "<p>Thank You <strong>" . $school_name . 
     "</strong> for signing up with <strong>Acadbase</strong>
     we want to assure you that the <strong>Acadbase</strong>
     team is available 24hrs to respond to any question or
     technical support you might need, feel free to contact us
     via the email provided below or on our website.</p>
    <p>
    <p>support@acadbase.com</p>
    <p><a href='acadbase.com'>Acadbase.com</p>";

  send_mail($school_id, $email, $subject, $msg, $con);
}
 echo "OK Done";
?>
