<?php
session_start();
error_reporting (0);
$key2=$_SESSION["hash"];

$id=trim(strtolower($_POST['id']));
$pass=trim($_POST['pass']);
$pass2=trim($_POST['ans']);
$name=trim($_POST['name']);
$msg=trim($_POST['msg']);
$key=trim($_POST['key']);
$time=date("d-m-Y");
$err="";

if ($id == "user" || $id == "admin" || $id == "system" || $id == "roote" || $id == "web-shine")
	$err = "Sorry, you have typed a Reserved ID.<br>";
if (strlen($id) <6 || strlen($id)>10)
	$err = $err + "ID Length must be within 6 to 10.<br>";
if (strlen($pass) <6 || strlen($pass)>10)
	$err = $err + "Password Length must be within 6 to 8.<br>";
if (strlen($pass2) != 4)
	$err = $err + "Security Code Length must be 4.<br>";
if (strlen($name) <4 || strlen($name)>20)
	$err = $err + "Name Length must be within 4 to 20.<br>";
if (strlen($msg) <4 || strlen($msg)>20)
	$err = $err + "Message Length must be within 4 to 160.<br>";

if($id == "")
	$err = $err + "Please insert a correct ID.<br>";
if($pass == "")
	$err = $err + "Please insert a valid password.<br>";
if($pass2 == "")
	$err = $err + "Please insert a valid security code.<br>";
if($name == "")
	$err = $err + "You do not have any name ?<br>";
if($msg == "")
	$err = $err + "No view ?<br>";
if($key == "")
	$err = $err + "Please insert text from the security image.<br>";

if (strcasecmp ($key,$key2) != 0)
	$err = $err + "Failed to pass CAPTCHA TEST.<br>Are you a machine ?";

if($err == "")
{
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");   
$query="insert into login values('$id','$pass','$pass2','$name','$msg','$time')";
$rs=mysql_query($query,$conn);

if($rs)
{	
	$_SESSION["id"]=$id;
	$_SESSION["name"]=$name;
	$_SESSION["msg"]=$msg;
	
	if (!headers_sent())
	{
		header("Location:http://localhost/blog/forum.htm");
		exit;
	}
//	echo "Welcome to Web-Shine Blog.<br>";
}
else
{
	$er="Unknown Error !";
	$er = "<font color='red'><b>Error Log:<br></b><font color='orange'>" . $er;
	echo $er;
}
mysql_close($conn);
}
else
{
	print "<font color='red'><b>Errors</b><br>";
	print $err;
}
?>
<style type="text/css">
<!--
body {
	background-color: #66CCFF;
}
-->
</style>