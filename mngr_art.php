<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
DbAdmin::open_db();
$crlf		=chr(13).chr(10);
$code		=$_REQUEST["code"];

if (strlen($code)>0)
{ 
	$qry		="select hdg,txt,category,artdate from edart where code=".$code.";";
	$result 	= mysql_query($qry) or die('Query failed:'. mysql_error());
	$row 		= mysql_fetch_array($result, MYSQL_ASSOC);
	$hdg		= Page::unclean_text($_REQUEST["hdg"]);
	$txt		= Page::unclean_text($row["txt"]);
	$date		= Page::date_to_s($row["artdate"]);
	$category	= $row["category"];
}
$err   		= $_REQUEST["err"];
$status		= $_REQUEST["status"];
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-10">
	<h3>Manage Art Data</h3>
 	<form action="do_mngr_art.php" method="POST">
        <table cellpadding="4">
		<tr>
		<td>Id</td>
		<td><input type="text" id="code" name="code" size="5" value="<?php print $code;?>"/></td>
		</tr>
		<tr>
		<td>Heading&nbsp;</td>
		<td><input type="text" id="hdg"  name="hdg" size="80"  value="<?php print $hdg;?>"/></td>
		</tr>
		<tr>
		<td valign="top">Text *</td>
		<td>
		<textarea name="txt" id="txt" rows="40" cols="90" maxlength="60000"><?php print $txt;?></textarea>
		</td>
		</tr>
		<tr>
		<td>Category</td>
		<td>
		<select name="category" id="category">
		<?php
		$qry="select code,descr,ordr,colr from edcategory order by code;";   
		$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$xcode=$row["code"];
			$xdescr=$row["descr"];
			print "<option value=".$xcode." ";
			if ($xcode==$category)
			{
				print " selected ";
			}
			print ">".$xdescr."</option>";
		}		
		?>
		</select>
		</td>
		</tr>
		<tr>
		<td>Date</td>
		<td><input type="text" id="date" name="date" size='8' value="<?php print $date;?>"/>&nbsp;&nbsp; [ddmmyyyy format]</td>
		</tr>
		 
		<tr>
		<td></td>
		<td><input type="submit" id="submit" name="submit" value="Add"> 
		<input type="submit" id="submit" name="submit" value="Change"> 
		<input type="submit" id="submit" name="submit" value="Delete"> 
	    <input type="submit" id="submit" name="submit" value="Enquire"> 
		<input type="submit" id="submit" name="submit" value="List">
		<input type="submit" id="submit" name="submit" value="Clear">
		<?php
		if ( Page::count_digits($code)>0)
		{
			print '<input type="submit" id="submit" name="submit" value="Images">
		           <input type="submit" id="submit" name="submit" value="Comments">';
		}
		?>
		</td>
		</tr>
		</table>
     </form>
	 <br/>
	 <div class="box">
	 <ul>
	 <li>Links should be in the format <blockquote>[link|http://www.xxx.xxx|Titlexxxxxx]</blockquote>
	 <br/>
	 </li>
	 <li>Images should be in the format <blockquote>[image|1] or [image|2]</blockquote> where 1.2...is the Image ID, set up using the Images button above
	 <br/>
	<br/>
	 </li>      
	<li>Sound should be in the format <blockquote>[sound|http://www.xxx.xxx|Titlexxxxxx]</blockquote> where the http...is the Web address of the sound file.
	<br/>
	<br/>
	 </li>
	<li>Video should be in the format <blockquote>[video|http://www.xxx.xxx|Titlexxx]</blockquote> where the http... is the Web address of the video.<br/>
	    Youtube videos should look like <blockquote>[video|https://www.youtube.com/embed/jhwcjwcwcw|Titlexxx]</blockquote>
	    jhwcjwcwcw is the Youtube id, which is the text after the = in the original Youtube Web address. 
		<br/>
		<br/>
	 </li>
	<li>Centred text should be placed between [center] and [/center] tags
	<br/>
		<br/>
	 </li>
	<li>Other formatting should be in the format <blockquote>[otherfont|xxxxx] </blockquote>where otherfont has been set up as a Font, and xxxx is the content.
	<br/>
	For instance,<blockquote>[poem|mary had a little lamb] </blockquote>or<br/>
	<blockquote>[haiku|Snow in my shoe<br/>
	Abandoned<br/>
	Sparrow's nest]</blockquote></li>
	</ul></div>
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
   
    <div class="col-sm-2">
    <?php Page::Mngr_Menu();?>
    </div>
  </div>
</div>
</body>
</html>
