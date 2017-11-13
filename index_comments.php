<?php
	require "classes/classes.php";
	Page::hdr("U");
?>
<body>
<?php
DbAdmin::open_db();
$artid		=$_REQUEST["artid"];
$hdg		=$_REQUEST["hdg"];
$screentype	=$_REQUEST["screentype"];
?>
<div class="container">
  <div class="row" >
    <div class="col-sm-12" >
	<?php
		print Page::fmt_element("Walking in the House","ttl1")."<br/><br/>"; 
		print Page::fmt_element($hdg,"hdg");
		print "<br/><br/>";
		$qryCom 		="select code, descr, reply,yourname ";
		$qryCom 		.=" from edartcomment ";
		$qryCom 		.=" where artid=".$artid." and delflag='N' ";
		$qryCom 		.=" order by code asc;"; 
		$rsltCom 		= mysql_query($qryCom) or die('Query '.$qryCom.' failed: ' . mysql_error());
		$commentid		=0;
    	print '<form action="do_comment.php" method="POST" role="form">';		
		print "<table>";

		while($rowCom  = mysql_fetch_array($rsltCom , MYSQL_ASSOC))
		{
				$commentid		=$rowCom['code'];
				$commentDescr	= Page::unclean_text($rowCom['descr']);
				$commentReply   = Page::unclean_text($rowCom['reply']);
				$yourname       = Page::unclean_text($rowCom["yourname"]);
				print "<tr>";
				print "<td>".Page::fmt_element("Name","comment")."&nbsp;</td>";
				print "<td>".$yourname.".&nbsp;</td>";
				print "</TR>";
				print "<tr>";
				print "<td>".Page::fmt_element("Comment&nbsp;#".$commentid,"comment")."</td>";
				print "<td>".Page::fmt_element($commentDescr,"comment")."</td>";
				print "</tr>";
				if (strlen(trim($commentReply))>0)
				{
					print "<tr>";
					print "<td>".Page::fmt_element("Reply","reply")."</td>";
					print "<td>".Page::fmt_element($commentReply,"reply")."</td>";
					print "</tr>";
				}
				print "<tr>";
				print "<td>&nbsp;</td>";
				print "<td></td>";
				print "</tr>";
			}
			$commentid++;
			?>
	 		<tr>
			<td>&nbsp;</td>
			</tr>
			<tr>
			<td><?php print Page::fmt_element("Your Name:","comment");?>&nbsp;</td>
			<td><input type="text" id="yourname" name="yourname" required ></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
			<tr>
			 <td valign="top"><?php print Page::fmt_element("Comment #".$commentid.":","comment");?>&nbsp;&nbsp;</td>
			<td><input type="hidden" id="artid" name="artid" value="<?php print $artid;?>">
			<input type="hidden" id="hdg" name="hdg" value="<?php print $hdg;?>">
			<input type="hidden" id="screentype" name="screentype" value="<?php print $screentype;?>">
			<input type="hidden" id="commentid" name="commentid" value="<?php print $commentid;?>">
			<textarea id="comment" name="comment" cols="80" rows="10"></textarea></td>
			</tr>
			<tr>
			<td>
			</td>
			<td align='center'><input TYPE="image" SRC="img/button1.jpg" HEIGHT="30" WIDTH="30" BORDER="0" ALT="Go" class="gobutton"></td>
				</td>
				</tr>		
			</table>
			</form>
 	</div>
  </div>
</div>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
</body>
</html>