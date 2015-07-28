<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{
	header("Location:http://localhost/blog/getout.htm");
}
?>
<style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}-->
</style>
<?php
$tempid=$_GET["msgid"];
$id=$_SESSION["id"];

if ($tempid != "")
{
	$conn=mysql_connect("localhost","root","") or die("Connection Error !");
	$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");   
	$query="delete from msg where dest='$id' and idx='$tempid'";
	$rs=mysql_query($query,$conn);
	print "Deleted.<br>";
}
?>
<html><head><script>
function fx()
{
 window.location='http://localhost/blog/inbox.php';
}
</script></head>
<body onLoad="fx()">Redirecting ...</body>
</html>