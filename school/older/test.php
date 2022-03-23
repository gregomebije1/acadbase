<?php 
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
  
  if ($years > 0) {
    if ($years == 1) {
      $temp = "$years year ";
    } else {
      $temp = "$years years ";
    }
  } else if ($months > 0) {
    if ($months == 1) {
      $temp = "$months month ";
    } else {
      $temp = "$months months ";
    }
  } else if ($weeks > 0) {
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
  } elseif ($hours > 0) {
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
  return $temp;
}

 $today = gettimeofday();
 echo $today['sec'] . "<br>";
 $data = explode("-", '1985-03-15');
 print_r($data);
 
 $date_of_birth = mktime(0, 0, 0, $data[1], $data[2], $data[0]);
 echo $date_of_birth . "<br>";
 $datetime = calc_age($today['sec'], $date_of_birth);
 echo $datetime;
 
 //2011-06-24

 /*echo date("M-d-Y", mktime(0, 0, 0, 13, 1, 1997));
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 1998));
echo date("M-d-Y", mktime(0, 0, 0, 1, 1, 98));
*/
?>
 