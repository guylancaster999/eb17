<?php
require "classes/classes.php";
Page::logged_in();
DbAdmin::open_db();
$descr			= $_POST["descr"];
$reply			= $_POST["reply"];
$reviewedflag	= $_POST["reviewedflag"];
$id				= $_POST["id"];
$submit 		= $_POST["submit"];
$artid			= $_POST["artid"];
$hdg			= $_POST["hdg"];
switch($submit)
{
	case "Update":
		if (strlen(trim($reply))>0)
		{
			$reviewedflag="Y";
		}
		$qry="update  edartcomment ";
		$qry.=" set reply='".$reply."', reviewedflag='".($reviewedflag=="Y"?"Y":"N")."' ";
		$qry.=" where artid= ".$artid." and code=".$id.";";
		$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		$status="Updated Art ".$artid." comment ".$id;
		break;

	case "Delete":
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0)
	{
		$qry="delete from   edartcomment ";
		$qry.=" where artid= ".$artid." and code=".$id.";";
        $result = mysql_query($qry) or die('Query '.$qry.'failed: ' . mysql_error());		
	}
	$status="Deleted Comment ".$id;
	header("location: http://www.edwardbarton.com/mngr_comments.php");
	exit;
		
	case "Return":
		header("location: http://www.edwardbarton.com/mngr_comments.php");
		exit;
	break;
}
$link="location: http://www.edwardbarton.com/mngr_comment.php";
$link.="?artid=".$artid;
$link.="&hdg=".$hdg;
$link.="&id=".$id;
$link.="&descr=".$descr;
$link.="&reply=".$reply;
$link.="&reviewedflag=".$reviewedflag;
$link.="&err=".$err;
$link.="&status=".$status;
header($link);