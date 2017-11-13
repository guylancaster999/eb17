<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
DbAdmin::open_db();
$hdg		=$_REQUEST["hdg"];
$txt		=$_REQUEST["txt"]; 
$artid		=$_REQUEST["artid"];
$date		=$_REQUEST["date"];
$descr		=$_REQUEST["descr"];
$filenm		="";
$id			=$_REQUEST["id"];
$category 	=$_REQUEST["category"];
$err   		=$_REQUEST["err"];
$status		=$_REQUEST["status"];
$imgsz		=$_REQUEST["imgsz"];
if (strlen(trim($imgsz))==0)
{
	$imgsz	= 800;
}
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage Art Images</h3>
	<form action="do_mngr_art_images.php" method="POST"   enctype="multipart/form-data">
		<input type="hidden" id="artid" name="artid" value="<?php print $artid;?>">
		<input type="hidden" id="hdg" name="hdg" value="<?php print $hdg;?>">
		<input type="hidden" id="txt" name="txt" value="<?php print $txt;?>">
		<input type="hidden" id="date" name="date" value="<?php print $date;?>">
		<input type="hidden" id="category" name="category" value="<?php print $category;?>">
        <table cellpadding="4">
			<tr>
				<td>Art Id</td>
				<td><?php print $artid;?></td>
			</tr>
			<tr>
				<td>Date</td>
				<td><?php print $date;?></td>
			</tr>
			
			<tr>
				<td>Heading&nbsp;</td>
				<td><?php print $hdg;?></td>
			</tr>
			<tr>
				<td>Image Id *</td>
				<td><input type="text" id="id" name="id" size='2' value="<?php print $id;?>"/></td>
			</tr>
			<tr>
				<td valign="top">Description&nbsp;</td>
				<td><input type ="text" name="descr" id="descr" size="100" value="<?php print $descr;?>"/></td>
			</tr>
			<tr>
				<td>Filename</td>
				<td><input type="file" id ="filenm" name="filenm" /></td>
			</tr>
			<tr>
				<td>Image Size</td>
				<td><input type="text" id ="imgsz" name="imgsz" value="<?php print $imgsz;?>" size="3"/></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>	
			<tr>
				<td></td>
				<td><input type="submit" id="submit" name="submit" value="Add"> 
				<input type="submit" id="submit" name="submit" value="Change"> 
				<input type="submit" id="submit" name="submit" value="Delete"> 
				<input type="submit" id="submit" name="submit" value="Enquire"> 
				<input type="submit" id="submit" name="submit" value="List">
				<input type="submit" id="submit" name="submit" value="Clear">
				<input type="submit" id="submit" name="submit" value="Return">
				</td>
			</tr>
		</table>
     </form>
	 <br/>
	 	 <div class="box">
	 <ul>
	 <li> An Image Id of 1,2,3 etc. relates to the [Image|1],[Image|2],[Image|3] etc. in the previous screen</li>
	 </ul>
	 </div>
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
