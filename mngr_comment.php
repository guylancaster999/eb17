<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
DbAdmin::open_db();
$hdg			=$_REQUEST["hdg"];
$artid			=$_REQUEST["artid"];
$descr			=$_REQUEST["descr"];
$id				=$_REQUEST["id"];
$err   			=$_REQUEST["err"];
$status			=$_REQUEST["status"];
$reply			=$_REQUEST["reply"];
$reviewedflag	=$_REQUEST["reviewedflag"];
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage a Comment</h3>
	<form action="do_mngr_comment.php" method="POST">
		<input type="hidden" id="artid" name="artid" value="<?php print $artid;?>">
		<input type="hidden" id="hdg" name="hdg" value="<?php print $hdg;?>">
        <input type="hidden" id="id" name="id" value="<?php print $id;?>">
        <input type="hidden" id="descr" name="descr" value="<?php print $descr;?>">
          
	   <table cellpadding="4">
			<tr>
				<td>Art Id</td>
				<td><?php print $artid;?></td>
			</tr>
			<tr>
				<td>Heading&nbsp;</td>
				<td><?php print $hdg;?></td>
			</tr>
			<tr>
				<td valign="top">Comment&nbsp;#<?php print $id;?>&nbsp;</td>
				<td>
					<?php print trim($descr);?>
				</td>
			</tr>
			<tr>
				<td valign="top">Reply</td>
				<td>
					<textarea name="reply" id="reply" cols="80" rows="5"><?php print trim($reply);?></textarea>			
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
				<td><input type="submit" id="submit" name="submit" value="Update"> 
				<input type="submit" id="submit" name="submit" value="Delete"> 
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