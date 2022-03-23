<html>
<head><title>installing AcadPro</title></head>
<body>
 <p>Installing AcadPro</p>
 <form method='POST' action='install.php'>
  <fieldset>
   <legend>Database Information</legend>
	<table>
	 <tr>
          <td colspan='2'>
		  Please make sure a database user exist exist 
           with the provided username</td>
         </tr>
	    <tr><td>Database Host</td><td><input type='text' name='dbhost' 
          value='localhost'></td></tr>
         <tr>
          <td>Database Name</td>
          <td><input type='text' name='dbname' value='school'></td>
         </tr>
         <tr>
          <td>Database Username</td>
          <td><input type='text' name='dbusername' value='school'></td>
         </tr>
         <tr>
          <td>Database Password</td>
          <td><input type='password' name='dbpassword1' value='password'></td>
         </tr>
	     <tr>
          <td>Renter Password</td>
          <td><input type='password' name='dbpassword2' value='password'></td>
         </tr>
		 <!--
		 <tr>
		  <td>Session</td>
          <td>
		  <fieldset>
		  <legend>Details</legend>
		   <table>
		    <tr><td>Name</td><td><input type='text' name='session_name'></td></tr>
		    <tr><td>Start Date</td><td><input type='text' name='session_start_date' value='<?php echo date('Y-m-d'); ?>'></td></tr>
			<tr><td>End Date</td><td><input type='text' name='session_end_date'  value='<?php echo date('Y-m-d'); ?>'></td></tr>
		   </table>
		  </fieldset>
		  </td>
         </tr>
	     <tr>
		  <td>Term</td>
          <td>
		  <fieldset>
		  <legend>Details</legend>
		   <table>
		    <tr><td>Name</td><td><input type='text' name='term_name'></td></tr>
		    <tr><td>Start Date</td><td><input type='text' name='term_start_date'  value='<?php echo date('Y-m-d'); ?>'></td></tr>
			<tr><td>End Date</td><td><input type='text' name='term_end_date'  value='<?php echo date('Y-m-d'); ?>'></td></tr>
			<tr><td>Times School Open</td><td><input type='text' name='times_school_open'></td></tr>
		   </table>
		  </fieldset>
		  </td>
         </tr>
		 <tr>
		  <td>Class</td>
		  <td>
		   <fieldset>
		   <legend>Details</legend>
		   <table>
		    <tr>
		     <td><input type='text' name='class_name'></td>
		     <td>
			  <select name='type'>
		       <option value='JSS'>JSS</option>
		       <option value='SSS'>SSS</option>
		      </select>
		     </td>
			</tr>
		   </table>
		  </fieldset>
         </td>
         </tr>
	  -->
	 <tr><td><input type='submit' name='action' value='Install'></td></tr>
    </table>
  </fieldset>
 </form>
</body>
