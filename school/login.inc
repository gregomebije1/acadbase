<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML dir=ltr lang=en-US xmlns="http://www.w3.org/1999/xhtml">
<HEAD> 
 <TITLE>Login into Acadbase</TITLE>
 <META content="text/html; charset=UTF-8" http-equiv=Content-Type>
 <LINK rel="shortcut icon" type=image/x-icon href="images/favicon.ico">

 <LINK rel=stylesheet type=text/css href="style.css" media=screen>
 <LINK rel=stylesheet type=text/css href="screen.css" 
   media="screen, projection">
 <LINK rel=stylesheet type=text/css href="print.css" media=print>

 <META name=robots content=noindex,nofollow>
</head>
<BODY class="page page-id-178 page-template-default">
 <DIV id=headerbackground>
   <div class='container' 
   style='width:100%; background-color: #204d89;'>

   <DIV id=headercontent class=span-24>
    <DIV id=logo class=span-8><A href="acadbase.com/">
     <IMG  alt=acadbase src="images/mangitallogo.png" width=283 height=75></A> 
    </DIV>
    <DIV id=navigation class=span-14>
     <A href="index.html">HOME</A> 
     <A href="blog.html">BLOG</A> 
     <A href="aboutus.html">ABOUT</A> 
     <A href="contactus.php">CONTACT</A> 
    </DIV>
    <DIV id=login class="span-2 last"><A href="login.php">LOGIN</A> </DIV>
   </DIV>
  </DIV>
 </DIV>

 <DIV id="topbar">
  <DIV class="container">
   <DIV id="topbartext" class="span-24">
    <P>
     <H1>Welcome To Acadbase</H1>
     <DIV class=textwidget></DIV>
     <P></P>
   </DIV>
  </DIV>
 </DIV>

 <DIV id=contentcontainer role=main>
 <DIV class=container>
   <DIV class=span-24px>
    <DIV id=maincontent class=span-18>
     <DIV id=post-178 class=post>
      <DIV id=pageheader><H1>Login </H1></DIV>
      <DIV id=blog class=entry>
      
       <div id="contactForm">
       <?php echo $output; ?>
        <form method='post' action='login.php'>
          <div style="text-align:left; padding-top:5px;color:#666;
           font-size:16px;font-weight:bold;margin:20px 0px 5px;">
           <label for="u">Username</label>
          </div>

          <div style="text-align:left;">
           <input style="text-align:left; margin:0;padding:10px 3px;" 
            type="text" id="u" name="u" size="40" />
          </div>

          <div style="text-align:left; padding-top:5px;color:#666;
           font-size:16px;font-weight:bold;margin:20px 0px 5px;">
           <label for="p1">Password</label>
           </div>

           <div style="text-align:left;">
            <input style="text-align:left; margin:0;padding:10px 3px;" 
             type="password" id="p1" name="p1"  size="40" />
           </div>

           <div style="text-align:left; padding-top:8px;">
            <input type="submit" style="cursor:pointer;
             margin:0; margin-top: 10px;" name='action' value="login" /> </div>
           </form>
          </div>
          </div>

      </DIV>
     </DIV>
    </DIV>
    
    </DIV></DIV></DIV>

  <div><br/><br /><br /></div>

  <div id='footer'>
   <div class="container">
    <div class="span-24">
    <p>&copy; Copyright 2012 Mangital ltd All rights reserved. &nbsp;
     <a href="privacy-policy.html">Privacy Policy</a> |
     <a href="terms-of-service.html">Terms of Service</a>
    </p>
    </div>
   </div>
  </div>
</body>
</html>
