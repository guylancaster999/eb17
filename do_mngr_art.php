<?php	
 function link_here($code,$hdg,$category,$txt,$date,$status,$err)
{
	$ret="http://www.edwardbarton.com/mngr_art.php";
	$ret.="?err=".$err;
	$ret.="&code=".$code;
	$ret.="&hdg=".$hdg;
	$ret.="&category=".$category;
 	$ret.="&date=".$date;
	$ret.="&status=".$status;
  	return $ret;
}  
function link_to_images($code,$hdg,$category,$txt,$date,$status,$err)
{
	$ret="http://www.edwardbarton.com/mngr_art_images.php";
	$ret.="?err=".$err;
	$ret.="&artid=".$code;
	$ret.="&hdg=".$hdg;
	$ret.="&category=".$category;
 	$ret.="&date=".$date;
	$ret.="&status=".$status;
	$_SESSION["txt"]=$txt;
	return $ret;
}  
function link_to_comments($code,$hdg,$category,$txt,$date,$status,$err)
{
	$ret="http://www.edwardbarton.com/mngr_art_comments.php";
	$ret.="?err=".$err;
	$ret.="&artid=".$code;
	$ret.="&hdg=".$hdg;
	$ret.="&category=".$category;
 	$ret.="&date=".$date;
	$ret.="&status=".$status;
	return $ret;
}  
require "classes/classes.php";
Page::logged_in();
$submit 	= $_POST["submit"];
$hdg    	= Page::clean_text( $_POST["hdg"]);
$txt    	= Page::clean_text($_POST["txt"]);
$code   	= $_POST["code"];
$category	= $_POST["category"];
$date		= $_POST["date"];
$err    	= "";
$status 	= "";
DbAdmin::open_db();

switch ($submit)
	{
		case "Change":
		$err.=Page::validate_required($code,"ID");
		$err.=Page::validate_required($hdg,"Heading");
		$err.=Page::validate_required($txt,"Text");
		 
		if (!Page::testDt($date))
		{
			$err.="Date is not ddmmyyyy format - ".$date.".";
		}
		if (strlen($err)==0)
		{
			$qry	="update edart ";
			$qry	.=" set hdg='".$hdg."', txt='".$txt."', artdate='".Page::date_to_f($date)."',category=".$category;
			$qry	.=" where code = ".$code.";";
 			$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			$status	="Changed Art #".$code;
		}
 		break;

		case "Images":
		header("location:".link_to_images($code,$hdg,$category,$txt,$date,$status,$err));
		exit;
		break;
		
		case "Comments":
		header("location:".link_to_comments($code,$hdg,$category,$txt,$date,$status,$err));
	 	exit;
		break;
		
		case "Add":
		$err.=Page::validate_required($hdg,"Heading");
		$err.=Page::validate_required($txt,"Text");
		if (!Page::testDt($date))
		{
			$err.="Date is not ddmmyyyy format.";
		}
 		if (strlen($err)==0)
		{
			$qry	="insert  into edart ";
			$qry	.=" (hdg,txt,category,artdate) ";
			$qry	.="values ('".$hdg."','".$txt."',".$category.",'".Page::date_to_f($date)."');";	
        	$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			$code	=mysql_insert_id();
			$status	="Added Art ".$code." ".$hdg;
		}
		break;
	
		case "Delete":
		$err.=Page::validate_required($code,"ID");
		if (strlen($err)==0)
		{
			$qry="delete from edart where code = ".$code.";";	
		   $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$hdg		=$txt=$date="";
			$category	=0;
			$status		="Deleted Art ".$code;
			$code=0;
		}
		break;
	
		case "Enquire":
		$err.=Page::validate_required($code,"ID");
		if (strlen($err)==0)
		{
			$qry="select hdg,txt,category,artdate from edart ";
			$qry.="where code=".$code.";";
		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if ( mysql_affected_rows() ==0)
			{
				$err	="Not found";
				$hdg	=$txt=$date="";
				$category=0;
			}
			else
			{	$hdg	=$row["hdg"];
				$txt	=$row["txt"];
			 	$date	=Page::date_to_s($row["artdate"]);
				$category=$row["category"];
				$status="Enquiry Succeeded";
			}
		}	
 	break;
	
	case "Clear":
	   $status	="Cleared";
	   $err		=  $code	=  $hdg		= $txt		=  $category=$date="";
		break;
	   
		case "List":
	print Page::hdr("M");
		?>
	<div class="container">
 
	<div class="row">
		<div class="col-sm-8"> 
		<h3>Art List</h3>
		<table>
		<tr>
			<th>Code&nbsp;</th>
			<th>Heading&nbsp;</th>
			<th>Category&nbsp;</th>
			<th>Date&nbsp;</th>
 		</tr>				
		
		<?php
		$qry="select a.code,a.txt,a.hdg,a.artdate,a.category, b.descr 
			from edart as a, edcategory as b
			where a.category = b.code		
			order by a.category, a.artdate;";   
		$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$code		=$row["code"];
			$txt		=$row["txt"];
			$hdg		=$row["hdg"];
			$date		=Page::date_to_s($row["artdate"]);
			$category	=$row["category"];
 			$status		='List-Item';
			$link		='<a href="'.link_here($code,$hdg,$category,$txt,$date,$status,$err).'">';
			print "<tr>";
			print "<td valign='top'>".$link.$row["code"].'</a></td>';
			print "<td valign='top'>".$link.$row["hdg"].'</a>&nbsp;</td>';
			print "<td valign='top'>".$row["descr"]."&nbsp;</td>";
			print "<td valign='top'>".Page::date_to_s2($row["artdate"])."&nbsp;</td>";
 			print "</tr>";				
		}
		?>
      </table>
	  <br/>
	  &nbsp;<form  method="POST" action='mngr_art.php'>
	     <input type='submit' value='exit'>
	</form>
 	</div>
    <div class="col-sm-4">
      <?php Page::Mngr_Menu();?>
    </div>
  </div>
</div>
</body>
</html>
<?php
	$status="Listed";
	exit;
default:
} 
header("location:".link_here($code,$hdg,$category,$txt,$date,$status,$err));
?>