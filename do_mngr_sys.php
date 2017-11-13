<?php
require "classes/classes.php";
session_start();
$pass=$_SESSION["pass"];

if (!Page::test_psw($pass)!=1)
{	
    header("Location: http://www.edwardbarton.com/mngr_login.php?err=Incorrect-Password ");
	exit;
} 
DbAdmin::open_db();
$allcatcolor		= $_POST["allcatcolor"];
$ttl1color			= $_POST["ttl1color"];
$ttl2color			= $_POST["ttl2color"];
$soundcolor			= $_POST["soundcolor"];
$videocolor			= $_POST["videocolor"];
$txtcolor			= $_POST["txtcolor"];
$linkcolor			= $_POST["linkcolor"];
$commentcolor		= $_POST["commentcolor"];
$hdgcolor			= $_POST["hdgcolor"];
$allcatfontsize		= $_POST["allcatfontsize"];
$ttl1fontsize		= $_POST["ttl1fontsize"];
$ttl2fontsize		= $_POST["ttl2fontsize"];
$soundfontsize		= $_POST["soundfontsize"];
$videofontsize		= $_POST["videofontsize"];
$txtfontsize		= $_POST["txtfontsize"];
$linkfontsize		= $_POST["linkfontsize"];
$commentfontsize	= $_POST["commentfontsize"];
$hdgfontsize		= $_POST["hdgfontsize"];
$allcatfontweight	= $_POST["allcatfontweight"];
$ttl1fontweight		= $_POST["ttl1fontweight"];
$ttl2fontweight		= $_POST["ttl2fontweight"];
$soundfontweight	= $_POST["soundfontweight"];
$videofontweight	= $_POST["videofontweight"];
$txtfontweight		= $_POST["txtfontweight"];
$linkfontweight		= $_POST["linkfontweight"];
$commentfontweight	= $_POST["commentfontweight"];
$commentfontsize	= $_POST["commentfontsize"];
$hdgfontweight		= $_POST["hdgfontweight"];
$datecolor			= $_POST["datecolor"];
$datefontweight		= $_POST["datefontweight"];
$datefontsize		= $_POST["datefontsize"];

$datecolor			= $_POST["replycolor"];
$datefontweight		= $_POST["replyfontweight"];
$datefontsize		= $_POST["replyfontsize"];
$submit 			= $_POST["submit"];
	
switch($submit)
{
	case "Update":
	$err.=Page::validate_colour($ttl1color,"Title 1");
	$err.=Page::validate_colour($replycolor,"Reply");
  	$err.=Page::validate_colour($ttl2color,"Title 2");
    $err.=Page::validate_colour($hdgcolor,"Heading");
    $err.=Page::validate_colour($txtcolor,"Text");
    $err.=Page::validate_colour($linkcolor,"Text Link");
    $err.=Page::validate_colour($soundcolor,"Sound");
	$err.=Page::validate_colour($videocolor,"Video");
	$err.=Page::validate_colour($allcatcolor,"All Categories");
	$err.=Page::validate_colour($datecolor,"Date");
    $err.=Page::validate_colour($commentcolor,"Comment");
    $err.=Page::validate_fontsize($ttl1fontsize,"Title 1");
    $err.=Page::validate_fontsize($ttl2fontsize,"Title 2");
    $err.=Page::validate_fontsize($hdgfontsize,"Heading");
    $err.=Page::validate_fontsize($txtfontsize,"Text");
    $err.=Page::validate_fontsize($linkfontsize,"Text Link");
    $err.=Page::validate_fontsize($soundfontsize,"Sound");
	$err.=Page::validate_fontsize($videofontsize,"Video");
	$err.=Page::validate_fontsize($allcatfontsize,"All Categories");
	$err.=Page::validate_fontsize($datefontsize,"Date");
    $err.=Page::validate_fontsize($commentfontsize,"Comment");
    $err.=Page::validate_fontsize($replyfontsize,"Reply");
	$err.=Page::validate_fontweight($ttl1fontweight,"Title 1");
    $err.=Page::validate_fontweight($ttl2fontweight,"Title 2");
    $err.=Page::validate_fontweight($hdgfontweight,"Heading");
    $err.=Page::validate_fontweight($txtfontweight,"Text");
    $err.=Page::validate_fontweight($linkfontweight,"Text Link");
    $err.=Page::validate_fontweight($soundfontweight,"Sound");
	$err.=Page::validate_fontweight($videofontweight,"Video");
	$err.=Page::validate_fontweight($allcatfontweight,"All Categories");
	$err.=Page::validate_fontweight($datefontweight,"Date");
    $err.=Page::validate_fontweight($commentfontweight,"Comment");
    $err.=Page::validate_fontweight($replyfontweight,"Reply");

	if (strlen($err)==0)
	{
		$qry="update edsys ";
		$qry.=" set ttl1color='".$ttl1color."',";
		$qry.="     ttl2color='".$ttl2color."',";
    	$qry.="     allcatcolor='".$allcatcolor."',";
		$qry.="     linkcolor='".$linkcolor."',";
		$qry.="     txtcolor ='".$txtcolor."',";
		$qry.="     soundcolor='".$soundcolor."',";
		$qry.="     videocolor='".$videocolor."',";
		$qry.="     commentcolor='".$commentcolor."',";
		$qry.="     hdgcolor='".$hdgcolor."',";
		$qry.="     replycolor='".$replycolor."',";
		$qry.="     datecolor='".$datecolor."',";
		$qry.="     ttl1fontweight='".$ttl1fontweight."',";
		$qry.="     ttl2fontweight='".$ttl2fontweight."',";
    	$qry.="     allcatfontweight='".$allcatfontweight."',";
		$qry.="     linkfontweight='".$linkfontweight."',";
		$qry.="     txtfontweight ='".$txtfontweight."',";
		$qry.="     soundfontweight='".$soundfontweight."',";
		$qry.="     videofontweight='".$videofontweight."',";
	    $qry.="   	commentfontweight='".$commentfontweight."',";
		$qry.="   	hdgfontweight='".$hdgfontweight."',";
		$qry.="   	replyfontweight='".$replyfontweight."',";
		$qry.="     datefontweight='".$datefontweight."'";
	   	$qry.="     ttl1fontsize='".$ttl1fontsize."',";
		$qry.="     ttl2fontsize='".$ttl2fontsize."',";
		$qry.="     allcatfontsize='".$allcatfontsize."',";
		$qry.="     linkfontsize='".$linkfontsize."',";
		$qry.="     txtfontsize ='".$txtfontsize."',";
		$qry.="     soundfontsize='".$soundfontsize."',";
		$qry.="     videofontsize='".$videofontsize."',";
		$qry.="     commentfontsize='".$commentfontsize."',";
		$qry.="     hdgfontsize='".$hdgfontsize."',";
		$qry.="     datefontsize='".$datefontsize."',";
		$qry.="     replyfontsize='".$replyfontsize."'";
	    $qry.=" 	where indx=1;";
		$result = mysql_query($qry) or die('Query ".$qry." failed: ' . mysql_error());
		$status="Updated System"; 
	}
	break;
case "Return":
     		header("location:mngr.php");
		exit;
	break;
}
$link="location:mngr_sys.php";
$link.="?err=".$err;
$link.="&status=".$status;
header($link);