<?php
session_start();
session_unset();  //Unset all of the session variables
session_destroy();

include_once('../config.inc');
global $dbserver, $dbusername, $dbpassword, $database;

$back = "<a href='' onClick='history.back();'>Back</a>";
if ($_REQUEST['action'] == 'Install') {
 if (empty($_REQUEST['dbname']) || empty($_REQUEST['dbusername'])
    || empty($_REQUEST['dbpassword1'])) {
   echo "Please enter correct Database Information details $back_link";
   exit;
  } else {
    if ($_REQUEST['dbpassword1'] !== $_REQUEST['dbpassword2']) {
	  echo "Passwords are not equal $back_link";
    }
    $con = mysqli_connect($_REQUEST['dbhost'], $_REQUEST['dbusername'], $_REQUEST['dbpassword1'],
       $_REQUEST['dbname']);
     if (!$con) {
       die("Cannot connect to database server " . mysqli_error($con));
     }
     if (mysqli_connect_errno()) {
       die("Connect failed: ".mysqli_connect_errno()." : "
        . mysqli_connect_error());
     }
     return $con;

    ####Store the values in the config file####
    if (file_exists("../config.inc")) {
      unlink("../config.inc");
    }
    $fp = fopen("../config.inc", "w");
    $stuff="<?php\n
     \$dbserver = '{$_REQUEST['dbhost']}';\n
     \$dbusername='{$_REQUEST['dbusername']}';\n
     \$dbpassword='{$_REQUEST['dbpassword1']}';\n
     \$database= '{$_REQUEST['dbname']}';\n
     ?>";
    fwrite($fp, "$stuff\n");
    fclose($fp);

    echo "Database configuration stored in config.inc<br><br>";

	echo "Droping existing tables<br>";
    $tables = array('audit_trail', 'account', 'account_type', 'journal',
	 'log', 'user', 'permissions', 'user_permissions',
	 'school', 'school_account', 'session', 'term', 'class_type', 'class', 'student','subject', 'settings',
	 'grade_settings', 'non_academic');

    foreach($tables as $table) {
      $sql="drop table if exists $table";
	  mysqli_query($con, $sql);
    }
    unset($tables);
	$tables['audit_trail'] = "
    create table audit_trail(
     id int(11) auto_increment primary key,
     dt datetime,
     staff_id varchar(100),
     descr text,   /* Description of the transaction */
     ot text,  /* Can contain journal ID, or room ID*/
     dt2 date
    )";

	$tables['account'] = "
	CREATE TABLE account (
	  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  account_type_id int(11) NOT NULL,
	  entity_id int(11) NULL,
	  name varchar(100) NOT NULL,
	  code varchar(100) NULL,
	  description varchar(100) NULL,
	  d_created DATE NULL,
	  parent int default 0 not null,
	   children int default 0 not null
	)";

	$tables['account_type'] = "
    CREATE TABLE account_type (
      id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name varchar(100) NOT NULl)";

    $tables['journal'] = "
	 CREATE TABLE journal (
	  id int(11) NOT NULL auto_increment PRIMARY KEY,
	  account_id int(11) NOT NULL,
	  entity_id int(11) NOT NULL,
	  d_entry date NOT NULL,
	  descr text NOT NULL,
	  t_type varchar(100) NOT NULL,
	  amt varchar(100) NOT NULL,
	  folio varchar(100) NOT NULL)";

	$tables['log'] = "
	  CREATE TABLE log (
      id integer auto_increment primary key,
      dt_login datetime,
	  dt_logout datetime,
	  uid integer
	 )";

    $tables['user'] = "
     CREATE TABLE user (
      id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name varchar(100) NOT NULL,
      passwd varchar(100) NOT NULL,
      firstname varchar(100),
      lastname varchar(100),
	  school_id int(11) NOT NULL
    )";

	$tables['permissions'] = "
     create table permissions (
     id int(11) auto_increment primary key,
     name varchar(100)
    )";


	$tables['user_permissions'] = "
     create table user_permissions (
      id int(11) auto_increment primary key,
      uid int(11),
      pid int(11),
      school_id integer
     )";


    $tables['school'] = "
     create table school (
      id integer auto_increment primary key,
      name varchar(300),
      address text,
      phone varchar(100),
      email varchar(100),
      website varchar(100),
      logo varchar(100),
	  other_information text,
      account_id integer,
      signup_date date
     )";

    $tables['school_account'] = "
     create table school_account (
      id integer auto_increment primary key,
      school_id integer,
      years_of_subscription integer,
      payment_date date,
      activation_date date,
      expiry_date date,
      status varchar(100)
     )";

    $tables['session'] = "
     create table session (
      id integer auto_increment primary key,
      name varchar(100),
      begin_date date,
      end_date date,
	  school_id integer
     )";

    $tables['term'] = "
     create table term (
      id integer auto_increment primary key,
      name enum('FIRST', 'SECOND', 'THIRD'),
      begin_date date,
      end_date date,
      session_id integer,
	  times_school_open varchar(100),
	  school_id integer
     )";

	$tables['class_type'] = "
     create table class_type (
      id integer auto_increment primary key,
      name varchar(100),
      description varchar(100),
	  school_id integer
     )";

    $tables['class'] = "
     create table class (
      id integer auto_increment primary key,
      name varchar(100),
      class_type_id integer,
	  school_id integer
     )";

     $tables['student'] = "
     create table student (
      id integer auto_increment primary key,
      admission_number varchar(100),
      date_of_admission date,
      firstname varchar(100),
      lastname varchar(100),
	  date_of_birth date,

      class_id integer,
      gender enum('Male','Female'),
      house varchar(100),
	  state_of_origin varchar(100),

      scholarship varchar(100),
	  parent_guardian_name varchar(100),
      parent_guardian_email varchar(100),
	  parent_guardian_phone varchar(100),
	  parent_guardian_address text,
	  any_other_information text,
	  passport_image text,

	  school_id integer
     )";

    $tables['subject'] = "
     create table subject (
      id integer auto_increment primary key,
      name varchar(100),
      class_type_id varchar(100),
	  school_id integer
     )";

	 $tables['grade_settings'] = "
	  create table grade_settings(
      id integer auto_increment primary key,
      name varchar(100),
	  low varchar(100),
	  high varchar(100),
	  school_id integer
     )";

    $tables['non_academic'] = "
	  create table non_academic(
      id integer auto_increment primary key,
      name varchar(100),
	  school_id integer
     )";

    $tables['settings'] = "
     CREATE TABLE settings (
      id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name varchar(100) default NULL,
      value varchar(100) default NULL
     )";

      foreach($tables as $name => $sql)
        if (mysqli_query($con, $sql))
         echo " $name table successfully created<br>";
        else {
          echo "Problem creating $name table";
	  exit;
        }
	unset($tables);

	$tables[] = "insert into permissions(name) values('Administrator')";
	$tables[] = "insert into permissions(name) values('Accounts')";
	$tables[] = "insert into permissions(name) values('Expenditure')";
	$tables[] = "insert into permissions(name) values('Exams')";
	$tables[] = "insert into permissions(name) values('Records')";
	$tables[] = "insert into permissions(name) values('Student')";
	$tables[] = "insert into permissions(name) values('Proprietor')";

    $tables[] = "insert into user_permissions(uid, pid)
	 values (1, 1)";

	$tables[] = "insert into user(name, passwd) values ('admin', sha1('@c@db@se'))";

	/*Accounts with debit balances have odd acc_type_id
     Accounts with credit balances have even acc_type_id
    */
    $tables[] = "INSERT INTO `account_type` (id, name) VALUES
     (1, 'Fixed Assets'),
     (2, 'Account Payable'),
     (3, 'Account Receivable'),
     (4, 'Other Currrent Liabilities'),
     (5, 'Other Currrent Assets'),
     (6, 'Long Term Liabilities'),
     (7, 'Expenses'),
     (8, 'Equity'),
     (9, 'Sales Returns and Allowances'),
     (10, 'Income'),
     (11, 'Opening Stock'),
     (12, 'Purchases Returns and Allowances'),
     (13, 'Purchases'),
     (14, 'Closing Stock')";

     /*Create basic accounts*/

    $tables[] = "insert into
      account(account_type_id, entity_id, name, d_created) values
      (5,   1, 'Cash',   CURRENT_DATE()),
      (5,   1, 'Petty Cash',   CURRENT_DATE()),
	  (5,   1, 'Bank', CURRENT_DATE()),
      (10,  1, 'Sales',  CURRENT_DATE()),
      (5,   1, 'Inventory',  CURRENT_DATE()),
      (4,   1, 'VAT', CURRENT_DATE()),
      (4,   1, 'WHT', CURRENT_DATE())";


	foreach($tables as $sql)
      if (!mysqli_query($con, $sql)) {
	    echo "Problem inserting data into table";
	    exit;
	  }
  	unset($tables);

	echo "<h3>Installtion successfully completed</h3>";
	echo "Continue to <a href='../../index.html'>HomePage</a>";
	mysqli_close($con);
  }
}
?>
