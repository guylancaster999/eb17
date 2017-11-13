<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
DbAdmin::open_db();
$hdg		=$_REQUEST["hdg"];
$date		= $_REQUEST["date"];
$artid		=$_REQUEST["artid"];
$txt		=$_REQUEST["txt"];
$descr		=$_REQUEST["descr"];
$reply      = $_REQUEST["reply"];
$filenm     = $_REQUEST["filenm"];
$reviewedflag	=$_REQUEST["reviewedflag"];
$id			=$_REQUEST["id"];
$err   		=$_REQUEST["err"];
$status		=$_REQUEST["status"];
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage Art Comments</h3>
	<form action="do_mngr_art_comments.php" method="POST"  enctype="multipart/form-data">
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
				<td>Date&nbsp;</td>
				<td><?php print $date;?></td>
			</tr>
			<tr>
				<td>Heading&nbsp;</td>
				<td><?php print $hdg;?></td>
			</tr>
			<tr>
				<td>Comment&nbsp;Id&nbsp;</td>
				<td><input type="text" id="id" name="id" size='2' value="<?php print $id;?>"/></td>
			</tr>
			<tr>
				<td valign="top">Comment&nbsp;</td>
				<td>
					<textarea name="descr" id="descr" cols="60" rows="5"><?php print trim($descr);?></textarea>				  </textarea>
				</td>
			</tr>
			 <tr>
				<td valign="top">Reply</td>
				<td>
					<textarea name="reply" id="reply" cols="60" rows="5"><?php print trim($reply);?></textarea>			
				</td>
			</tr>
			<tr>
				<td valign="top">Reviewed?&nbsp;</td>
				<td>
					<input type ="checkbox" name="reviewedflag" id="reviewedflag" value="Y" <?php if($reviewedflag=="Y"){print " checked ";};?>>
				</td>
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
