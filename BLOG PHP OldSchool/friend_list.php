<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{
header("Location:http://localhost/blog/getout.htm");
}
?>
<html>
<title>Web-Shine Forum Friend List</title><style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}
.style1 {
	color: #333333;
	font-weight: bold;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:hover {
	color: #999999;
	text-decoration: underline;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
body,td,th {
	color: #FFFFFF;
}
-->
</style>
<table width="650" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="4"><center>
      <span class="style1">My Friends List      </span>
    </center>    </td>
  </tr>
<?php
$id=$_SESSION["id"];
$cr=0;
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");
$query="select fid from frnd where id='$id'";
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs))
{
$query2="select name from login where id='$row[0]'";
$rs2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($rs2))
{
$temp=$row2[0];
}

 $cr=$cr+1;
 if ($cr>4)
 	print '<tr>'; 
 print '<td><center>';
 if (file_exists("profile_pic/".$row[0].".jpg")==1)
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[0].'" title="View this person"><img src="http://localhost/blog/profile_pic/'.$row[0].'.jpg" alt="'.$temp.'" border="2" />';
 else
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[0].'" title="View this person"><img src="http://localhost/blog/profile_pic/nopic.png" alt="'.$temp.'" border="2"/>';
 
 print '<br>'.$row[0].'</center></td>';
 if ($cr>4)
 	print '</tr>';
 if($cr>4)
	$cr=1;
}
mysql_close($conn);
?>
</table>
</html>