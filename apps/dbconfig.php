<?php
	$url=parse_url(getenv("CLEARDB_DATABASE_URL"));
	$server = $url["host"];
	$username=$url["user"]; // Mysql username 
	$password=$url["pass"]; // Mysql password 
	$db=substr($url["path"],1); // Database name 
	$conn=mysql_connect($server , $username, $password) or die("cannot connect");
	
?>
