<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{
	header("Location:http://localhost/blog/getout.htm");
}
$id=$_SESSION["id"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Web-Shine Forum Topic List</title>
<style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}
.tab
{
    display:            block;

    white-space:        nowrap;
    background-color:   #FF9900;
    border:             2pt solid #D5D5D5;
    border-top-left-radius: 0.2em;
    border-top-right-radius: 0.2em;
	width: 40px;
	font-size: 11px;
	border-style: dashed;
	border-color:black;
}

a.tab:hover
{
    margin:             0;
    padding:            0.1em 0.2em 0.1em 0.2em;
	background-color:   #FF3300;
	font-size: 12px;
	font-wight: bold;	
	border-style: double;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #000066;
}
a:active {
	text-decoration: none;
}
.style1 {
	color: #333333;
	font-size: x-small;
	font-weight: bold;
}
#container
{
width:850px;
margin:0 auto;
padding:3px 0;
text-align:left;
position:relative;
-moz-border-radius: 15px;
-webkit-border-radius: 6px;
background-color:#6BACE6;
}
-->
</style>
<script>
function reload()
{
for(i=0;i<document.frm.select.length;i++)
{
if (document.frm.select[i].selected)
	vtym=document.frm.select.options[i].value;
}
window.location="http://localhost/blog/topic.php?catID="+vtym;
}
</script>
</head>

<body>
<form name="frm">
<p align="right"><span class="style1">Select Topic Category</span>
  <select name="select" onchange="reload()">
    <option value="sw">Software</option>
    <option value="hw">Hardware</option>
    <option value="os">Operating System</option>
    <option value="oth">Other / Chit-Chat</option>
    <option value="all" selected="selected">All</option>
  </select>
</form>
</p>

<div id="container" >
<table width="836" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td width="218"><center>
      <em> <strong> Topic </strong> </em>
    </center></td>
    <td width="182"><center>
      <em> <strong> Created By </strong> </em>
    </center></td>
    <td width="175"><center>
      <em> <strong> Creation Time </strong> </em>
    </center></td>
    <td width="183"><center>
      <em> <strong> Last Reply On </strong> </em>
    </center></td>
    <td width="50"><center>
      <em> <strong> Posts </strong> </em>
    </center></td>
  </tr>

<?php
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");

$dtid=$_GET["DelTId"];
$catID=$_GET["catID"];

if ($dtid != "")
{
	$query="delete from topic2 where name='$dtid' and id='$id'";
	$rs=mysql_query($query,$conn);
	$query="delete from topic where topic_name='$dtid'";
	$rs=mysql_query($query,$conn);
	if (!headers_sent())
	{
		header("Location:http://localhost/blog/topic.php");
		exit;
	}
	print '<a href="http://localhost/blog/topic.php">Back to Topic</a>';
}

if ($catID == "")
	$catID="all";

if ($catID == "sw")
{
	print '<img src="http://localhost/blog/img/sw.png" alt="Category Software"/>';
	$query="select * from topic2 where cat='sw'";
	$rs=mysql_query($query,$conn);
}
if ($catID == "hw")
{
	print '<img src="http://localhost/blog/img/hw.png" alt="Category Hardware"/>';
	$query="select * from topic2 where cat='hw'";
	$rs=mysql_query($query,$conn);
}
if ($catID == "os")
{
	print '<img src="http://localhost/blog/img/os.jpg" alt="Category Operating System"/>';
	$query="select * from topic2 where cat='os'";
	$rs=mysql_query($query,$conn);
}
if ($catID == "oth")
{
	print '<img src="http://localhost/blog/img/oth.png" alt="Category Others"/>';
	$query="select * from topic2 where cat='oth'";
	$rs=mysql_query($query,$conn);
}
if ($catID == "all")
{
	$query="select * from topic2";
	$rs=mysql_query($query,$conn);
}

$flag=mysql_num_rows($rs);

if ($flag==0)
	print "<tr><td>No Topic available.</td><td></td><td></td><td></td><td></td></tr>";
else
{
while($row=mysql_fetch_array($rs))
{
print '<tr>';
print '<td width="218"><center><a href='.'"http://localhost/blog/subject.php?subid='.$row[0].'" title="View this topic"><b>'.$row[0].'</b></a>';
if ($row[1] == $_SESSION["id"])
{
print '<a class="tab" title="Delete this topic" href="http://localhost/blog/topic.php?DelTId='.$row[0].'">Delete</a>';
}
print '</center></td>';

$query2="select name from login where id='".$row[1]."'";
$rs2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($rs2))
{
	$author=$row2[0];
}
print '<td width="182"><center><a href='.'"http://localhost/blog/profile_details.php?proid='.$row[1].'" title="View this profile">'.$author.'  ['.$row[1].']</center></td>';

print '<td width="182"><center>'.$row[3].'</center></td>';

$query2="select tym2 from topic where idx=(select max(idx) from topic where topic_name='".$row[0]."')";
$rs2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($rs2))
{
$temp=$row2[0];
}
if ($temp == "")
	$temp = "No Reply.";
print '<td width="175"><center>'.$temp.'</center></td>';

$query2="select idx from topic where topic_name='".$row[0]."'";
$rs2=mysql_query($query2,$conn);
$flag2=mysql_num_rows($rs2);
print '<td width="75"><center>'.$flag2.'</center></td>';
print '<tr>';
}
}
mysql_close($conn);
?>
</table>
</div>
</body>
</html>