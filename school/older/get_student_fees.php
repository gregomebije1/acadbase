<?php
require_once "ui.inc";
require_once "util.inc";
require_once "school.inc";


$con = connect();
//echo get_all_fees($_REQUEST['class_id']);

$amount_remaining = get_all_fees($_REQUEST['class_id']) -
    get_amount_paid($_REQUEST['session_id'], $_REQUEST['term_id'],
     $_REQUEST['class_id'], $_REQUEST['student_id']);

echo $amount_remaining;
?>
