<?php
require "classes/classes.php";
Page::logged_in();
$submit 	= $_POST["submit"];
$descr  	= $_POST["descr"];
$ordr   	= $_POST["ordr"];
$code   	= $_POST["code"];
$colr		= strtoupper($_POST["colr"]);
$fontsize	=$_POST["fontsize"];
$font		=$_POST["font"];
$fontweight	=$_POST["fontweight"];
$italic		=($_POST["italic"]=="Y" ? "Y" : "N");
$err    	= "";
$status 	= "";
DbAdmin::open_db();

if (strlen($err)==0)
{
	switch ($submit)
	{
		case "Add":
		$colr		=Page::default_blank($colr,'000000');
		$fontweight	=Page::default_blank($fontweight,'100');
		$fontsize	=Page::default_blank($fontsize,'10');
		$ordr		=Page::default_blank($ordr,"1");
		$font		=Page::default_blank($font,"Arial");
		$err		.=Page::validate_required($font,"Font");
		$err		.=Page::validate_required($descr,"Description");
		$err		.=Page::validate_colour($colr);
		$err		.=Page::validate_fontsize($fontsize);
		$err		.=Page::validate_fontweight($fontweight);
		
		if (strlen($err)==0)
		{
		   $qry="select *  from edcategory where descr='".$descr."';";   
		   $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		   $row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (mysql_affected_rows() > 0)
			{
				$err="Category ".$descr." aready exists";
			}
		}		
		if (strlen($err)==0)
		{
			$qry="insert  into edcategory ";
			$qry.=" (descr, ordr, colr,font,fontsize,fontweight,italic) ";
			$qry.="values ('".$descr."',".$ordr.",'".$colr."','".$font."',".$fontsize.",".$fontweight.",'".$italic."');";	
          	$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$status="Added Category ".$descr;
		}
		break;
	
		case "Delete":
		$err		.=Page::validate_required($code,"ID");
		if (strlen($err)==0)
		{
		   $qry="select code,descr from edcategory where code ='".$code."';";   
		   $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (mysql_affected_rows() == 0)
			{
				$err="Category ID ".$code ." does not exist.";
			}
			else 
			{
				$descr=$row["descr"];
			}
		}		
		if (strlen($err)==0)
		{
			$qry	="select count(*) as ctr from edart where category  = ".$code;
			$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row 	= mysql_fetch_array($result, MYSQL_ASSOC);
			$ctr	=$row["ctr"];
			if ($ctr>0)
			{
				$err.="Category ".$code." ".$descr." has ".($ctr==1? " 1 Article ":$ctr." articles")." - can not delete.";
			}
		}
		if (strlen($err)==0)
		{
			$qry="delete from edcategory where code = ".$code.";";	
		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$descr="";
			$ordr=0;
			$status="Deleted category ".$code;
			$code=0;
		}
		break;
	
		case "Change":
		$colr		=Page::default_blank($colr,'000000');
		$font		=Page::default_blank($font,'Arial');
		$fontweight	=Page::default_blank($fontweight,'100');
		$fontsize	=Page::default_blank($fontsize,'10');
		$ordr		=Page::default_blank($ordr,"1");
		$err		.=Page::validate_required($code,"ID");
		$err		.=Page::validate_required($descr,"Description");
		$err		.=Page::validate_required($font,"Font");
		$err		.=Page::validate_colour($colr);
		$err		.=Page::validate_fontsize($fontsize);
		$err		.=Page::validate_fontweight($fontweight);

		if (strlen($err)==0)
		{
			$qry	="select code from edcategory where code='".$code."';";   
			$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row 	= mysql_fetch_array($result, MYSQL_ASSOC);
			  
			if ( mysql_affected_rows() == 0)
			{
				$err="Category ID does not exist";
			}
		}		
		if (strlen($err)==0)
		{
			$code=$row['code'];
			$qry="update edcategory ";
			$qry.=" set italic='".$italic."',descr='".$descr."', ordr=".$ordr.", colr='".$colr."', font='".$font."', fontsize=".$fontsize.",fontweight=".$fontweight;
			$qry.=" where code = ".$code.";";
 		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$status="Changed category ".$code." ".$descr;
		}
		break;
	
		case "Enquire":
		$err		.=Page::validate_required($code,"ID");
		if (strlen($err)==0)
		{
			$qry="select descr,ordr,colr, font, fontsize, fontweight, italic ";
			$qry.=" from edcategory where code=".$code.";";
		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if ( mysql_affected_rows() ==0)
			{
				$err		="Not found";
				$descr		="";
				$fontweight	="100";
				$fontsize	="10";
				$italic		="N";
				$colr		='000000';
				$ordr		=0;
			}
			else
			{
				$descr		=$row["descr"];
				$ordr		=$row["ordr"];
				$colr		=$row['colr'];
				$status		="Enquiry on ".$code." succeeded.";
				$font  		=$row["font"];
				$fontsize	=$row["fontsize"];
				$fontweight	=$row["fontweight"];
				$italic		=$row["italic"];
			}
		}	
	break;
	   case "Clear":
	   $status="Cleared";
	   $err			="";
	   $code		="";
	   $descr		="";
	   $ordr		="";
	   $font		="Arial";
	   $fontweight	="100";
	   $fontsize	="10";
	   $italic		="N";
	   $colr		='000000';
	   break;
	   
		case "List":
		print Page::hdr("M");
		?>
	<div class="container">
 
	<div class="row">
		<div class="col-sm-8"> 
		<h3>Category List</h3>
		<table >
		<tr>
			<th>Code&nbsp;</th>
			<th>Description&nbsp;</th>
			<th>Order&nbsp;</th>
			<th>Colour</th>
			<th>Font&nbsp;</th>
			<th>Weight&nbsp;</th>
			<th>Size&nbsp;</th>
			<th>Italic</th>
		</tr>				
		<?php
		$qry="select code,descr,ordr,colr,font,fontweight,fontsize,italic ";
		$qry.=" from edcategory ";
		$qry.=" order by ordr;";   
		$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$code		=$row["code"];
			$descr		=$row["descr"];
			$ordr		=$row["ordr"];
			$colr		=$row["colr"];
			$font		= $row["font"];
			$fontweight	=$row["fontweight"];
			$fontsize	=$row["fontsize"];
			$italic		=$row["italic"];
			$link='<a href="mngr_category.php';
			$link.='?code='.$code;
			$link.='&descr='.$descr;
			$link.='&ordr='.$ordr;
			$link.='&colr='.$colr;
			$link.='&font='.str_replace(",","^",$font);
			$link.='&fontweight='.$fontweight;
			$link.='&fontsize='.$fontsize;
			$link.='&italic='.$italic;
			$link.='&status=';
			$link.='List-Item';
			$link.='&err=">';
			print "<tr>";
			print "<td valign='top'>".$link.$code.'</a></td>';
			print "<td valign='top'>".$link.$descr.'</a>&nbsp;</td>';
			print "<td valign='top'>".$ordr."</td>";
			print "<td valign='top'>".$colr."&nbsp;</td>";
			print "<td valign='top'>".$font."&nbsp;</td>";
			print "<td valign='top'>".$fontweight."</td>";
			print "<td valign='top'>".$fontsize."</td>";
			print "<td valign='top'>".($italic=="N"?"No":"Yes")."</td>";
			print "</tr>";				
		}
		?>
      </table>
	  <blockquote>
	  <form action='mngr_category.php'><input type='submit' value='exit'></form>
	 </blockquote>
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
		break;
	}
}
$loc="Location: mngr_category.php";
$loc.="?err=".$err;
$loc.="&code=".$code;
$loc.="&descr=".$descr;
$loc.="&ordr=".$ordr;
$loc.="&colr=".$colr;
$loc.="&font=".str_replace(",","^",$font);
$loc.="&fontsize=".$fontsize;
$loc.="&fontweight=".$fontweight;
$loc.="&italic=".$italic;
$loc.="&status=".$status;
header($loc);
?>