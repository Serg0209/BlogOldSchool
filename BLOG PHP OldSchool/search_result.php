<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{	header("Location:http://localhost/blog/getout.htm");
}
?>
<style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}
a:link {
	color: #333333;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: underline;
	color: #FFFFFF;
}
a:active {
	text-decoration: none;
	color: #333333;
}
-->
</style>
<?php
$tempid=trim($_GET["proid"]);
$tempid2=trim($_GET["subid"]);

if (($tempid == "" || strlen($tempid)<3 || strlen($tempid)>20) && ($tempid2 == "" || strlen($tempid2)<3 || strlen($tempid2)>20))
	print "Sorry, you did not inserted a valid quiery.<br>Please try again !.";
else
{
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");   

if ($tempid2 == "")
{	//search profile
	$query="select name,id,msg,tym from login where id like '$tempid%'";
}	
else	//search topic
{
	$query="select name,id,cr_time2 from topic2 where name like '$tempid2%' order by cr_time desc";	
}
$rs=mysql_query($query,$conn);
$flag=mysql_num_rows($rs);

if ($flag == 0)
	print "<b>Your search did not returned any results.<br></b>";
else
{
if ($tempid2 == "")
{
echo "Profile Search result for<b> ".$tempid."</b><hr>";
print '<table width="650" border="0" align="center" cellpadding="1" cellspacing="1">';
print "<tr><td><center><u> Name </u></center></td>";
print "<td><center><u> Message </u></center></td>";
print "<td><center><u> Member Since </u></center></td></tr>";
while($row=mysql_fetch_array($rs))
{
print '<tr><td valign="middle">';
if (file_exists("profile_pic/".$row[1].".jpg")==1)
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[1].'" title="View this person"><img src="http://localhost/blog/profile_pic/'.$row[1].'.jpg" alt="'.$row[0].'" border="2" />';
else
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[1].'" title="View this person"><img src="http://localhost/blog/profile_pic/nopic.png" alt="'.$row[0].'" border="2"/>';
print '<br><b> '.$row[0].'</center></td></a>';
print '<td><center><b> '.nl2br($row[2]).'</center></td>';
print '<td><center><b> '.$row[3].'</center></td></tr>';
}
print '</table>';
}

if ($tempid == "")
{
echo "Search result for Topic - <b> ".$tempid2."</b><hr>";
print '<table width="650" border="0" align="center" cellpadding="1" cellspacing="1">';
print "<tr><td><center><u> Name </u></center></td>";
print "<td><center><u> Creator </u></center></td>";
print "<td><center><u> Created On </u></center></td>";
print "<td><center><u> Last reply received on </u></center></td>";
print "<td><center><u> Posts </u></center></td></tr>";

while($row=mysql_fetch_array($rs))
{
print '<tr><td><center><a href="http://localhost/blog/subject.php?subid='.$row[0].'" title="View this topic"><b>'.$row[0].'</b></a></center></td>';
print '<td><center><b><a href="http://localhost/blog/profile_details.php?proid='.$row[1].'" title="View this topic">'.$row[1].'</b></center></td>';
print '<td><center><b>'.$row[2].'</b></center></td>';

$query2="select tym2 from topic where idx=(select max(idx) from topic where topic_name='".$row[0]."')";
$rs2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($rs2))
{
$temp=$row2[0];
}
print '<td><center><b>'.$temp.'</b></center></td>';

$query2="select idx from topic where topic_name='".$row[0]."'";
$rs2=mysql_query($query2,$conn);
$flag2=mysql_num_rows($rs2);
print '<td><center><b>'.$flag2.'</b></center></td></tr>';
}
print '</table>';
}
}
mysql_close($conn);
}
?>