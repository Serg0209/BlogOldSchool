<html>
<head>
<style type="text/css">
body {
	background-color: #3A7CD0;
.style1 {color: #FFFFFF}
body,td,th {
	color: #FFFFFF;
}</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<?php
error_reporting (0);
$ID=trim($_GET["ID"]);

if ($ID == "" || strlen($ID)<4 || strlen($ID)>20)
	print "You did not inserted a valid Login ID !";
else if ($ID == "user" || $ID == "admin" || $ID == "system" || $ID == "roote" || $ID == "web-shine")
	$err = "Sorry, you have typed a Reserved ID.</br>";
else
{
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");
$query="select name from login where id='$ID'";
$rs=mysql_query($query,$conn);
$flag=mysql_num_rows($rs);
if ($flag==0)
	print "Hooray, it's available.";
else
	print "Try another !<br>This ID is taken.";
}
mysql_close($conn);
?>

</html>