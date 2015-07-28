<?php
session_start();
error_reporting (0);
if(!isset($_SESSION["id"]))
{
	header("Location:http://localhost/blog/getout.htm");
}
$id=$_SESSION["id"];
$key=$_SESSION["hash"];
$name=trim($_POST['name']);
$msg=trim($_POST['scrap']);
$key2=$_POST['code'];
$cat=$_POST['cat'];
$time=date("dmYHis");
$time2=date("d-m-Y  H:i:s");
$err="";
if (strlen($name)<4)
	$err = "Topic name should be atleast 4 letters.<br>";
if (strlen($name)>60)
	$err = $err + "Topic name should be less than 60 letters.<br>";
if (strlen($msg)<6)
	$err = $err + "Minimum view length should be 6 letters.<br>";
	
if($id == "")
	$err = $err + "Please Login.<br>";
if($name == "")
	$err = "No topic name ?<br>";
if($msg == "")
	$err = "No view ?<br>";

if (strcasecmp ($key,$key2) != 0)
	$err = "Failed to pass CAPTCHA TEST.<br>Are you a machine ?";

if($err == "")
{
$conn=mysql_connect("localhost","root","") or die("Connection Error !");
$mydb=mysql_select_db("blog",$conn) or die("Database Error !!");    
$query="insert into topic2 values('$name','$id','$time','$time2','$cat')";
$rs=mysql_query($query,$conn);

if($rs)
{
//	echo "Topic created Successfully.<br>";		

	$query="insert into topic(topic_name,msg,tym2,id) values('$name','$msg','$time2','$id')";
	$rs=mysql_query($query,$conn);

//	echo "View Submitted";
		
	if (!headers_sent())
	{
		header("Location:http://localhost/blog/topic.php");
		exit;
	}
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
	print $err;
?>
<style type="text/css">
<!--
body {
	background-color: #3A7CD0;
}
-->
</style>