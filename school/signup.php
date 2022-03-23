<?php
session_start();
error_reporting(E_ALL);

//$sessid = time()+60*60*24*30;
$sessid = mt_rand();

require_once '../admin/acc.inc';
require_once '../admin/subscription_tools.inc';
require_once 'util.inc';
require_once 'ui.inc';
require_once 'email_messages.inc';
require_once 'backup_restore.inc';

$con = connect();

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Submit')) {

  $msg = "";
  if (isset($_REQUEST['name']))
    $msg .= "<input type='hidden' name='old_name' value='{$_REQUEST['name']}'>";
  if (isset($_REQUEST['u']))
    $msg .= "<input type='hidden' name='old_u' value='{$_REQUEST['u']}'>";

  if (empty($_REQUEST['name'])) {
    $msg .= "<input type='hidden' name='err_msg'
      value='Please enter your School Name'>";
    my_redirect('../signup_error_page.php',$msg);
    exit;
  }

  if (empty($_REQUEST['u'])) {
    $msg .= "<input type='hidden' name='err_msg'
      value='Please enter your email address'>";
    my_redirect('../signup_error_page.php', $msg);
    exit;
  }

  if (!validate_email($_REQUEST['u'])) {
    $msg .= "<input type='hidden' name='err_msg'
      value='Please enter a correct email address'>";
    my_redirect('../signup_error_page.php', $msg);
    exit;
  }

  if (empty($_REQUEST['p1'])) {
    $msg .= "<input type='hidden' name='err_msg'
      value='Please enter your password'>";
    my_redirect('../signup_error_page.php', $msg);
    exit;
  }

  //Check if this School already exists
  $sql="select * from school where name='{$_REQUEST['name']}'";
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {

    $msg .= "<input type='hidden' name='err_msg'
      value='This School Name has already been taken. Please choose another'>";
    my_redirect('../signup_error_page.php', $msg);
    exit;

  }

  //Add School to database
  $sql="insert into school(name, signup_date, email)
    values('{$_REQUEST['name']}', '" . date('Y-m-d') . "',
    '{$_REQUEST['u']}')";

  mysqli_query($con, $sql) or die(mysqli_error($con));
  $_SESSION['school_id'] = mysqli_insert_id($con);

   //Add School to School Directory if not already there
  $sql="select * from directory where school_name = '{$_REQUEST['name']}'";
  if (mysqli_num_rows(mysqli_query($con, $sql)) <= 0) {
    $sql="insert into directory(school_name, email) values ('{$_REQUEST['name']}', '{$_REQUEST['u']}')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
  }

  //Insert i
  $sql="insert into user(name, passwd, school_id) values('{$_REQUEST['u']}',
    sha1('{$_REQUEST['p1']}'), {$_SESSION['school_id']})";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $_SESSION['uid'] = mysqli_insert_id($con);  #Store a session variable
  $_SESSION['username'] = $_REQUEST['u'];

  //Give this user proprietor access. 7 is proprietor access
  $sql="insert into user_permissions(uid, pid) values({$_SESSION['uid']}, 7)";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  //Create school acccount in General Ledger
  $account_id = add_account($_REQUEST['name'], '', '',
    ACCOUNT_RECEIVABLE, 1, date('Y-m-d'), 0, 0, $con);

  //Update school account information
  $sql="update school set account_id = '$account_id'
    where id='{$_SESSION['school_id']}'";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="update user set school_id={$_SESSION['school_id']}
    where id={$_SESSION['uid']}";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $_SESSION['firstname'] = $_REQUEST['u'];
  $_SESSION['lastname'] = $_REQUEST['u'];

  subscribe($_REQUEST['name'], date('Y-m-d'), '1 year', date('Y-m-d'),
   '1 month free subscription', '0', $con);

  check_subscription($_SESSION['school_id'], $con);

  /*** STEP 1. Add specific class_types for each school
   * e.g., Nursery, Primary, JSS, SSS
   ***/
  $sql ="insert into class_type(name, description, school_id)
   value ('Nursery', 'Nursery', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_type_id1 = mysqli_insert_id($con);

  $sql ="insert into class_type(name, description, school_id)
   value ('Primary', 'Primary', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_type_id2 = mysqli_insert_id($con);

  $sql ="insert into class_type(name, description, school_id)
   value ('JSS', 'Junior Secondary School', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_type_id3 = mysqli_insert_id($con);

  $sql ="insert into class_type(name, description, school_id)
   value ('SSS', 'Senior Secondary School', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $class_type_id4 = mysqli_insert_id($con);

  /***STEP 2. Insert 4 sample classes
   * e.g., Nursery 1, Class1, JSS1A, SSS1A
   ***/
  $sql="insert into class(name, class_type_id, school_id)
   value('Nursery 1', '$class_type_id1', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="insert into class(name, class_type_id, school_id)
   value('Class 1', '$class_type_id2', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="insert into class(name, class_type_id, school_id)
   value('JSS1A', '$class_type_id3', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  $sql="insert into class(name, class_type_id, school_id)
   value('SSS1A', '$class_type_id4', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));


  /*** STEP 3. Insert 2 subjects to each sample class
   * Maths and English
   ***/
  $sql="insert into subject(name, class_type_id, school_id)
   value('Mathematics', '$class_type_id1', '{$_SESSION['school_id']}'),
   ('English Language', '$class_type_id1', '{$_SESSION['school_id']}'),

   ('Mathematics', '$class_type_id2', '{$_SESSION['school_id']}'),
   ('English Language', '$class_type_id2', '{$_SESSION['school_id']}'),

   ('Mathematics', '$class_type_id3', '{$_SESSION['school_id']}'),
   ('English Language', '$class_type_id3', '{$_SESSION['school_id']}'),

   ('Mathematics', '$class_type_id4', '{$_SESSION['school_id']}'),
   ('English Language', '$class_type_id4', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  /*** STEP 4.Insert Grade Settings. Maths and English ***/

  $sql = "insert into grade_settings(name, low, high, school_id) value
   ('A', '75','100', '{$_SESSION['school_id']}'),
   ('B', '60', '74', '{$_SESSION['school_id']}'),
   ('C', '50', '59', '{$_SESSION['school_id']}'),
   ('D', '45', '49', '{$_SESSION['school_id']}'),
   ('E', '40', '44', '{$_SESSION['school_id']}'),
   ('F', '0', '39',  '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  /*** STEP 5. Insert Non Academic Settings ***/
  $sql = "insert into non_academic(name,  school_id) value
    ('Handwriting',    '{$_SESSION['school_id']}'),
    ('Fluency',        '{$_SESSION['school_id']}'),
    ('Punctuality',    '{$_SESSION['school_id']}'),
    ('Reliability',    '{$_SESSION['school_id']}'),
    ('Neatness',       '{$_SESSION['school_id']}'),
    ('Politeness',     '{$_SESSION['school_id']}'),
    ('Honesty',        '{$_SESSION['school_id']}'),
    ('Self Control',   '{$_SESSION['school_id']}'),
    ('Spirit of Cooperation', '{$_SESSION['school_id']}'),
    ('Sense Of Responsibility', '{$_SESSION['school_id']}'),
    ('Attentiveness In Class', '{$_SESSION['school_id']}'),
    ('Perseverance', '{$_SESSION['school_id']}')";
  mysqli_query($con, $sql) or die(mysqli_error($con));

  /*** STEP 6. Insert a default Session***/
  $sql = "insert into session(name, begin_date, end_date, school_id)
   value('" . (date('Y')-1) . "/" . date('Y') . "','"
    . date('Y-m-d') . "','". date('Y-m-d') . "',
    '{$_SESSION['school_id']}')";

  mysqli_query($con, $sql) or die(mysqli_error($con));
  $session_id = mysqli_insert_id($con);

  /*** STEP 7. Insert a default Term ***/
  $sql = "insert into term(name, begin_date, end_date, session_id,
   times_school_open, school_id) value
   ('First', '" . date('Y-m-d'). "', '" . date('Y-m-d') . "', '$session_id',
    '0', '{$_SESSION['school_id']}'),
   ('Second', '" . date('Y-m-d'). "', '" . date('Y-m-d') . "', '$session_id',
    '0', '{$_SESSION['school_id']}'),
   ('Third', '" . date('Y-m-d'). "', '" . date('Y-m-d') . "', '$session_id',
    '0', '{$_SESSION['school_id']}') ";
  mysqli_query($con, $sql) or die(mysqli_error($con));
  $term_id = mysqli_insert_id($con);


  /***STEP 9: Backup Session/Term/Class Information into a file***/
  if(!mkdir("data/{$_SESSION['school_id']}", 0, true)) {
    die("Failed to create folder {$row['id']}");
  }
  if(!chmod("data/{$_SESSION['school_id']}", 0777))
    die("Failed to change mode to data/{$row['id']}");



  $sql="select * from session where school_id={$_SESSION['school_id']}";
  $result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
  while($row1 = mysqli_fetch_array($result1)) {

      $sql = "select * from class where school_id={$_SESSION['school_id']}";
      $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
      while($row3 = mysqli_fetch_array($result3)) {
	    $sql="create table student_temp_{$sessid}(
			  id integer auto_increment primary key,
			  student_id integer,
			  class_id integer,
			  first_term_times_present varchar(100),
			  first_term_times_absent varchar(100),
			  second_term_times_present varchar(100),
			  second_term_times_absent varchar(100),
			  third_term_times_present varchar(100),
			  third_term_times_absent varchar(100)
			 )";
	    mysqli_query($con, $sql) or die(mysqli_error($con));


	    $sql="create table student_subject_{$sessid}(
			  id integer auto_increment primary key,
			  session_id integer,
			  term_id integer,
			  class_id integer,
			  admission_number varchar(100),
			  subject_id integer,
			  test float,
			  exam float,
			  school_id integer
			 )";
		 mysqli_query($con, $sql) or die(mysqli_error($con));

		$sql="create table student_comment_{$sessid}(
			  id integer auto_increment primary key,
			  session_id integer,
			  term_id integer,
			  class_id integer,
			  admission_number varchar(100),
			  teacher text,
			  principal text,
			  school_id integer
			 )";
		mysqli_query($con, $sql) or die(mysqli_error($con));

		$sql="create table student_non_academic_{$sessid}(
			   id integer auto_increment primary key,
			   admission_number varchar(100),
			   session_id integer references session,
			   term_id integer references term,
			   class_id integer references class,
			   non_academic_id integer references non_academic,
			   score varchar(100),
			   school_id integer
		  )";
		mysqli_query($con, $sql) or die(mysqli_error($con));

		$sql="CREATE TABLE student_fees_{$sessid}(
			  id int(11) NOT NULL auto_increment primary key,
			  session_id int(11) default NULL,
			  term_id int(11) default NULL,
			  class_id int(11) default NULL,
			  admission_number varchar(100),
			  date date,
			  amount_paid varchar(100),
			  school_id integer
			)";
		mysqli_query($con, $sql) or die(mysqli_error($con));

        /*** STEP 8. Insert default Fee for a Class***/
        $sql="create table fee_class_{$sessid}(
		id integer auto_increment primary key,
		session_id integer,
		term_id integer,
		class_id integer references class,
		amount varchar(100),
		school_id integer
	   )";
	   mysqli_query($con, $sql) or die(mysqli_error($con));

	   $sql="select * from term where session_id={$row1['id']}";
	   $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
	   while($row2 = mysqli_fetch_array($result2)) {
         $sql="insert into fee_class_{$sessid}(session_id, term_id, class_id, school_id, amount) values
         ({$row1['id']}, {$row2['id']}, {$row3['id']}, {$_SESSION['school_id']}, '0')";
	     mysqli_query($con, $sql) or die(mysqli_error($con));
	   }

       //Backup up Session/Class information
		save_session($sessid, $_SESSION['school_id'], $row1['id'], $row3['id'], $con);
		close_acadbase_session($sessid, $_SESSION['school_id'], $row1['id'], $row3['id'], $con);
      } //end class
  } //end session

  /*** STEP 10. Get the email message and send ***/
  $email_message = get_signup_notification($_REQUEST['name'],
   $_REQUEST['u'], $_REQUEST['p1']);

  send_mail($_SESSION['school_id'], $_REQUEST['u'], "Welcome to Acadbase",
    $email_message, $con);

  my_redirect('student.php', '');
  exit;
}
