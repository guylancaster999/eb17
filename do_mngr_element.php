<?php
require "classes/classes.php";
Page::logged_in();
$submit 		= $_POST["submit"];
$code   		= $_POST["code"];
$descr    		= $_POST["descr"];
$font   		= $_POST["font"];
$color    		= strtoupper($_POST["color"]);
$fontweight    	= $_POST["fontweight"];
$fontsize   	= $_POST["fontsize"];
$italic			= ($_POST["italic"]=="Y" ?"Y":"N");
$err    		= "";
$status 		= "";
DbAdmin::open_db();

if (strlen($err)==0)
	switch ($submit)
	{
		case "Add":
		$err.=Page::validate_required($code,"Code");
		$err.=Page::validate_required($descr,"Description");
		$err.=Page::validate_required($font,"Font");
		$err.=Page::validate_colour($color,"");
		$err.=Page::validate_required($fontsize,"Fontsize");
		$err.=Page::validate_required($fontweight,"Fontweight");
	 
	 if (strlen($err)==0)
		{
		   $qry		="select *  from edelement where code='".$code."';";   
		   $result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
		   $row 	= mysql_fetch_array($result, MYSQL_ASSOC);
			if (mysql_affected_rows() > 0)
			{
				$err="Code ".$code." aready exists. ";
			}
		}		
		if (strlen($err)==0)
		{
			$qry="insert  into edelement ";
			$qry.=" (code,descr,color,font,fontweight,fontsize,italic) ";
			$qry.="values ('".$code."','".$descr."','".$color."','".$font."',".$fontweight.",".$fontsize.",'".$italic."');";	
        	$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$status="Added Element #".$code." ".$descr;
		}
		break;
	
		case "Delete":
		$err.=Page::validate_required($code,"ID");

		if (strlen($err)==0)
		{
 			$qry="delete from edelement where code = '".$code."';";	
		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$code="";
			$descr="";
			$status="Deleted Element ".$element;
			$code="";
			$descr="";
			$italic="N";
		}
		break;
	
		case "Change":
		$err.=Page::validate_required($code,"ID");
		$err.=Page::validate_required($descr,"Desription");
		$err.=Page::validate_required($font,"Font");
		$err.=Page::validate_colour($color,"Colour");
		$err.=Page::validate_required($fontsize,"Fontsize");
		$err.=Page::validate_required($fontweight,"Fontweight");
	
		if (strlen($err)==0)
		{
			$qry="update edelement ";
			$qry.=" set descr='".$descr."',font='".$font."',color='".$color."',fontsize=".$fontsize.", italic='".$italic."', fontweight=".$fontweight." ";
			$qry.=" where code = '".$code."';";
			$result = mysql_query($qry) or die('Query ".$qry." failed: ' . mysql_error());
			$status="Changed Element #".$code." ".$descr;
		}		
		 break;
	
		case "Enquire":
		$err.=Page::validate_required($code,"ID");
		if (strlen($err)==0)
		{
			$qry	="select descr,color,font,fontsize,fontweight,italic ";
			$qry	.=" from edelement ";
			$qry	.="where code='".$code."';";
		    $result = mysql_query($qry) or die('Query failed: ' . mysql_error());
			$row 	= mysql_fetch_array($result, MYSQL_ASSOC);
			if ( mysql_affected_rows() ==0)
			{
				$err="Not found";
		 	}
			else
			{	
				$descr		=$row["descr"];
				$color		=$row["color"];
				$font		=$row["font"];
				$fontweight	=$row["fontweight"];
				$fontsize	=$row["fontsize"];
				$italic		=$row["italic"];
				$status="Enquiry Succeeded";
			}
		}	
	break;
	   case "Clear":
	   $descr="";
	   $font="Arial";
	   $fontweight=100;
	   $fontsize=10;
	   $color="000000";
	   $status	="Cleared";
	   $italic  ="N";
	   $err		="";
	   $code	="";
	   $descr	="";
	   break;
	   
		case "List":
	print Page::hdr("M");
		?>
	<div class="container">
 
	<div class="row">
		<div class="col-sm-8"> 
		<h3>System Fonts List</h3>
		<table>
		<tr>
			<th>Code&nbsp;</th>
			<th>Description</th>
			<th>Color&nbsp;</th>
			<th>Font&nbsp;</th>
			<th>Size&nbsp;</th>
			<th>Weight&nbsp;</th>
			<th>Italic</th>
		</tr>				
		<?php
		$qry="select code, descr,color,font,fontsize,fontweight,italic
		from edelement 	
		order by code;";   
		$result = mysql_query($qry) or die('Query failed: ' . mysql_error());
		
		while( $row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$code		=$row["code"];
			$descr		=$row["descr"];
			$color		=$row["color"];
			$font		=$row["font"];
			$fontsize	=$row["fontsize"];
			$fontweight	=$row["fontweight"];
			$italic 	=$row["italic"];
			$link='<a href="mngr_element.php';
			$link.='?code='.$code;
			$link.='&descr='.$descr;
			$link.='&color='.$color;
			$link.='&font='.str_replace(",","^",$font);
			$link.='&fontsize='.$fontsize;
			$link.='&fontweight='.$fontweight;
			$link.='&italic='.$italic;
			$link.='&status=List-Item';
			$link.='&err=">';
			print "<tr>";
			print "<td valign='top'>".$link.$code.'</a>&nbsp;</td>';
			print "<td valign='top'>".$link.$descr.'</a>&nbsp;</td>';
			print "<td valign='top'>".$color."&nbsp;</td>";
			print "<td valign='top'>".$font."&nbsp;</td>";
			print "<td valign='top'>".$fontsize."&nbsp;</td>";
			print "<td valign='top'>".$fontweight."</td>";
			print "<td valign='top'>".$italic."</td>";
			print "</tr>";				
		}
		?> 
      </table>
	  <br/>
	  &nbsp;<form  method="POST" action='mngr_element.php'>
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
	}

$loc="Location: mngr_element.php";
$loc.="?err=".$err;
$loc.="&code=".$code;
$loc.="&descr=".$descr;
$loc.="&color=".$color;
$loc.="&font=".str_replace(",","^",$font);
$loc.="&fontsize=".$fontsize;
$loc.="&fontweight=".$fontweight;
$loc.="&italic=".$italic;
$loc.="&status=".$status;
header($loc);
?>