<?php
 session_start();
 session_unset();
 session_destroy();

 echo "<html><head><script>";
 echo "function fx() { window.parent.location='http://localhost/blog/login.php'; } ";
 echo "</script></head>";
 echo "<body onload='fx()'>"; 
 echo "See you soon ! <br>";
 echo "Redirecting ...";
 echo "</body></html>";
?>