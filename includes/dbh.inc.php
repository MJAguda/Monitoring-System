<?php
	$servername = "localhost";		
	$dBUserName = "root";	 		//default database username
	$dBPassword = "";				//default database password
	$dBName = "_monitoring_system";	//name of the database

	$conn = mysqli_connect($servername, $dBUserName, $dBPassword, $dBName); //connection to the database

	if(!$conn){ //error handler for the connection
		die("Connection failed".mysqli_connect_error());
	}
?>