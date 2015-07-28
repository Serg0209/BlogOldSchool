<?php
session_start();
?>
<style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}-->
</style>
<?php
error_reporting (0);
if(!isset($_SESSION["id"]))
{
	header("Location:http://localhost/blog/getout.htm");
}
else
{
$id=$_SESSION["id"];
$frndid=$_GET["addid"];
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");

if ($frndid != "" && $frndid != $id)
{
$query="insert into frnd values('$id','$frndid')";
$rs=mysql_query($query,$conn);
mysql_close($conn);
print "Bond created.";
}
mysql_close($conn);

print "<html><head><script>";
print "function fx()";
print "{ window.location='http://localhost/blog/friend_list.php'; }";
print '</script></head><body onload="fx()">Redirecting ...</body></html>';
}
?>