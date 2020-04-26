<?php

function ServerName()
{
	include 'DBDetails.php';
	$con=mysqli_connect("$host", "$username", "$password", "$db_name"); 
	
	$sql2="SELECT * FROM ServerDetails";
	$result2 = mysqli_query($con,$sql2);
	
	if (!$result2) 
	{ // check for errors.
	    echo 'Could not run query: ' . mysqli_error($con);
	    exit;
	}
	$row2 = mysqli_fetch_assoc($result2);
	$ServerName = $row2['ServerName'];
	return $ServerName;
}

?>
