<?php
function link_here($artid,$id,$descr,$filenm,$reply,$reviewedflag,$hdg,$date,$category,$txt,$err="",$status="")
{
	$link="http://www.edwardbarton.com/mngr_art_comments.php";
	$link.="?artid=".$artid;
	$link.="&id=".$id;
	$link.="&descr=".$descr;
	$link.="&reply=".$reply; 
	$link.="&filenm=".$filenm;
	$link.="&reviewedflag=".($reviewedflag=="Y"?"Y":"N");
	$link.="&hdg=".$hdg;
	$link.="&date=".$date;
	$link.="&category=".$category;
	$link.="&txt=".$txt;
	$link.="&err=".$err;
	$link.="&status=".$status;
	return $link;
}
function link_back($artid,$hdg,$date,$category,$txt)
{
	$link="http://www.edwardbarton.com/mngr_art.php";
	$link.="?code=".$artid;
	$link.="&hdg=".$hdg;
	$link.="&date=".$date;
	$link.="&category=".$category;
	$link.="&txt=".$txt;
	return $link;
	}

require "classes/classes.php";
Page::logged_in();
DbAdmin::open_db();
$descr		= $_POST["descr"];
$reply		= $_POST["reply"];
$id			= $_POST["id"];
$submit 	= $_POST["submit"];
$artid		= $_POST["artid"];
$hdg		= $_POST["hdg"];
$date		= $_POST["date"];
$txt		= $_POST["txt"];
$category	= $_POST["category"];
$reviewedflag=$_POST["reviewedflag"];
if ($delflag!="Y")
{
	$delflag="N";
}
if ($reviewedflag!="Y")
{
	$reviewedcflag="N";
}
if (strlen($artid)==0)
{
	header("location:mngr_art.php");
	exit;
}
switch($submit)
{
	case "Add":
	if (strlen($descr)==0)
	{
		$err.="Comment required.";
	}
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0)
	{
		$qry="select * from edartcomment ";
		$qry.=" where artid=".$artid." and code=".$id.";";   
	    $result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
	    $row = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if (mysql_affected_rows() > 0)
		{
			$err.="Comment already exists ".$id;
		}
		if (strlen($err)==0)
		{
			$qry="insert into edartcomment ";
			$qry.=" (artid,code,descr,reply,reviewedflag) ";
			$qry.="values ('".$artid."','".$id."','".$descr."','".reply."','".$reviewedflag."' );";	
        	$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$status="Added Art Comment ".$id;
		}
	}// err
	break;

	case "Change":
	
	if (strlen($descr)==0)
	{
		$err.="Comment required.";
	}
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0) 
	{
		$qry="select *  from edartcomment";
		$qry.=" where artid=".$artid." and code=".$id.";";   
	   $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
	   $row = mysql_fetch_array($result, MYSQL_ASSOC);
		if (mysql_affected_rows() == 0)
		{
			$err.="Comment does not exist for ID ".$id;
		}
	}
	if (strlen($err)==0)
	{
		if (strlen(trim($reply))>0)
		{
			$reviewedflag="Y";
		}
		$qry="update  edartcomment ";
		$qry.=" set descr='".$descr."',reply='".$reply."', reviewedflag='".($reviewedflag=="Y"?"Y":"N")."' ";
		$qry.=" where artid= ".$artid." and code=".$id.";";
       	$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		$status="Changed Art ".$artid." comment ".$id;
	}
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
	break;
	
	case "Enquire":
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0)
	{
		$qry="select descr,reply,reviewedflag  from edartcomment";
		$qry.=" where artid=".$artid." and code=".$id.";";   
	    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
	    $row = mysql_fetch_array($result, MYSQL_ASSOC);
	   
		if (mysql_affected_rows() == 0)
		{
			$err.="Comment  does not exist for ID ".$id;
		}
		else
		{
			$reply	=$row["reply"];
			$descr	=$row["descr"];
			$reviewedflag=$row["reviewedflag"];
		}	
	}		
	break;

	case "List":
	print Page::hdr("M");
	?>
	<div class="container">
		<div class="row">
			<div class="col-sm-8"> 
			<h3>Art Comments for ArtID #<?php print $artid." ".$hdg;?> </h3>
			<table>
				<tr>
					<th valign="top">ID&nbsp;</th>
					<th valign="top">Comment&nbsp;<br/>Reply&nbsp;</th>
					<th valign="top">Reviewed?<th>
				</tr>				
			<?php
			$qry="select code, descr,reply,reviewedflag ";
			$qry.=" from edartcomment ";
			$qry.=" where artid=".$artid;
			$qry.=" order by code;";  
			$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$id		=$row["code"];
				$descr	=$row["descr"];
				$reply	=$row["reply"];
				$reviewedflag=$row["reviewedflag"];
				$link	="<a href='".link_here($artid,$id,$descr,$filenm,$reply,$reviewedflag,$hdg,$date,$category,$txt,$err,$status)."'>";			
				print "<tr>";
				print "<td>".$link.$id."</a></td>";
				print "<td>".$link.$descr."</a>&nbsp;</td>";
				print "<td>".($reviewedflag=="Y"?"yes":"no")."</td>";
				print "</tr>";
				if (strlen(trim($reply))>0)
				{print "<tr>
					<td>&nbsp;</td>
					<td>".$reply."</td>
					<td>&nbsp;</td>
					</tr>";
				}
			}
			?>
		</table>
		<?php
 	    $link=link_here($artid,$id,$descr,$filenm,$reply,$reviewedflag,$hdg,$date,$category,$txt,$err,$status);
		print '<form action="'.$link.'" method="POST">';
		?>		
		    <input type="Submit" value="Exit"/>
		</form> 
		</div>
		<div class="col-sm-4">
		<?php Page::Mngr_Menu();?>
		</div>
		</div>
	</div>
	<?php
	exit;
	break;
	
	case "Clear":
		$descr		="";
		$reply		="";
		$delflag	="N";
		$reviewedflag="N";
		$id			="";
	break;
	
	case "Return":
		header("location:".link_back($artid,$hdg,$date,$category,$txt));
		exit;
	break;
}
$link="location:".link_here($artid,$id,$descr,$filenm,$reply,$reviewedflag,$hdg,$date,$category,$txt,$err,$status);
header($link);