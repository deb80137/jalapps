<?php
	$url=parse_url(getenv("mysql://b7fdf2e2fbe34d:4e878331@us-cdbr-iron-east-01.cleardb.net
/heroku_ccdd37a9508be9a?reconnect=true"));
	$server = $url["us-cdbr-iron-east-01.cleardb.net"];
	$username=$url["b7fdf2e2fbe34d"]; // Mysql username 
	$password=$url["4e878331"]; // Mysql password 
	$db=substr($url["heroku_ccdd37a9508be9a"],1); // Database name 
	
	
?>
