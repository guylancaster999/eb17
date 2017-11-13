<?php
require "classes/classes.php";
Page::logged_in();
DbAdmin::open_db();
$crlf=chr(13).chr(10);
echo "<b>Backup Edart</b><br/>";
$qry		="select hdg,txt,category,artdate from edart;";
$result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
$flz		="";
$fid=date("ymdHi");
while ($row 	= mysql_fetch_array($result, MYSQL_ASSOC))
{
	$flz.='"'.$row["hdg"].'","'.$row["txt"].'","'.$row["category"].'","'.$row["artdate"].'"'.$crlf;		
}
$hdl=fopen("edart_".$fid.".csv","w");
fwrite($hdl,$flz);
fclose($hdl);
$flz="";

echo "<hr/>";
echo "<b>Backup Edartcomment</b><br/>";
$qry="select artid,code,descr,reply,reviewedflag from edartcomment;";
$result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
while ($row 	= mysql_fetch_array($result, MYSQL_ASSOC))
{
	$flz.='"'.$row["artid"].'","'.$row["code"].'","'.$row["descr"].'","'.$row["reply"].'","'.$row["reviewedflag"].'"'.$crlf;		
}
$hdl=fopen("edartcomment_".$fid.".csv","w");
fwrite($hdl,$flz);
fclose($hdl);
$flz="";

echo "<hr/>";
echo "<b>Backup Edartimg</b><br/>";
$qry="select artid,code,descr,filenm from edartimg;";
$result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
while ($row 	= mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo '"'.$row["artid"].'","'.$row["code"].'","'.$row["descr"].'","'.$row["filenm"].'"'.$crlf;		
	//copy filenm
}
echo "<hr/>";
echo "<b>Backup Edcategory</b><br/>";
$qry="select descr, ordr, colr,font,fontsize,fontweight,italic from edcategory ";
$result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
while ($row 	= mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo '"'.$row["descr"].'","'.$row["ordr"].'","'.$row["colr"].'","'.$row["font"].'","'.$row["fontsize"].'"'.
	$row["fontweight"].'"'.'","'.$row["italic"].'"'.$crlf;			
}
 echo "<hr/>"; 
echo "<b>Backup Edelement</b><br/>";
$qry		="select code,descr,color,font,fontweight,fontsize,italic 	from edelement;";   
$result 	= mysql_query($qry) or die('Query failed: ' . mysql_error());
while ($row 	= mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo '"'.$row["code"].'","'.$row["descr"].'","'.$row["color"].'","'.$row["font"].'","'.$row["fontweight"].'","'.$row["fontsize"].'","'.$row["italic"].'"'.$crlf;		
}
print "<hr/>";
?>