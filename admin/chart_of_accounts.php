<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);

require_once "ui.inc";
require_once "util.inc";
require_once 'acc.inc';
include_once 'treenode_class.php';

$con = connect();


$temp = get_user_perm($_SESSION['uid'], $con);
if (!(in_array('Chart Of Accounts', $temp) || in_array('Administrator', $temp))) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con, 'Accounting');

$table_width='100%';

  // check if we have created our session variable
  if(!isset($_SESSION['expanded'])) {
    $_SESSION['expanded'] = array();
  }

  // check if an expand button was pressed
  // expand might equal 'all' or a postid or not be set
  if(isset($_REQUEST['expand'])) {
    if($_REQUEST['expand'] == 'all')
      expand_all($_SESSION['expanded']);
    else
      $_SESSION['expanded'][$_REQUEST['expand']] = true;
  }

  // check if a collapse button was pressed
  // collapse might equal all or a id or not be set
  if(isset($_REQUEST['collapse'])) {
    if($_REQUEST['collapse'] == 'all')
      $_SESSION['expanded'] = array();
    else
      unset($_SESSION['expanded'][$_REQUEST['collapse']]);
  }

function expand_all(&$expanded) {
  // mark all threads with children as to be shown expanded
  $query = 'select id from account where children = 1';
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $num = mysqli_num_rows($result);
  for($i = 0; $i<$num; $i++) {
    $this_row =  mysqli_fetch_array($result, MYSQL_BOTH);
    $expanded[$this_row[0]]=true;
  }
}

function display_tree($expanded, $row = 0, $start = 0)
{
  // display the tree view of conversations

  global $table_width;
  echo "<table width = '$table_width' border='0'>";

  // see if we are displaying the whole list or a sublist
  if($start>0)
    $sublist = true;
  else
    $sublist = false;

  // construct tree structure to represent conversation summary
  $tree = new treenode($start, '',  1, true, -1, $expanded, $sublist);

  // tell tree to display itself
  $tree->display($row, $sublist);

  echo '</table>';
}
?>
<table style='width:100%;'>
 <tr class='class1'>
  <td><a href='account.php?action=Add&parent=0'>Add</a></td>
  <td class='style9'><h3>CHART OF ACCOUNTS</h3></td>
 </tr>
 <tr>
  <td colspan='2'><?php display_tree($_SESSION['expanded']); ?></td>
 </tr>
</table>
