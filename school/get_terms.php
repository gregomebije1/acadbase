<?php
require_once "util.inc";
$con = connect();
echo selectfield(my_query("select * from term where session_id={$_GET['session_id1']} order by id asc",
  'id', 'name'), 'term_id1','');
?>