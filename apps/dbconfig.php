<?php
	$url=parse_url(getenv("us-cdbr-iron-east-01.cleardb.net"));
	$host = $url["host"];
	$username=$url["b7fdf2e2fbe34d"]; // Mysql username 
	$password=$url["4e878331"]; // Mysql password 
	$db_name=substr($url["heroku_ccdd37a9508be9a"],1); // Database name 
	
?>
