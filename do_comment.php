<?php
require "classes/classes.php";
$artid 			= $_POST["artid"];
$comment    	= $_POST["comment"];
$commentid    	= $_POST["commentid"];
$yourname		=$_POST["yourname"];
$screentype    	= $_POST["screentype"];
$hdg	    	= $_POST["hdg"];
$link			="http://www.edwardbarton.com/index_comments.php";
$link			.="?artid=".$artid;
$link			.="&screentype=".$screentype;
$link			.="&hdg=".$hdg;

if (strlen(trim($comment))==0)
{
	header("Location: ".$link);
	exit;
}
	$comment = Page::clean_text($comment);
	$yourname = Page::clean_text($yourname);
	DbAdmin::open_db();
	$qry="insert into  edartcomment ";
	$qry.=" (artid,code,descr,delflag,reply,yourname) ";
	$qry.=" values (".$artid.",".$commentid.",'".$comment."','N','','".$yourname."');";    
	$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
	header("Location: ".$link);
?>