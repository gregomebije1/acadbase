<?php
require_once("config.inc");

$con = connect();

define("SUBSCRIPTION_MESSAGE", "Please subscribe to have access to this page");

// seed with microseconds
function make_seed() {
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function check($value, $msg, $url, $back='Back') {
  if (empty($value)) {
    echo msg_box($msg, $url, $back);
    exit;
  }
}
function send_mail($school_id, $email, $subject, $msg, $con) {
  // multiple recipients
  $to  = "$email" . ', '; // note the comma
  //$to .= 'wez@example.com';

  $school_name = get_value('school', 'name', 'id', $school_id, $con);

  // message
  $message = "
   <html>
    <body> $msg </body>
   </html>
  ";

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= "To: {$school_name}<{$email}>" . "\r\n";
  $headers .= 'From: Acadbase <contact@acadbase.com>' . "\r\n";
  $headers .= 'Bcc: all@acadbase.com' . "\r\n";

  // Mail it
  mail($to, $subject, $message, $headers);
}
function validate_email($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function update($table, $sql, $con) {
  //Since this is an upgrade, we need to check if this table exist
 //If it doesn't exist then create it automatically
 $result = mysqli_query($con, "show tables") or die(mysqli_error($con));
 while($row = mysqli_fetch_array($result))
   if($row['Tables_in_school'] == $table)
	 return;
 mysqli_query($con, $sql) or die(mysqli_error($con));
}
/*
function connect() {
  global $dbserver, $dbusername, $dbpassword, $database;

  $con = mysql_connect($dbserver, $dbusername, $dbpassword)
     or die("Cannot connect to database server " . mysqli_error($con));
    mysql_select_db($database, $con)
     or die("Cannot select database" . mysqli_error($con));
  return $con;
}
*/
function connect() {
  global $dbserver, $dbusername, $dbpassword, $database;
	$con = mysqli_connect($dbserver, $dbusername, $dbpassword, $database);
  if (!$con) {
    die("Cannot connect to database server " . mysqli_error($con));
  }
  if (mysqli_connect_errno()) {
    die("Connect failed: ".mysqli_connect_errno()." : "
     . mysqli_connect_error());
  }
  return $con;
}

/*
function connect() {
  global $dbserver, $dbusername, $dbpassword, $database;
  $dbh = null;
  try {
    $dbh = new PDO("mysql:host=$dbserver;dbname=$database", "$dbusername", "$dbpassword");
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
  }
  return $dbh;
}
*/
/*
function msg_box($msg, $url, $urlname) {
  return "<table style='text-align:center;'>
             <tr><td><h3>$msg <a style='color:orange; text-decoration:none'
             href='$url'>$urlname</a></h3></td></tr></table>";
}
*/
function msg_box($msg, $url, $urlname) {
  return "<table style='text-align:center;'>
             <tr class='class1'><td><h3 class='sstyle6'>$msg</h3></td></tr>
			 <tr><td>
			 <form method='post' action='$url'>
			  <input type='submit' value='{$urlname}' onclick='document.form1.action.submit();'>
			 </form></td></tr></table>";
}
function my_redirect($url, $text) {
 echo "
   <html>
   <body>
    <form name='x' action='$url' method='post'>
     $text
    </form>
    <script language='javascript'>
      document.x.submit();
    </script>
   </body>
  </html>
  ";
}


function my_query() {
  global $con;
  $temp = array();
  $arg_list = func_get_args();
  $result = mysqli_query($con, $arg_list[0]) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    if (func_num_args() > 4) {
      $temp[$row[$arg_list[1]]] =
       $row[$arg_list[2]] . " " . $row[$arg_list[3]] . " " . $row[$arg_list[4]];
    } else if (func_num_args() > 3) {
      $temp[$row[$arg_list[1]]] =
       $row[$arg_list[2]] . " " . $row[$arg_list[3]];
    } else {
      $temp[$row[$arg_list[1]]] = $row[$arg_list[2]];
    }
  }
  return $temp;
}

function get_values($table, $field1, $field2, $field3) {
  global $con;
  $a = array();
  $sql="select $field1 from $table where $field2=$field3";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($result)) {
    $a[$field2] = $row[$field1];
  }
  return $a;
}
function get_value($table, $field1, $field2, $field3, $con) {
  $sql="select $field1 from $table where $field2 = '$field3'";
  //echo "$sql<br>";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  return $row[$field1];
}

function gen_insert_sql($table, $skip, $con) {
  $sql1 = "Insert into $table(";
  $sql2="describe $table";
  $result = mysqli_query($con, $sql2) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (($field[0] == 'id') || (in_array($field[0], $skip)))
          continue;
    $sql1 .= "{$field[0]}, ";
  }
  $sql1 = substr($sql1, 0, -2);
  $sql1 .= ") values(";

  $result = mysqli_query($con, $sql2) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result))  {
    if (($field[0] == 'id') || (in_array($field[0], $skip)))
          continue;
    //else if (eregi("_image", $field[0]))
    else if (strpos($field[0], "_image") !== false)
      $sql1 .= "'{$_FILES[$field[0]]['name']}', ";
    else $sql1 .= "'{$_REQUEST[$field[0]]}', ";
  }
  $sql1 = substr($sql1, 0, -2);
  $sql1 .= ")";
  return $sql1;
}
function gen_update_sql($table, $id, $skip, $con) {
  $sql="update $table set ";
  $sql1 = "show columns from $table";
  $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result1)) {
    if (($field[0] == 'id') || (in_array($field[0], $skip)))
      continue;
    //else if (eregi("_image", $field[0])) {
    else if (strpos($field[0], "_image") !== false) {
	  if(!empty($_FILES[$field[0]]['name']))
        $sql .= "$field[0] = '{$_FILES[$field[0]]['name']}', ";
    } else
      $sql .= "$field[0]='{$_REQUEST[$field[0]]}', ";
  }

  $sql = substr($sql, 0, -2);
  $sql .= " where id=$id";
  return $sql;
}
function gen_delete_sql($table, $id, $con) {
  return "delete from $table where id=$id";
}

function parse_enum($field) {
   $label = preg_replace(array('/enum/'), array(''), $field);
   $label = str_replace('(', '', $label);
   $label = str_replace(')', '', $label);
   $label = str_replace("'", '', $label);
   $arr = explode(",", $label);
   foreach($arr as $index => $value)
     $arr2[$value] = $value;
   return $arr2;
 }
/*
function parse_enum($field) {
  $label = ereg_replace('enum', '', $field);
  $label = str_replace('(', '', $label);
  $label = str_replace(')', '', $label);
  $label = str_replace("'", '', $label);
  $arr = explode(",", $label);
  foreach($arr as $index => $value)
    $arr2[$value] = $value;
  return $arr2;
}
*/
/*
function format_label($label) {
  $label = ereg_replace('_image', ' ', $label);
  $label = ereg_replace('_id', ' ', $label);
  $label = ereg_replace('_', ' ', $label);
  return ucwords(strtolower($label));
}
*/
function format_label($label) {
  $arr = array('_image', '_id');
  foreach ($arr as $term) {
    if (strpos($label, $term) !== false)
      $label = substr($label, 0, stripos($label, $term));
  }
  return ucwords(strtolower(str_replace('_', ' ', $label)));
}

function gen_list($table, $url, $first_col, $cols, $skip=array(), $sql, $con) {

  //Display Column titles
  echo "<thead><tr>";
  foreach($cols as $col) {
    if (in_array($col, $skip))
      continue;
    echo "<th>" . format_label($col). "</th>";
  }
  echo "</tr></thead><tbody>";

  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    $sql="describe $table";
    $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));

	if (mysqli_num_rows($result2) <= 0) {
       echo "<tr style='text-align:center;'>
         <td colspan='6'><h4>No Student Found</h4></td></tr></form></table>";
       exit;
     }
    while($field = mysqli_fetch_array($result2)) {

      if (in_array($field[0], $skip) || ($field[0] == 'id'))
        continue;

      echo "<td class='style2'>";
	  if ((!empty($first_col)) && ($first_col == $field[0])) {
        echo "<a href='$url?action=Edit&table=$table&id={$row['id']}'>";

		//Check if the first column is a reference column
		//if (eregi("_id", $field[0])) {
    if (strpos($field[0], "_id") !== false) {
      $t = substr($field[0], 0, stripos($field[0], "_id"));
		  if ($t == 'school')
		    $t = 'school';
		  if ($t == 'student') {
		    $name1 = get_value($t, 'admission_number', 'id', $row[$field[0]], $con);
		    $name1 .= ' ' . get_value($t, 'firstname', 'id', $row[$field[0]], $con);
		    $name1 .= ' ' . get_value($t, 'lastname', 'id', $row[$field[0]], $con);
		  }
      echo $name1;
		} else
		  echo $row[$field[0]];
		  echo "</a>";

    }
    //else if (eregi("_id", $field[0])) {
    else if (strpos($field[0], "_id") !== false) {
      $t = substr($field[0], 0, stripos($field[0], "_id"));

		  if ($t == 'school')
		    $t = 'school';

		  if ($t == 'student') {
		    $name = get_value($t, 'admission_number', 'id', $row[$field[0]], $con);
		    $name .= ' ' . get_value($t, 'firstname', 'id', $row[$field[0]], $con);
		    $name .= ' ' . get_value($t, 'lastname', 'id', $row[$field[0]], $con);
		  } else
		    $name = get_value($t, 'name', 'id', $row[$field[0]], $con);
        echo $name;
    } else
        echo $row[$field[0]];
      echo "</td>";
}
    echo "</tr>";
  }
  echo "</tbody>";
}

function generate_form($action, $url, $id, $table, $row, $skip, $referer, $find="school_id != 0", $con, $title=null) {

  echo "
   <form method='post' action='$url' name='form1' id='form1' enctype='multipart/form-data'>
    <input type='hidden' name='table' value='$table' />
    <input type='hidden' name='id' value='$id' />
    <table>
     <tr class='class1'><td colspan='2' class='class3'>";
  echo (isset($title)) ? $title : "$action $table";
  echo "
    </td></tr>
     <tr>
      <td>
       <table>
  ";

  $sql = "describe {$table}";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    if (in_array($field[0], $skip))
      continue;
    //if (eregi("_image", $field[0]))
    if (strpos($field[0], "_image") !== false)
      continue;
    echo "<tr><td>". format_label($field[0]) . "</td><td>";
    if ($field[1] == 'text')
      echo textarea($field[0], $row[$field[0]]);
    else if ($field[1] == 'date') {
      $date = empty($row[$field[0]]) ? date('Y-m-d') : $row[$field[0]];
     echo inputfield('id', $field[0], 'name',$field[0],'value', $date,'size','10','type','text');

    //} else if (eregi("_id", $field[0])) {
    } else if (strpos($field[0], "_id") !== false) {
      $t = substr($field[0], 0, stripos($field[0], "_id"));
	  $sql = "select * from $t $find order by id";
	  $arr = my_query($sql, 'id', 'name');

	  //Hack to support displaying a default Class when adding Students
	  if (($action == 'Add') && ($table == 'student') && ($t == 'class')) {
	    echo selectfield($arr, $field[0], $_SESSION['class_id']);
	  } else
        echo selectfield($arr, $field[0], $row[$field[0]]);
    //} else if (eregi("enum", $field[1])) {
    } else if (strpos($field[1], "enum") !== false) {
      echo selectfield(parse_enum($field[1]),$field[0], $row[$field[0]]);

    } else
      echo inputfield('name',$field[0],'value',$row[$field[0]], 'size', '30', 'type','text');
    echo "</td></tr>";
  }

  echo "</table>
        </td>
        <td style='vertical-align:top;'>
        <table>";

  $result = mysqli_query($con, "describe $table") or die(mysqli_error($con));
  while($field = mysqli_fetch_array($result)) {
    //if (!eregi("_image", $field[0]))
    if (strpos($field[0], "_image") === false)
      continue;
    else {
      echo "<tr><td>". format_label($field[0]) . "</td><td>";
      echo inputfield('name',$field[0],'value',$row[$field[0]],'type','file');
      echo "</td></tr>";
      if (($action=='Edit') || ($action =='View')) {
        echo "<tr><td><img src='upload/{$row[$field[0]]}' width='200'
          'height'></td></tr>";
      }
    }
  }
  echo "</table></td></tr>";

  echo "<tr>
         <td>
          <table>
           <tr>";

  if ($action == 'Delete') {
    echo "<td>".inputfield('name','action','value','Delete','type','submit')
    . "</td>";
  } else {
    $value = (($action == 'Edit Only') || ($action == 'Edit')) ? 'Update' : 'Insert';
    echo "<td>".inputfield('name','action','value',$value,'type','submit')
    ."</td>";

    if ($action != 'Edit Only') {
      echo "<td>".inputfield('name','action','value','Delete','type','submit')
      . "</td>";
    }
  }
  if (isset($referer))
    echo "<input name='REFERER' type='hidden' value='{$referer}'/>";

  echo "</tr></table></td></tr></table></form>";
}

function tr($arr) {
  $output = "<tr>";
  foreach($arr as $td) {
    $output .= "<td>$td</td>";
  }
  $output .= "</tr>";
  return $output;
}

function inputfield() {
  $numargs = func_num_args();
  if ($numargs < 2) die("textfield second argument is missing");

  $output = "<input ";
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

function selectfield($arr, $name, $default_id, $style="display:inline;", $code="") {
  $output = "<select name='$name' id='$name' style='$style' onchange='$code'>";
  foreach($arr as $id => $value) {
    if ($id == $default_id)
      $output .= "<option value='$id' selected='selected'>$value</option>";
    else
      $output .= "<option value='$id'>$value</option>";
  }
  $output .="</select>";
  return $output;
}

function upload_file($filename, $url) {
  if ($_FILES[$filename]['error'] != 4) {
  //Lets upload the file
    if ($_FILES[$filename]['error'] > 0) {
      switch($_FILES[$filename]['error']) {
        case 1: echo msg_box('File exceeded upload max_filesize',
          $url, 'OK'); break;
        case 2: echo msg_box('File exceeded max_file_size',
          $url, 'OK'); break;
        case 3: echo msg_box('File only partially uploaded',
          $url, 'OK'); break;
      }
      exit;
    } elseif ($_FILES[$filename]['type']
      != ('image/jpeg' || 'image/gif' || 'image/png')) {
      echo msg_box('Problem: file is not an image', $url, 'OK');
      exit;
    } else {
      $upfile = "upload/". $_FILES[$filename]['name'];
      if(is_uploaded_file($_FILES[$filename]['tmp_name'])) {
        if(!move_uploaded_file($_FILES[$filename]['tmp_name'], $upfile)) {
          echo msg_box('Problem: Could not move file to destination directory', $url, 'OK');
          exit;
        }
      } else {
        echo msg_box("Problem: Possible file upload attack. Filename: " .
          $_FILES[$filename]['name'], $url, 'OK');
        exit;
      }
    }
  }
}

function calc_age($curr_secs, $prev_secs) {
  $secs = $curr_secs - $prev_secs;


  $years = floor($secs / 31449600);
  $secs = $secs % 31449600;

  //1 year = 52 weeks
  $weeks = floor($secs / 604800);
  $secs = $secs % 604800;

  $days = floor($secs / 86400);
  $secs = $secs % 86400;

  $hours = floor($secs / 3600);
  $secs = $secs % 3600;

  $mins = floor($secs / 60);
  $secs = $secs % 60;


  $temp = 0;

  if ($years > 0) {
    if ($years == 1) {
      $temp = "$years year ";
    } else {
      $temp = "$years years ";
    }
  }
  else if ($weeks > 0) {
    if ($weeks == 1) {
	$temp = "$weeks week ";
    } else {
      $temp = "$weeks weeks ";
    }
  } else if ($days > 0) {
    if ($days == 1) {
      $temp = "$days day ";
    } else {
      $temp = "$days days ";
    }
  }

  /*
  elseif ($hours > 0) {
    if ($hours == 1) {
      $temp = "$hours hour ";
    } else {
        $temp = "$hours hours ";
    }
  } elseif ($mins > 0) {
    if ($mins == 1) {
      $temp = "$mins min ";
    } else {
      $temp = "$mins mins ";
    }
  } else {
    if (($secs == 1) || ($secs == 0)) {
      $temp = "$secs second ";
    } else {
      $temp = "$secs seconds ";
    }
  }
  */
  return $temp;
}

function make_date($y, $m, $d) {
  if ($d < 10) {
    $d = "0$d";
  }
  if ($m < 10) {
    $m = "0$m";
  }
  return "$y-$m-$d";
}

function is_leap_year($y) {
  if (($y % 400) == 0) {
    return 1;
  } elseif (($y % 100) == 0) {
    return 0;
  } elseif (($y % 4) == 0) {
    return 1;
  } else {
    return 0;
  }
}
function generate_menu($heading, $menu) {
?>
  <li><?=$heading?></li>
  <li>
   <ul>
   <?php
    foreach($menu as $url => $name) {
      echo "<li><a href=\"$url\">$name</a></li>\n";
    }
   ?>
   </ul>
  </li>
<?php
}

?>
