<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
require_once "ui.inc";
require_once "util.inc";
require_once "school.inc";

$con = connect();
$position = array();


$user = array('Administrator','Proprietor', 'Exams');
if (!user_type($_SESSION['uid'], $user, $con)) {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
  echo msg_box('Access Denied!', 'index.php?action=logout', 'Continue');
  exit;
}

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == "Print")) {
  print_header('Class Result', 'class_result.php', '', $con);
} else {
  main_menu($_SESSION['uid'],
    $_SESSION['firstname'] . " " . $_SESSION['lastname'], $con);
}

//Make sure that Session/Term/Class has been created and
 //that the session variables representing them have been set
 check_session_variables('report_card.php', $con);

if (isset($_REQUEST['action']) &&
  (($_REQUEST['action'] == 'Generate') || ($_REQUEST['action'] == 'Print'))) {
  $sql="select s.id, s.name from subject s join class c on
      s.class_type_id = c.class_type_id where c.id = {$_SESSION['class_id']}
	  and c.school_id={$_SESSION['school_id']} order by s.id";

  $result = mysqli_query($con, $sql) or die(mysqli_error($con));

  if (mysqli_num_rows($result) == 0) {
    echo msg_box("No subject has been registered for
      this class", 'class_result.php', 'Back');
    exit;
  }
  $sub_count = mysqli_num_rows($result);

  $term_array = get_terms($_SESSION['session_id'], $_SESSION['term_id']);
   echo "
    <div class='class1'>
	<h3 class='sstyle1' style='display:inline;'>Class Result</h3>";

   if ($_REQUEST['action'] == 'Generate') {
     echo "<a style='cursor:hand;'; onclick='window.open(\"class_result.php?action=Print&term_id={$_SESSION['term_id']}&class_id={$_SESSION['class_id']}\", \"smallwin\", \"width=900,height=400,status=yes,resizable=yes,menubar=yes,toolbar=yes,scrollbars=yes\");'><img src='images/icon_printer.gif'></a>
    ";
   }
   $width = ($sub_count < 3) ? 100 : 238;
   echo "
     </div>
	 <table style='table-layout:auto; width:{$width}em;' class='tablesorter'>
	  <thead>
       <tr>
        <th>Student</th>
		<th>Total</th>
        <th>Average</th>
        <th>Position</th>
   ";
   $sql="select s.name from subject s join class c on
     s.class_type_id = c.class_type_id where c.id = {$_SESSION['class_id']}
	 and c.school_id={$_SESSION['school_id']} order by s.id";

   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   while ($row = mysqli_fetch_array($result)) {
     echo "<th style='width:10em; text-align:center;'>{$row['name']}</th>";
   }
   ?>
     <th>Student</th>
	 </tr>
    </thead>
	<tbody>
   <?php

   //Fetch students in that class
   $sql="select * from student s join student_temp_{$_SESSION['sessid']} st on s.id = st.student_id
    where st.class_id = {$_SESSION['class_id']} and s.school_id={$_SESSION['school_id']} order by s.admission_number";

   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $total_score_everybody = 0;
   while ($row = mysqli_fetch_array($result)) {
     echo " <tr>
             <td>
              <a href='report_card.php?student_name={$row['admission_number']}_{$row['firstname']}_{$row['lastname']}&action=Submit'>{$row['admission_number']}
               {$row['firstname']}
               {$row['lastname']}</a></td>
     ";
     /*** First time running to display Total, Average, Position***/
     $total_score = 0;
     //Fetch all subjects in that class
	 $sql1="select s.id, s.name from subject s join class c on s.class_type_id = c.class_type_id
       where s.school_id={$_SESSION['school_id']} and c.id={$_SESSION['class_id']} order by s.id";
     $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
     while ($row1 = mysqli_fetch_array($result1)) {
       $subject_score = 0;

       //If it is for cummulative terms
       if ($_SESSION['term_id'] == '0') {
         foreach($term_array as $term_id => $term_name) {
		   $sql2="select * from student_subject_{$_SESSION['sessid']} where
             session_id = {$_SESSION['session_id']}
	         and class_id = {$_SESSION['class_id']}
             and term_id = $term_id
             and admission_number= {$row['admission_number']}
             and subject_id = {$row1['id']} order by id";

           $test = 0;
	       $exam = 0;
           $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

	       if (mysqli_num_rows($result2) > 0) {
             while($row2 = mysqli_fetch_array($result2)) {
	           $test = $row2['test'];
	           $exam = $row2['exam'];
	           $subject_score += $test + $exam;
	         }
	       } else {
	         $subject_score += $test + $exam;
           }
         }
	     $total_score += $subject_score;
       }
       //For only one term
       else {
         //Fetch students records for this subject
         $sql2="select * from student_subject_{$_SESSION['sessid']} where
          session_id = {$_SESSION['session_id']}
	      and class_id = {$_SESSION['class_id']}
          and term_id = {$_SESSION['term_id']}
          and admission_number= {$row['admission_number']}
          and subject_id = {$row1['id']} order by id";

         $test = 0;
	     $exam = 0;
	     $subject_score_display = "-";
         $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));
	     if (mysqli_num_rows($result2) > 0) {
           $row2 = mysqli_fetch_array($result2);
	       $test = $row2['test'];
	       $exam = $row2['exam'];
	       $subject_score = $test + $exam;
           $total_score += $subject_score;
		   $subject_score_display = $subject_score;
	     }
       }
     }
     $sql="select count(*) as 'count' from student_subject_{$_SESSION['sessid']} where
         admission_number={$row['admission_number']}
         and session_id={$_SESSION['session_id']}
         and term_id={$_SESSION['term_id']}
		 and class_id={$_SESSION['class_id']}";

     $result_count = mysqli_query($con, $sql) or die(mysqli_error($con));
     $subject_count = mysqli_fetch_array($result_count);

     if ($subject_count['count'] == '0') //To avoid division by zero
       $average = $total_score;
     else
       $average = $total_score/$subject_count['count'];

     echo "<td>$total_score</td>";
     echo "<td>" . number_format($average,2) ."</td>";
     echo "<td><div id='p_{$row['id']}'>&nbsp;</div></td>";

	 $position[$row['id']] = $average;
	 $total_score_everybody += $average;


    /*** Second time running to display score of subjects***/
    //Fetch all subjects in that class
	$sql1="select s.id, s.name from subject s join class c on s.class_type_id = c.class_type_id
       where s.school_id={$_SESSION['school_id']} and c.id={$_SESSION['class_id']} order by s.id";
    $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
    while ($row1 = mysqli_fetch_array($result1)) {
      $subject_score = 0;

      //If it is for cummulative terms
      if ($_SESSION['term_id'] == '0') {
        foreach($term_array as $term_id => $term_name) {
		  $sql2="select * from student_subject_{$_SESSION['sessid']} where
            session_id = {$_SESSION['session_id']}
	        and class_id = {$_SESSION['class_id']}
            and term_id = $term_id
            and admission_number= {$row['admission_number']}
            and subject_id = {$row1['id']} order by id";

          $test = 0;
	      $exam = 0;
          $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

	      if (mysqli_num_rows($result2) > 0) {
            while($row2 = mysqli_fetch_array($result2)) {
	          $test = $row2['test'];
	          $exam = $row2['exam'];
	          $subject_score += $test + $exam;
	        }
	      } else {
	        $subject_score += $test + $exam;
          }
        }
	  }
     else {
       //Fetch students records for this subject
       $sql2="select * from student_subject_{$_SESSION['sessid']} where
         session_id = {$_SESSION['session_id']}
	     and class_id = {$_SESSION['class_id']}
         and term_id = {$_SESSION['term_id']}
         and admission_number= {$row['admission_number']}
         and subject_id = {$row1['id']} order by id";

       $test = 0;
	   $exam = 0;
	   $subject_score_display = "-";

       $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));
	   if (mysqli_num_rows($result2) > 0) {
         $row2 = mysqli_fetch_array($result2);
	     $test = $row2['test'];
	     $exam = $row2['exam'];
	     $subject_score = $test + $exam;
         $subject_score_display = $subject_score;
	   }
     }
	 echo "<td style='text-align:center;'>$subject_score_display</td>";
    }
	echo "
	  <td>
	   <a href='report_card.php?student_name={$row['admission_number']}_{$row['firstname']}_{$row['lastname']}&action=Submit'>{$row['admission_number']} {$row['firstname']} {$row['lastname']}</a></td>
     </tr>";
   }
   /*** End of Second Run ***/

   echo "</tbody></table>";
   require_once "tablesorter_footer.inc";

   echo "<script type='text/javascript'>";
   if ($total_score_everybody == 0) {
     $i='0';
     while (list($key, $val) = each($position)) {
       echo "document.getElementById('p_$key').innerHTML='$i';";
     }
   } else {
     arsort($position);
     reset($position);


     $i = 1;
     while (list($key, $val) = each($position)) {
       echo "document.getElementById('p_$key').innerHTML=$i;";
       $i++;
     }
   }
   echo "</script>";
   exit;
 }


main_footer();
?>
