<?php
session_start();
error_reporting (0);
	$id=trim($_POST['username']);
	$pass=trim($_POST['password']);
if ($id != "" and $pass != "")
{	$conn=mysql_connect("localhost","root","") or die("Connection Error !");
	$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");  
	$query="select * from login where id='$id' and pass='$pass'";
	$rs=mysql_query($query,$conn);
	$flag=mysql_num_rows($rs);
	if ($flag == 1)
	{
	while($row=mysql_fetch_array($rs))
	{
		$_SESSION["name"]=$row["name"];
		$_SESSION["msg"]=$row["msg"];		
	}
		$_SESSION["id"]=$id;

		if (!headers_sent())
	{
		header("Location:http://localhost/blog/forum.htm");
		exit;
	}

	mysql_close($conn);
	}
	else
	{
	$_SESSION["strmsg"]="Incorrect ID or Password.";
	   	if (!headers_sent())
	{
		header("Location:http://localhost/blog/login.php");
		exit;
	}		
	}
}
else
{
	$_SESSION["strmsg"]="Invalid ID or Password.";
	if (!headers_sent())
{
    header("Location:http://localhost/blog/login.php");
    exit;
}
}
?>
<html>
<style type="text/css">
<!--
body {
	background-color: #66CCFF;
}
-->
</style>
</html>