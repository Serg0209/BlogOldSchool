<html>
<head>
<style type="text/css">
body {
	background-color: #3A7CD0;
body,td,th {
	color: #FFFFFF;
}</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<?php
error_reporting (0);
$ID=trim($_GET["subID"]);

if ($ID == "" || strlen($ID)<4)
	print "You did not inserted a valid Topic Name !";
else
{
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");
$query="select id from topic2 where name='$ID'";
$rs=mysql_query($query,$conn);
$flag=mysql_num_rows($rs);
if ($flag==0)
	print "Hooray, it's available";
else
	print "Try another !.<br>This topic name already exist !";
}
?>
</html>