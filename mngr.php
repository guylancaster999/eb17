<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
?>
<body>
<div class="container">
   <div class="row">
    <div class="col-sm-8">
	<h3>Manage Data</h3>
         </div>
       <div class="col-sm-4">
       <?php Page::Mngr_Menu();?>
    </div>
  </div>
</div>
</body>
</html>
