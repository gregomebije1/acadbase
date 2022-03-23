<?php

function get_signup_notification($school_name, $email, $password) {
  return "<p>Thank You <strong>
    {$school_name}
     </strong> for signing up with 
     <a href='http://www.acadbase.com'>Acadbase.</a>
     we want to assure you that the 
      <a href='http://www.acadbase.com'>Acadbase</a>
     team is available 24hrs to respond to any question or
     technical support you might need, feel free to contact us
     via the email/phone number provided below or on our website.</p>
    <p>
    <p>Your Login Details</p>
    <p>Name of School: {$school_name} </p>
    <p>Username/Email: {$email} </p>
    <p>Password: {$password}</p>

    <br />
     <p>
     A suggestion for getting started quickly! Click on the link 
      below to learn how to use <a href='http://wwww.acadbase.com'>Acadbase</a>
      in 10 easy STEPS. 
     </p>
      
     <p><a href='http://www.acadbase.com/USING_ACADBASE.pdf'>
       http://www.acadbase.com/USING_ACADBASE.pdf</a></p>
 
     <p>While you enjoy using acadbase.com, 
      your feedback will be highly appreciated so as to serve you better.</p>
 
     <p><a href='mailto:support@acadbase.com'>support@acadbase.com</a></p>
     <p><a href='http://www.acadbase.com'>www.acadbase.com</a></p>

     <p>
      For further clarification please call us on +234 818 644 7200, +234 805 583 2287, +234 806 960 6485 or Contact us at Suite B5, Unique Shopping Mall, Works Yard Road, Off Oba Akinjobi Way GRA, Ikeja Lagos, Nigeria.
     </p>";
}
?>
