<?php
if ((isset($_REQUEST['action']) && ($_REQUEST['action'] != 'Print'))
     || (!isset($_REQUEST['action']))) {
  ?>
   <div id="pager" class="pager">
   <form>

   <img src="css/tablesorter/first.png" class="first"/>
   <img src="css/tablesorter/prev.png" class="prev"/>
   <input type="text" class="pagedisplay"/>
   <img src="css/tablesorter/next.png" class="next"/>
   <img src="css/tablesorter/last.png" class="last"/>
   <select class="pagesize">
    <!--<option selected="selected"  value="10">10</option>-->
    <option selected="selected" value="20">20</option>
    <option value="30">30</option>
    <option  value="40">40</option>
	<option  value="50">50</option>
   </select>
  </form>
 </div>

 <?php } ?>
