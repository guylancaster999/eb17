<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
$code		=$_REQUEST["code"];
$ordr		=$_REQUEST["ordr"];
$descr		=$_REQUEST["descr"];
$colr		=$_REQUEST["colr"];
$fontsize	=$_REQUEST["fontsize"];
$fontweight	=$_REQUEST["fontweight"];
$italic		=$_REQUEST["italic"];
$font		=str_replace("^",",",$_REQUEST["font"]);
$err   		=$_REQUEST["err"];
$status		=$_REQUEST["status"];
?>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage Category Data</h3>
	<form action="do_mngr_category.php" method="POST">
        <table cellpadding="4">
		<tr>
		<td>Id</td>
		<td><input type="text" id="code" name="code" size="5" value="<?php print $code;?>"/></td>
		</tr>
		<tr>
		<td>Description&nbsp;</td>
		<td><input type="text" id="descr"  name="descr" size="50"  value="<?php print $descr;?>"/></td>
		</tr>
		<tr>
			<td>Order</td>
			<td><input type="text" id="ordr" name="ordr" size="2" value="<?php print $ordr;?>"/></td>
		</tr>
		<tr>
			<td>Colour</td>
			<td><input type="text" id="colr" name="colr" size='6' value="<?php print $colr;?>"/><?php Page::bar($colr);?>
		</td>
		</tr>
		<tr>
			<td>Font </td>
			<td><input type="text" id="font" name="font" size='60' value="<?php print $font;?>"/></td>
		</tr>
		<tr>
			<td>Font Weight&nbsp;</td>
			<td><input type="text" id="fontweight" name="fontweight" size='3' value="<?php print $fontweight;?>"/></td>
		</tr>
		<tr>
			<td>Font Size</td>
			<td><input type="text" id="fontsize" name="fontsize" size='2' value="<?php print $fontsize;?>"/></td>
		</tr>
		<tr>
			<td>Italic</td>
			<td><input type="checkbox" id="italic" name="italic" <?php print ($italic=="Y"? ' checked="checked" ':" ");?> value="Y"/></td>
		</tr>	
	<tr>
		<td></td>
		<td><input type="submit" id="submit" name="submit" value="Add"> 
		<input type="submit" id="submit" name="submit" value="Change"> 
		<input type="submit" id="submit" name="submit" value="Delete"> 
	    <input type="submit" id="submit" name="submit" value="Enquire"> 
		<input type="submit" id="submit" name="submit" value="List">
		<input type="submit" id="submit" name="submit" value="Clear">
		</td>
		</tr>
		</table>
     </form>
	 <br/>
	 <br/>
	 <?php 
	 if (strlen($err)>0)
	 {
		 print '<div style="color:red;font-weight:bolder;">'.$err.'</div>';
	 }
 	 if (strlen($status)>0)
	 {
		 print '<div style="color:blue;font-weight:bolder;">'.$status.'</div>';
	 }
    ?>
</div>
   
    <div class="col-sm-4">
    <?php Page::Mngr_Menu();?>
    </div>
  </div>
</div>

</body>
</html>
