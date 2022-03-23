<html>
<head>
 <link rel="stylesheet" type="text/css" href="css/sql-ledger.css" media="all" />
 <link rel="shortcut icon" href="images/sql-ledger.ico" type="image/ico" />
</head>

<?
function acc_menu() {
?>
  <script type="text/javascript">
  function SwitchMenu(obj) {
    if (document.getElementById) {
      var el = document.getElementById(obj);

      if (el.style.display == "none") {
        el.style.display = "block"; //display the block of info
      } else {
        el.style.display = "none";
      }
    }
  }

  function ChangeClass(menu, newClass) {
    if (document.getElementById) {
      document.getElementById(menu).className = newClass;
    }
  }
  document.onselectstart = new Function("return false");
  </script>

  <body class=menu>
  <img src='images/sql-ledger.gif' width=80 border=0>
<?

  if ($form->{js}) {
    &js_menu($menu);
  } else {
    &section_menu($menu);
  }

  print qq|
</body>
</html>
|;


<FRAMESET COLS="$menuwidth,*" BORDER="1">

  <FRAME NAME="acc_menu" SRC="menu.php?login=Login&action=acc_menu&path=&js=">
  <FRAME NAME="main_window" SRC="am.php?login=login&action=main&path=path">

</FRAMESET>

</BODY>
</HTML>