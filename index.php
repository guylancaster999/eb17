<?php session_start();
require "classes/classes.php";
Page::hdr("U");
$fyle = "index.php";
?>
<body>
<!-- set screen width -->
<script>
$(function() {
    $.post('someScript.php', { width: screen.width, height:screen.height }, function(json) {
        if(json.outcome == 'success') {
            // do something with the knowledge possibly?
        } else {
            alert('Unable to let PHP know what the screen resolution is!');
        }
    },'json');
});
</script>
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5&appId=828060457301904";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
DbAdmin::open_db();
$cat			= $_REQUEST["cat"];
$search			= $_REQUEST["search"];
$screentype		= Page::default_blank($_REQUEST["screentype"],"category");
$colz			= substr($_REQUEST["colz"],0,1);

switch ($colz)
{
	case "1":break;
	case "2":break;
	default:$colz="2";
}

$screenWidth	=$_SESSION['screen_width'];
$isSmall		=($screenWidth<=750);
$iscat			=(strlen($cat)>0);
$issearch		=(strlen($search)>0);
$isarchive		=($screentype=="archive"); 

if ($isSmall && ($iscat || $issearch || $isarchive) )$colz="1";
?>
<div class="container">
  <div class="row" >
  
  <?php
  if ($colz=="2")
  {
  ?>
    <div class="col-sm-3 col-3 col-md-3 col-lg-3" >
 <!-- 
*-----------------------------------------------------------*
|  Column1     												|                         
*-----------------------------------------------------------*
 -->
 	<?php print Page::fmt_element(Page::TTL2,"ttl2"); ?>
     <br/>
   <br/>
	<a href=<?php print $fyle;?> title="Edward Barton">
		<img align="right" src="img/mastheadedward_240.jpg" alt="Edward Barton" class="img-responsive"/>
	</a>
<br/>
<br/>
 <div>
<br/>
<br/>
 <?php
  	$qry="select code,descr,colr,font,fontweight,fontsize, italic ";
 	$qry.=" from edcategory";
 	$qry.=" order by ordr";
 	$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());

 	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
 	{
 		$code		=$row["code"];
 		$colr		=$row["colr"];
 		$descr		=$row["descr"];
 		$font		=$row["font"];
 		$fontweight	=$row["fontweight"];
 		$fontsize	=$row["fontsize"];
 		$italic		=$row["italic"];
 		print '<a href="'.$fyle.'?colz=2&screentype=category&cat='.$code.'">';
 		print Page::fmt($descr,$colr,$font,$fontsize,$fontweight,$italic,($code==$cat?"Y":"N"));
 		print '</a>';
     	print '<br/>';
 	}
 	print "</div>";
     ?>
 	<br/>
 	<br/><a name="archive"></a>
 	<div >
 	<?php print "<a href='".$fyle."?colz=2&screentype=archive#archive'>";
	print Page::fmt_element("Archive","archivettl");
	print "</a>";
 	print "<br/>";

 	if ($screentype=="archive")
 	{
 		$qry		= "select hdg,artdate,code ";
 		$qry.=		" from edart order by artdate desc;";
 		$result 	= mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
 		$prevy4		= "#";
 		$ctr		= 0;
 		$hdgs		= "";
 		$archive	= $_REQUEST["archive"];

 	while($row = mysql_fetch_array($result, MYSQL_ASSOC) )
 	{
 		$artid	=$row["code"];
 		$date	=$row["artdate"];
 		$hdg	=$row["hdg"];
 		$y4	=substr($date,0,4);

 		if ($y4!=$prevy4)
 		{
 			if ($ctr>0)
 			{
 				$link = $fyle;
				$link.='?colz=2';
				$link.='&screentype=archive';
 				$link.='&archive='.$prevy4;
 				$link.='#Y'.$prevy4;
 				print '<a href="'.$link.'">'.Page::fmt_element($prevy4,"archive"). "</a>";
 				print "&nbsp;&nbsp;".Page::fmt_element("(". $ctr.")","archivectr")."<br/>";
 				if ($archive == $prevy4)	print $hdgs;
 				$ctr    =0;
 				$hdgs ="";
 			}
 		}
 		$ctr++;
 		$prevy4	=$y4;
	 	$hdgs	.="&nbsp;&nbsp;&nbsp;";
 		$link	=$fyle;
		$link	.="?colz=2";
 		$link	.="&screentype=archive";
 		$link	.="&archive=".$prevy4;
 		$link	.="#ID".$artid;
 		$hdgs	.='<a href="'.$link.'">'.Page::fmt_element($hdg,"archive")."</a><br/>";
 	}
 	if ($ctr>0)
 	{
 		$link =$fyle;
		$link.="?colz=2";
 		$link.='&screentype=archive';
 		$link.="&archive=".$prevy4;
 		$link.='#Y'.$prevy4;
 		print '<a href="'.$link.'">'.Page::fmt_element($prevy4,"archive")."</a>";
 		print "&nbsp;&nbsp;".Page::fmt_element("(".$ctr.")","archivectr")."<br/>";

 		if ($archive ==$prevy4)
 				{
 					print $hdgs;
 				}
 		}
 	}
 	?>
 	</div>
 	<br/>
    <div>
    <form method="Post" action="<?php print $fyle;?>">
	<input type="hidden" id="colz" name="colz" value="2"/>
	<input type="hidden" id="screentype" name="screentype" value="search"/>
    <table>
    <tr>
    <td><?php print Page::fmt_element("Search:",'search');?>&nbsp;</td>
    <td><input type='text'  name='search'  value="<?php print $search;?>" class='form-control'></td>
    <td>&nbsp;&nbsp;	</td>
     </tr>
    </table>
    </form>
 <br/>
 <table>
    <tr>
    <td><img src='img/email_x.jpg' alt='Email'/></td>
	<td><?php print Page::fmt_element('<a href="MAILTO:edwardnotedward@yahoo.co.uk">edwardnotedward@yahoo.co.uk</a>','contact');?>
 	</td></tr></table>
 <br/>

  </div>
 </div>
<?php
  }
	?>
  <!--
*-------------------------------------------------------------------------*
|      Column2                                                            |
*-------------------------------------------------------------------------*
-->
<?php
   if ($colz=="1")
   {
	   print "<div class='col-sm-12 col-12 col-md-12 col-lg-12'>";
   }
   else
   {
	   print "<div class='col-sm-9 col-9 col-md-9 col-lg-9'>";
   }
	?>
	<div class="row">	
		<div class="col-sm-10 col-10 col-md-10 col-lg-10">
		      <?php print Page::fmt_element(Page::TTL1,"ttl1"); ?>
		</div>
		<div class="col-sm-2 col-2 col-md-2 col-lg-2">
			<form action="<?php print $fyle;?>">
			<?php $newcolz=($colz=='1'?'2':'1');?>
			<input type="hidden" id="colz" name="colz" value="<?php print $newcolz;?>">
			<input  <?php print Page::fmt_style("menu");?> type="submit" value=" <?php print ($colz==1?"Show":"Hide");?> Menu "/>
			</form>
		</div>
	</div>
	<?	
	switch ($screentype)
	{
	case "search":
  	$qry 	="select hdg, txt, artdate, category, code as artid ";
	$qry	.=" from edart ";
	$qry	.=" where (hdg like '%".trim($search)."%') ";
	$qry	.=" order by artdate;";
	$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
	$ctr	= 0;

	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$ctr++;
		$artdate	=$row["artdate"];
		$hdg		=$row["hdg"];
		$txt		=$row["txt"];
		$category	=$row["category"];
		$artid		=$row["artid"];
		$dt			=Page::date_to_s1($artdate);
		print "<br/>".Page::fmt_element($hdg,"hdg")."<br/>";
		print Page::fmt_element($dt,"date");
		print "<br/><br/><br/>";
		print Page::fmt_page($txt,$artid,$hdg,$screentype);
	}
	if ($ctr==0)
	{
		print Page::fmt_element("No articles found for [".$search."]","footer");
	}
	else
	{
		print Page::fmt_element("Articles found for [".$search."]","footer");
		 
	}
	break;

	case "archive":
		print  Page::fmt_element("Archive","archivettl")."<br><br>";
		$prevy4  ="*";
		$qry 	 ="select hdg,txt, artdate,category,code as artid ";
		$qry	.=" from edart ";
		$qry	.=" order by artdate desc;";
		$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());

		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$artdate		=$row["artdate"];
			$hdg		=$row["hdg"];
			$txt		=$row["txt"];
			$category	=$row["category"];
			$artid		=$row["artid"];
			$y4		=substr($artdate,0,4);

			if ($prevy4 !=$y4)
			{
				print "<a name='Y".$y4."'></a>";
				print Page::fmt_element($y4,archive);
				print "<br><br>";
				$prevy4 = $y4;
			}
			print "<a name='ID".$artid."'></a>";
			print "<br/>".Page::fmt_element($hdg,"hdg")."<br/>";
			$dt	= Page::date_to_s1($artdate);
			print Page::fmt_element($dt,"date");
			print "<br/><br/><br/>";
			print Page::fmt_page($txt,$artid,$hdg,$screentype);
 		}
		break;

	case "category":
	$submit	 = $_REQUEST["submit"];
 	$qry ="select a.hdg,a.txt ,a.artdate,a.category,a.code as artid ";
	$qry.="from edart as a,edcategory as b";
	$qry.=" where a.category=b.code ";

	if (strlen($cat)>0)
	{
	    $qryCat		= "select descr from edcategory where code =".$cat.";";
		$resultCat 	= mysql_query($qryCat) or die('Query '.$qryCat.' failed: ' . mysql_error());
		$rowCat 	= mysql_fetch_array($resultCat, MYSQL_ASSOC);
		$descrCat	= $rowCat["descr"];
		$qry		.=" and (a.category = ".$cat.") ";
	}
	$qry	.=" order by a.artdate;";
	$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
	$prevcat="*";
	$ctr	=0;

	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$ctr++;
		$artdate	=$row["artdate"];
		$hdg		=$row["hdg"];
		$txt		=$row["txt"];
		$category	=$row["category"];
		$artid		=$row["artid"];
  		$dt			=Page::date_to_s1($artdate);
		print "<br/>".Page::fmt_element($hdg,"hdg")."<br/>";
		print Page::fmt_element($dt,"date");
		print "<br/><br/><br/>";
		print Page::fmt_page($txt,$artid,$hdg,$screentype);
 		}
		if ($ctr==0)
		{
			print Page::fmt_element("No articles found for category ".$descrCat,"footer");
		} 
		} //switch screentype
		?>
		<br/>
		<br/>
	</div>
   </div>
</div>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'en-GB'}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-3773540-44', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
