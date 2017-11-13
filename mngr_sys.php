<?php
require "classes/classes.php";
session_start();
$pass=$_SESSION["pass"];

if (!Page::test_psw($pass)!=1)
	{	
        header("Location: mngr_login.php?err=Incorrect-Password ");
		exit;
    }
print Page::hdr("M");
?>
<body>
<?php
$err   		=$_REQUEST["err"];
$status		=$_REQUEST["status"];
DbAdmin::open_db();
$qry="select 
$qry.="allcatcolor,allcatfont,allcatfontsize,allcatfontweight, ";
$qry.="commentcolor,commentfont,commentfontweight,commentfontsize,";
$qry.="datecolor,datefont,datefontweight,datefontsize,";
$qry.="hdgcolor,hdgfont,hdgfontweight,hdgfontsize,";
$qry.="imgcolor,imgfont,imgfontweight,imgfontsize,";
$qry.="linkcolor,linkfont,linkfontweight,linkfontsize,";
$qry.="poemcolor,poemfont,poemfontweight,poemfontsize, ";
$qry.="replycolor,replyfont,replyfontweight,replyfontsize, ";
$qry.="ttl1color,ttl1font,ttl1fontweight,ttl1fontsize, ";
$qry.="ttl2color,ttl2font,ttl2fontweight,ttl2fontsize, ";
$qry.="txtcolor,txtfont,txtfontweight,txtfontsize, ";
$qry.="soundcolor,soundfont,soundfontweight,soundfontsize, ";
$qry.="videocolor,videofont,videofontweight,videofontsize,";
$qry.=" from edsys ";
$qry.=" where indx=1;";
$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$allcatcolor		=$row["allcatcolor"];
$commentcolor		=$row["commentcolor"];
$datecolor			=$row["datecolor"];
$hdgcolor			=$row["hdgcolor"];
$imgcolor			=$row["imgcolor"];
$linkcolor 			=$row["linkcolor"];
$poemcolor			=$row["poemcolor"];
$replycolor 		=$row["replycolor"];
$soundcolor			=$row["soundcolor"];
$ttl1color			=$row["ttl1color"];
$ttl2color			=$row["ttl2color"];
$txtcolor			=$row["txtcolor"];
$videocolor			=$row["videocolor"];

$allcatfont			=$row["allcatfont"];
$commentfont		=$row["commentfont"];
$datefont			=$row["datefont"];
$hdgfont			=$row["hdgfont"];
$imgfont			=$row["imgfont"];
$linkfont 			=$row["linkfont"];
$poemfont			=$row["poemfont"];
$replyfont 		    =$row["replyfont"];
$soundfont			=$row["soundfont"];
$ttl1font			=$row["ttl1font"];
$ttl2font			=$row["ttl2font"];
$txtfont			=$row["txtfont"];
$videofont			=$row["videofont"];


$allcatfontsize			=$row["allcatfontsize"];
$commentfontsize		=$row["commentfontsize"];
$datefontsize			=$row["datefontsize"];
$hdgfontsize			=$row["hdgfontsize"];
$imgfontsize			=$row["imgfontsize"];
$linkfontsize 			=$row["linkfontsize"];
$poemfontsize			=$row["poemfontsize"];
$replyfontsize 		    =$row["replyfontsize"];
$soundfontsize			=$row["soundfontsize"];
$ttl1fontsize			=$row["ttl1fontsize"];
$ttl2fontsize			=$row["ttl2fontsize"];
$txtfontsize			=$row["txtfontsize"];
$videofontsize			=$row["videofontsize"];


$allcatfontweight			=$row["allcatfontweight"];
$commentfontweight		=$row["commentfontweight"];
$datefontweight			=$row["datefontweight"];
$hdgfontweight			=$row["hdgfontweight"];
$imgfontweight			=$row["imgfontweight"];
$linkfontweight 			=$row["linkfontweight"];
$poemfontweight			=$row["poemfontweight"];
$replyfontweight 		    =$row["replyfontweight"];
$soundfontweight			=$row["soundfontweight"];
$ttl1fontweight			=$row["ttl1fontweight"];
$ttl2fontweight			=$row["ttl2fontweight"];
$txtfontweight			=$row["txtfontweight"];
$videofontweight			=$row["videofontweight"];
?>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage System Values</h3>
	<form action="do_mngr_sys.php" method="POST" >
	    <table cellpadding="4">
			<tr>
				<th>Element</th>
				<th>Colour</th>
				<th>Font Weight&nbsp;</th>
				<th>Font Size</th>
				<th>Font</th>
			</tr>
			<tr>
				<td>Title 1</td>
				<td><input type="text" id="ttl1color" name="ttl1color" size='6' value="<?php print $ttl1color;?>"/><?php Page::bar($ttl1color);?></td>
				<td><input type="text" id="ttl1fontweight" name="ttl1fontweight" size='3' value="<?php print $ttl1fontweight;?>"/></td>
				<td><input type="text" id="ttl1fontsize" name="ttl1fontsize" size='2' value="<?php print $ttl1fontsize;?>"/></td>
				<td><input type="text" id="ttl1font" name="ttl1font" size='20' value="<?php print $ttl1font;?>"/></td>
			</tr>
			<tr>
				<td>Title 2</td>
				<td><input type="text" id="ttl2color" name="ttl2color" size='6' value="<?php print $ttl2color;?>"/><?php Page::bar($ttl2color);?></td>
				<td><input type="text" id="ttl2fontweight" name="ttl2fontweight" size='3' value="<?php print $ttl2fontweight;?>"/></td>
				<td><input type="text" id="ttl2fontsize" name="ttl2fontsize" size='2' value="<?php print $ttl2fontsize;?>"/></td>
		    	<td><input type="text" id="ttl2font" name="ttl2font" size='20' value="<?php print $ttl2font;?>"/></td>
			</tr>
			 
			<tr>
				<td>Archive&nbsp;</td>
				<td><input type="text" id="archivecolor" name="allcatcolor" size='6' value="<?php print $allcatcolor;?>"/><?php Page::bar($allcatcolor);?></td>
				<td><input type="text" id="allcatfontweight" name="allcatfontweight" size='3' value="<?php print $allcatfontweight;?>"/></td>
				<td><input type="text" id="allcatfontsize" name="allcatfontsize" size='2' value="<?php print $allcatfontsize;?>"/></td>
			</tr>
			<tr>
				<td>All Categories&nbsp;</td>
				<td><input type="text" id="allcatcolor" name="allcatcolor" size='6' value="<?php print $allcatcolor;?>"/><?php Page::bar($allcatcolor);?></td>
				<td><input type="text" id="allcatfontweight" name="allcatfontweight" size='3' value="<?php print $allcatfontweight;?>"/></td>
				<td><input type="text" id="allcatfontsize" name="allcatfontsize" size='2' value="<?php print $allcatfontsize;?>"/></td>
			</tr>
			<tr>
				<td>Comment</td>
				<td><input type="text" id="commentcolor" name="commentcolor" size='6' value="<?php print $commentcolor;?>"/><?php Page::bar($commentcolor);?></td>
				<td><input type="text" id="commentfontweight" name="commentfontweight" size='3' value="<?php print $commentfontweight;?>"/></td>
				<td><input type="text" id="commentfontsize" name="commentfontsize" size='2' value="<?php print $commentfontsize;?>"/></td>
			</tr>
			<tr>
				<td>Reply</td>
				<td><input type="text" id="replycolor" name="replycolor" size='6' value="<?php print $replycolor;?>"/><?php Page::bar($commentcolor);?></td>
				<td><input type="text" id="replyfontweight" name="replyfontweight" size='3' value="<?php print $replyfontweight;?>"/></td>
				<td><input type="text" id="replyfontsize" name="replyfontsize" size='2' value="<?php print $replyfontsize;?>"/></td>
			</tr>
			<tr>
				<td>Sound </td>
				<td><input type="text" id="soundcolor" name="soundcolor" size='6' value="<?php print $soundcolor;?>"/><?php Page::bar($soundcolor);?></td>
				<td><input type="text" id="soundfontweight" name="soundfontweight" size='3' value="<?php print $soundfontweight;?>"/></td>
				<td><input type="text" id="soundfontsize" name="soundfontsize" size='2' value="<?php print $soundfontsize;?>"/></td>
			</tr>
			<tr>
				<td>Video</td>
				<td><input type="text" id="videocolor" name="videocolor" size='6' value="<?php print $videocolor;?>"/><?php Page::bar($videocolor);?></td>
				<td><input type="text" id="videofontweight" name="videofontweight" size='3' value="<?php print $videofontweight;?>"/></td>
				<td><input type="text" id="videofontsize" name="videofontsize" size='2' value="<?php print $videofontsize;?>"/></td>
			</tr>
			<tr>
				<td>Link</td>
				<td><input type="text" id="linkcolor" name="linkcolor" size='6' value="<?php print $linkcolor;?>"/><?php Page::bar($linkcolor);?></td>
				<td><input type="text" id="linkfontweight" name="linkfontweight" size='3' value="<?php print $linkfontweight;?>"/></td>
				<td><input type="text" id="linkfontsize" name="linkfontsize" size='2' value="<?php print $linkfontsize;?>"/></td>
			</tr>
		
			<tr>
				<td>Heading</td>
				<td><input type="text" id="hdgcolor" name="hdgcolor" size='6' value="<?php print $hdgcolor;?>"/><?php Page::bar($hdgcolor);?></td>
				<td><input type="text" id="hdgfontweight" name="hdgfontweight" size='3' value="<?php print $hdgfontweight;?>"/></td>
				<td><input type="text" id="hdgfontsize" name="hdgfontsize" size='2' value="<?php print $hdgfontsize;?>"/></td>
			</tr>
	<tr>
				<td>Text</td>
				<td><input type="text" id="txtcolor" name="txtcolor" size='6' value="<?php print $txtcolor;?>"/><?php Page::bar($txtcolor);?></td>
				<td><input type="text" id="txtfontweight" name="txtfontweight" size='3' value="<?php print $txtfontweight;?>"/></td>
				<td><input type="text" id="txtfontsize" name="txtfontsize" size='2' value="<?php print $txtfontsize;?>"/></td>
			</tr>
				<tr>
				<td>Date</td>
				<td><input type="text" id="datecolor" name="datecolor" size='6' value="<?php print $datecolor;?>"/><?php Page::bar($datecolor);?></td>
				<td><input type="text" id="datefontweight" name="datefontweight" size='3' value="<?php print $datefontweight;?>"/></td>
				<td><input type="text" id="datefontsize" name="datefontsize" size='2' value="<?php print $datefontsize;?>"/></td>
			</tr>
		<tr>
				<td>&nbsp;</td>
			</tr>	
			<tr>
				<td></td>
				<td><input type="submit" id="submit" name="submit" value="Update"> 
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
