<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{
	header("Location:http://localhost/blog/getout.htm");
}
?>
<html>
<head>
<title>Web-Shine Forum Subject Details</title>

<script language="javascript">
function count()
{ var txt;
 txt = document.form1.scrap.value;
 document.form1.counter.value = 500 - txt.length;
if (document.form1.counter.value<0)
	document.form1.scrap.value = txt.substring(0,499);
}

function fx()
{
 var txt;
 txt = document.form1.scrap.value;
 if (txt.length <=5 )
	alert ('Minimum view length 6 letters');
 else
	form1.submit();
}
</script>
<style type="text/css">
<!--
body{padding: 10px;background-color: #3A7CD0; font: 100.01% "Trebuchet MS",Verdana,Arial,sans-serif}
h1,h2,p{margin: 0 10px}
h1{font-size: 250%;color: #FFF}
h2{font-size: 200%;color: #f0f0f0}
p{padding-bottom:1em}
h2{padding-top: 0.3em}

div#nifty{ margin: 0 5%;background: #3156B1}
b.rtop, b.rbottom{display:block;background: #3A7CD0}
b.rtop b, b.rbottom b{display:block;height: 1px; overflow: hidden; background: #0B3C77}
b.r1{margin: 0 5px}
b.r2{margin: 0 3px}
b.r3{margin: 0 2px}
b.rtop b.r4, b.rbottom b.r4{margin: 0 1px;height: 5px}

#container
{
width:700px;
margin:0 auto;
padding:3px 0;
position:relative;
-moz-border-radius: 15px;
-webkit-border-radius: 6px;
background-color:#6BACE6;
text-align:center;
}


.style1 {color: #666666}

a:link {
	text-decoration: none;
	color: #000033;
}
a:visited {
	text-decoration: none;
	color: #CCCCCC;
}
a:hover {
	text-decoration: underline;
	color: #FFFFFF;
}
a:active {
	text-decoration: none;
	color: #CCCCCC;
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
	font-size: 12px;
	border-style: dashed;
	border-color:black;	
}

a.tab:hover
{
    margin:             0;
    padding:            0.1em 0.2em 0.1em 0.2em;
	background-color:   orange;
	font-size: 12px;
	font-wight: bold;
	border-style: double;
}
body,td,th {
	color: #FFFFFF;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<?php
$id=$_SESSION["id"];
$subid=$_GET['subid'];
if ($subid != "")
	$_SESSION["subid"]=$subid;
else
	$subid=$_SESSION["subid"];

$DelId=$_GET['DelMsgId'];
$msg=$_POST['scrap'];
$time2=date("d-m-Y  H:i:s");
$err="";
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!"); 

if($id == "")
	$err = "Please Login.<br>";
if($msg == "")
	$err = "No message ?<br>";

if ($DelId != "")
{
	$query="select topic_name from topic where idx='$DelId' and id='$id'";
	$rs=mysql_query($query,$conn);
	$flag=mysql_num_rows($rs);

if ($flag==0)
	print "<b>Sorry Can't Delete.</b>";
else
{
	$query="delete from topic where idx='$DelId'";
	$rs=mysql_query($query,$conn);
}
	if (!headers_sent())
	{
		header("Location:http://localhost/blog/subject.php?subid=".$_SESSION["subid"]);
		exit;
	}
}

if ($msg == $_SESSION["prev_msg"] && $msg != "")
	print " ";
else
{
	if ($msg != "" && $_SESSION["prev_msg"] != $msg)
{
$_SESSION["prev_msg"]=$msg;
$subid=$_SESSION["subid"];
$msg = str_replace ('"', '&quot;', $msg);
$msg = str_replace ("'", "&#8216;", $msg);
$msg = strip_tags($msg);
$query="insert into topic(topic_name,msg,tym2,id) values('$subid','$msg','$time2','$id')";
$rs=mysql_query($query,$conn);
mysql_close($conn);
}
}

$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");  
$query="select * from topic where topic_name='$subid' order by idx";
$rs=mysql_query($query,$conn);
$flag=mysql_num_rows($rs);

if ($flag==0)
	print "<b>No details available.</b>";	
else
{
while($row=mysql_fetch_array($rs))
{
?>
<div id="nifty">
<b class="rtop">
<b class="r1"></b>
<b class="r2"></b>
<b class="r3"></b>
<b class="r4"></b>
</b>
<?php
if (file_exists("profile_pic/".$row[3].".jpg")==1)
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[3].'" title="View this person"> <img src="http://localhost/blog/profile_pic/'.$row[3].'.jpg" alt="'.$row[3].'" border="2" style="border-color:#26458C"/></a><br>';
else
	print '<a href="http://localhost/blog/profile_details.php?proid='.$row[3].'" title="View this person"> <img src="http://localhost/blog/profile_pic/nopic.png" alt="'.$row[3].'" border="2" style="border-color:#26458C"/></a><br>';

$query2="select name from login where id='".$row[3]."'";
$rs2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($rs2))
{
	$author=$row2[0];
}
print "Posted By -> <b><a href='http://localhost/blog/profile_details.php?proid=".$row[3]."' title='View this person'>".$author."</a></b><br>";
print "Message -> <b>".nl2br($row[1])."</b><br>";
print "On -><i> ".$row[2]."</i><br>";
if ($_SESSION["id"]==$row[3])
{
	print "<p align='right'>";
	print '<a href="http://localhost/blog/subject.php?DelMsgId='.$row[4].'" title="Delete this post" class="tab">Delete</a>';
	print "</p>";
}
?>
<b class="rbottom">
<b class="r4"></b>
<b class="r3"></b>
<b class="r2"></b>
<b class="r1"></b>
</b>
</div>
<br>
<?php
}
}
$_SESSION["url"]="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$query="select id from topic2 where name='$subid'";
$rs=mysql_query($query,$conn);
$flag=mysql_num_rows($rs);
if ($flag==1)
{
?>
<div id="container" >
<form id="form1" name="form1" method="post" action="<?php print 'http://localhost/blog/subject.php?subid='.$subid; ?> ">
  <table width="700" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr><td><center>
        Write your views !           <br/>
        <textarea name="scrap" cols="60" rows="4" onKeyDown="count()" title="Write your view" onKeyUp="count()"></textarea>        
        <br/><span class="style1">Letters Remaining </span>
        <input name="counter" title="Number of Letters you can type." type="text" id="counter" value="500" size="3" maxlength="3" readonly="true" />
		<br/><font size="2">HTML Tag is off.</font><br/>
        <input type="button" name="Submit" value="Submit" title="Submit your view" onClick="fx()"/>
        <input type="reset" name="Submit3" value="Reset" title="Clear your view" />
    </center> </td> </tr>
  </table>
</form>
</div>
<?php
}
mysql_close($conn);
?>
</body>
</html>