<?php
require "classes/classes.php";
print Page::hdr("M");
?>
<body>
<div class="container">
 
  <div class="row">
    <div class="col-sm-8">
	<h3>Login</h3>
	<form action="do_password.php" method="POST">
	Password &nbsp; <input type="password" id="pass" name="pass"  size="8"/> &nbsp;
	<input type="submit"/>
	</form>
	<br/>
	
	<?php 
		print '&nbsp;<span style="color:red;font-weight:bold"> '.$_REQUEST["err"].'</span>';
	?>
         </div>
   
    <div class="col-sm-4">
      <h3>Ed Barton</h3>  
<img src="img/ed.png" alt="Ed Barton" class="img-responsive"/>      
    </div>
  </div>
</div>

</body>
</html>
