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
if (!user_type($_SESSION['uid'], 'Administrator', $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
  print_header('Class List', 'class.php', '', $con);
} else {
    main_menu($_SESSION['uid'],
      $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

if (isset($_REQUEST['action']) && 
   ($_REQUEST['action'] == 'add_students_to_class')) {
    header('Location: add_student_to_class.php');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Delete')) {
   if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a class", 'class.php', 'Back');
	  exit;
	}
	$sql="select c.id from class c join student s 
	 on c.id = s.current_class_id where c.id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) > 0) {
	  echo msg_box("Deletion denied<br>
	   They are students currently allocated to this class", 
	   'class.php', 'Back');
	  exit;
	}
	echo msg_box("Are you sure you want to delete " . 
	  get_value('class', 'name', 'id', $_REQUEST['id'], $con) . "?", 
	  "class.php?action=confirm_delete&id={$_REQUEST['id']}", 
	 'Continue to Delete');
	exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'confirm_delete')) {
    if (empty($_REQUEST['id'])) {
	  echo msg_box("Please choose a class", 'class.php', 'Back');
	  exit;
	}
	$sql="select * from class where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) <= 0) {
	  echo msg_box("Class does not exist in the database", 'class.php', 'OK');
	  exit;
	}
	$sql="delete from class where id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql="delete from fee_class where class_id={$_REQUEST['id']}";
	$result = mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Class has been deleted", 'class.php', 'OK');
    exit;
  }
  if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Add Class')) {
    if (empty($_REQUEST['name']))  {
       echo msg_box('Please enter Class Name', 
        'class.php?action=Add', 'Back');
       exit;
    }
    $sql="select * from class where name='{$_REQUEST['name']}'"; 
    if (mysql_num_rows(mysql_query($sql)) > 0) {
      echo msg_box("{$_REQUEST['name']} class already exists
       in the database. Please choose another name", 
       'class.php?action=Add', 'Back');
      exit;
    }
    $sql="insert into class(name, type)
      values('{$_REQUEST['name']}', '{$_REQUEST['type']}')";
    mysql_query($sql) or die(mysql_error());
	$class_id = mysql_insert_id();

    $sql2="select * from fee";
    $result2 = mysql_query($sql2) or die(mysql_error());
    while ($row = mysql_fetch_array($result2)) {
      $sql="insert into fee_class(fee_id, class_id, amount) values 
       ({$row['id']}, $class_id, '0')";
	  $result = mysql_query($sql) or die(mysql_error());
	}
    echo msg_box("Successfully added", 'class.php', 'Continue');
    exit;
  } else if (isset($_REQUEST['action']) && 
    ($_REQUEST['action'] == 'Update Class')) {
	//Not allowed to change the type of the class
	//as this will affect the subjects that are registered
	//under this class
    if (empty($_REQUEST['name'])) {
      echo msg_box("Please enter class name", 'class.php', 'Back');
      exit;
    }
    $sql="update class set name='{$_REQUEST['name']}' where id={$_REQUEST['id']}";
    mysql_query($sql) or die(mysql_error());
	
	echo msg_box("Class Updated", 'class.php', 'Continue');
  } else if (isset($_REQUEST['action']) && 
   (($_REQUEST['action'] == 'Add') || ($_REQUEST['action'] == 'Edit'))) {
    
   if (($_REQUEST['action'] != 'Add') && (!isset($_REQUEST['id']))){
     echo msg_box("Please choose a class to edit", 'class.php', 'Back');
     exit;
   }
   if (($_REQUEST['action'] != 'Add') && isset($_REQUEST['id'])){
     $sql = "select name, type from class where id={$_REQUEST['id']}";
     $result = mysql_query($sql);
     $row = mysql_fetch_array($result);
     $name=$row['name'];
     $type= $row['type'];
   } else {
     $name="";
     $type="";
   }
  ?>
  <table> 
   <tr class="class1">
    <td colspan="4"><h3><?php echo $_REQUEST['action']; ?> Class</h3></td>
   </tr>
   <form action="class.php" method="post">
   <?php
   if ($_REQUEST['action'] == 'Edit') {
     echo "<tr><td colspan='2'>
	   <table>
	    <tr>
		 <td>
		  Please note that you cannot change the type of the class
	      using the Edit Functionality.<br>
		  To change the type of the class, delete the class and add it
		  again specifying the type of class you want in the process.
		 </td>
		</tr>
	   </table>
	  </td>
	 </tr>";
    }
	?>
   <tr>
    <td>Class Name</td>
    <td>
     <input type="text" name="name" 
     value='<?php echo $name; ?>'></td>
   </tr>
   <tr>
    <td>Term</td>
    <td>
     
     <?php
     if (!empty($type)) {
       if ($type == 'jss') 
        echo "JSS";
       else 
        echo "SSS";
     } else {
	    echo "<select name='type'> 
          <option value='jss'>JSS</option>
          <option value='sss'>SSS</option>
		 </select>";
     }
     ?>
    </td>
   </tr>
  <tr>
    
    <td>
    <?php  
    if($_REQUEST['action'] == 'Edit') { 
       echo "<input name='id' type='hidden' value='{$_REQUEST['id']}'>";
      }
      echo "<input name='action' type='submit' value='"; 
      echo $_REQUEST['action'] == 'Edit' ? 'Update' : 'Add';
      echo " Class'>";
    ?>
    <input name="action" type="submit" value="Cancel">
    </td>
   </tr>
  </table>
  <?
  exit;
  } 
  if (!isset($_REQUEST['action']) || ($_REQUEST['action'] == 'Cancel')
   || ($_REQUEST['action'] == 'Print')) {
  ?>
  <table border='1'>
   <tr class='class1'>
     <?php
       if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
         echo "<td></td>";
       } else {
        echo "<td>
     <form name='form1' action='class.php' method='post'>
     <select name='action' onChange='document.form1.submit();'>
      <option value=''>Choose option</option>
      <option value='Add'>Add</option>
      <option value='Edit'>Edit</option>
      <option value='Delete'>Delete</option>
      <option value='Print'>Print</option>
     </select>
    </td>
    ";
    }
   ?>
   <td colspan='7' style='text-align:center;'><h3>Class List</h3></td>
   </tr>
   <tr>
    <th></th>
    <th>Class Name</th>
	<th>Class Type</th>
    <th>No of Students</th> 
   </tr>
   <?
   $result = mysql_query("select * from class", $con);
   while($row = mysql_fetch_array($result)) {
     $sql="select count(*) as 'count' from student where current_class_id = 
       {$row['id']}";
     $result2 = mysql_query($sql);
     $row2 = mysql_fetch_array($result2);
     echo "
     <tr>
      <td><input type='radio' name='id' value='{$row['id']}'></td>
     ";
     if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Print')) {
       echo "<td>{$row['name']}</td>";
     } else {
       echo "<td>
       <a href='student.php?filter=student_class&class_id={$row['id']}'>
        {$row['name']}</a>
      </td>
      ";
     }
     echo " <td>" . strtoupper($row['type']) . "</td>
      <td>{$row2['count']}</td>
     </tr>";
   }
   echo '</form></table>';
   main_footer();
 }
?>
