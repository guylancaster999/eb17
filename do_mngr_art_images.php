<?php

function scale($from,$maxWdth)
{ 
	$from1	= strtolower($from);
	$dotpos	= strrpos($from1,".");
	$first	= substr($from1,0,$dotpos);
	$ext	= substr($from1,$dotpos+1);
	$dest_fn= $first."_".$maxWdth.".jpg";
	
	switch ($ext)
	{
		case "gif":	
			$source_image = imagecreatefromgif("uploads/".$from);
		break;

		case "jpeg": 
		$source_image = imagecreatefromjpeg("uploads/".$from);
		break;

		case "jpg":	$source_image = imagecreatefromjpeg("uploads/".$from);
		break;

		case "png":	$source_image = imagecreatefrompng("uploads/".$from);
		break;

		default:
		   die("Unknown file type");
	}
	if ($source_image ==false)
	{   
		die("Source image didnt load");
	}
	else
	{
		$source_imagex = imagesx($source_image);
		if ($source_imagex ==false)
		{
			die("imagesx failed");
		}
		$source_imagey = imagesy($source_image);
		if ($source_imagey==false)
		{
			die("imagesy failed");
		}
		if ($source_imagex<=800)
		{
			return $from;
		}
		else
		{
			$dest_imagex 	= $maxWdth;
			$dest_imagey 	= $source_imagey * $dest_imagex/$source_imagex;
			$dest_image 	= imagecreatetruecolor($dest_imagex, $dest_imagey);
			imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, 
			                   $source_imagey);
			imagejpeg($dest_image,"uploads/".$dest_fn,80);
		}
	}
	return $dest_fn;
}
function link_here($artid,$id,$filenm,$descr,$hdg,$date,$category,$txt,$err="",$status="")
{
	$link="http://www.edwardbarton.com/mngr_art_images.php";
	$link.="?artid=".$artid;
	$link.="&id=".$id;
	$link.="&filenm=".$filenm;
	$link.="&descr=".$descr;
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
$target_path= "uploads/";
$tmpfile	= $_FILES['filenm']['tmp_name']; 
$filenm		= $_FILES['filenm']['name'];
$descr		= $_POST["descr"];
$id			= $_POST["id"];
$submit 	= $_POST["submit"];
$artid		= $_POST["artid"];
$hdg		= $_POST["hdg"];
$date		= $_POST["date"];
$category	= $_POST["category"];
$txt		= $_POST["txt"];
$imgsz		= $_POST["imgsz"];
if (strlen(trim($imgsz))==0)
{
	$imgsz	=800;
}
if (strlen($ordr)==0)
{
	$ordr=1;
}
switch($submit)
{
	case "Add":
	if (strlen($filenm)==0)
	{
		$err.="File required.";
	}
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}
	if (strlen($err)==0)
	{
		$target_path = $target_path . basename( $filenm); 

		if(move_uploaded_file($tmpfile, $target_path)) 
		{
			$status	= "The file ".  basename($filenm). " has been uploaded. ";
			$filenm	= scale($filenm,$imgsz); //scale it if needed
			$qry	= "select *  from edartimg where artid=".$artid." and code=".$id.";";   
			$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			$row 	= mysql_fetch_array($result, MYSQL_ASSOC);
		
			if (mysql_affected_rows() > 0)
			{
				$err.="Image already exists for ".$id;
			}
			else
			{
				$qry	="insert  into edartimg ";
				$qry	.=" (artid,code,descr,filenm) ";
				$qry	.="values ('".$artid."','".$id."','".$descr."','".$filenm."');";	
				$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
				$status	="Added Art Image ".$id." File ".$filenm;
			}
		} //move
	}// err
	break;

	case "Change":
	
	 if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0) 
	{
		$qry	="select *  from edartimg ";
		$qry   .= " where artid=".$artid." and code=".$id.";";   
	    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
	    $row 	= mysql_fetch_array($result, MYSQL_ASSOC);
		if (mysql_affected_rows() == 0)
		{
			$err.="Image does not exist for ID ".$id;
		}
	}
	if (strlen($err)==0) 
	{
		if (strlen($filenm)>0)
		{
			$target_path = $target_path.basename($filenm); 
			if(move_uploaded_file($tmpfile, $target_path)) 
			{
				$status	= "The file ".  basename($filenm). " has been uploaded";
				$filenm	= scale($filenm,$imgsz);
			} 
		}				
		$qry="update edartimg ";
		$qry.=" set descr='".$descr."'";
		
		if (strlen($filenm)>0)
		{
			$qry.=", filenm='".$filenm."' ";
		}
		$qry.=" where artid= ".$artid." and code=".$id.";";
       	$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		$status="Changed Art Image ".$id ;
		if (strlen($filenm)>0)
		{
			$status.=" for ".$filenm;
		}
	}
	break;

	case "Delete":
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0)
	{
		$qry="delete from   edartimg ";
		$qry.=" where artid= ".$artid." and code=".$id.";";
        $result = mysql_query($qry) or die('Query '.$qry.'failed: ' . mysql_error());		
	}
	$status="Deleted Image ".$id;
	break;
	
	case "Enquire":
	if(strlen($id)==0)
	{
		$err.="ID required.";
	}			
	if (strlen($err)==0)
	{
		$qry="select descr,filenm  from edartimg where artid=".$artid." and code=".$id.";";   
	   $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
	   $row = mysql_fetch_array($result, MYSQL_ASSOC);
	   
		if (mysql_affected_rows() == 0)
		{
			$err.="Image does not exist for ID ".$id;
		}
		else
		{
			$descr	=$row["descr"];
			$filenm	=$row["filenm"];
		}	
	}		
	break;

	case "List":
	print Page::hdr("M");
	?>
	<div class="container">
		<div class="row">
			<div class="col-sm-8"> 
			<h3>Art Images for ArtID #<?php print $artid." ".$hdg;?> </h3>
			<table>
				<tr>
					<th>ID&nbsp;</th>
					<th>File Name&nbsp;</th>
					<th>Description&nbsp;</th>
				</tr>				
			<?php
			$qry="select code, descr,filenm ";
			$qry.=" from edartimg ";
			$qry.=" where artid=".$artid;
			$qry.=" order by code;";  
			$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			$ctr=0;
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$ctr++;
				$id		=$row["code"];
				$filenm	=$row["filenm"];
				$descr	=$row["descr"];
				$link	="<a href='".link_here($artid,$id,$filenm,$descr,$hdg,$date,$category,$txt)."'>";
				print "<tr>";
				print "<td>".$link.$id."</a></td>";
				print "<td>".$link.$filenm."</a>&nbsp;</td>";
				print "<td>".$link.$descr."</a></td>";
				print "</tr>";
			}
			?>
		</table>
		<br/>
		<?php
		$link	=link_here($artid,"","","",$hdg,$date,$category,$txt) ;
		print '<form action="'.$link.'" method="POST">';
		?>		
	    <input type="Submit" value="Exit"/>
		</form> 
		<br/>
		<?php
		if ($ctr>0)
		{
			print "<UL><LI>Click on image above to select it</li></ul>"; 
		}
		else
		{
			print "no images found";
		}
		?>
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
		$descr="";
		$filenm="";
		$id="";
	break;
	
	case "Return":
		header("location:".link_back($artid,$hdg,$date,$category,$txt));
		exit;
	break;
}
$link="location:".link_here($artid,$id,$filenm,$descr,$hdg,$date,$category,$txt,$err,$status);
$link.="&err=".$err;
$link.="&status=".$status;
header($link);