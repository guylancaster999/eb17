<?php
require "classes/classes.php";
Page::logged_in();
print Page::hdr("M");
DbAdmin::open_db();
?>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-8">
	<h3>Manage Comments</h3>
	<form action="do_mngr_comments.php" method="POST" ">
		  <table cellpadding="4">
			<tr>
				<th>Art Id&nbsp;</th>
				<th>Heading&nbsp;</th>
				<th>Comment&nbsp;</th>
			</tr>
			<?php
			$qry="select a.artid, a.code, a.descr, b.hdg  
					from edartcomment as a , edart as b
					where a.reviewedflag='N' and a.artid = b.code
					order by a.artid,a.code;";
			$result = mysql_query($qry) or die('Query '.$qry.' failed: ' . mysql_error());
			$ctr=0;	
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$ctr++;
				$artid	= $row["artid"];
				$hdg	= $row["hdg"];
				$code	= $row["code"];
				$comment= $row["descr"];
				$link	= "mngr_comment.php";
				$link	.="?artid=".$artid;
				$link	.="&hdg=".$hdg;
				$link	.="&id=".$code;
				$link   .="&descr=".$comment;
				print 	"<tr>";	
				print 	"<td>".$artid."</td>";
				print 	"<td>".$hdg."</td>";
				print 	"<td><a href='".$link."'>".$code.". ".$comment."</a></td>";
				print 	"</tr>";
			}
			print "</table><br/>";		
			if ($ctr==0)
			{
				print "No comments found to review";
			}
			else
			{
				print "<B>* Click on comment to review.</b> ";
			}
			?>
			</div>
		<div class="col-sm-4">
			<?php Page::Mngr_Menu();?>
		</div>
	</div>
</div>
</body>
</html>
