<?php

if(isset($_POST['login-submit'])){

	require 'dbh.inc.php';

	$mailuid = $_POST['mailuid'];
	$password = $_POST['pwd'];

	if(empty($mailuid) || empty($password)){
		header("Location: ../index.php?error=emptyfields");
		exit();
	}
	else{
		$sql = "SELECT * FROM users WHERE uidUsers = ? OR emailUsers = ?;";
		$stmt = mysqli_stmt_init($conn); //initializing statement with the database connection
		if(!mysqli_stmt_prepare($stmt, $sql)){ //check connection to the database by running the $sql code
			header("Location: ../index.php?error=sqlerror");
			exit();
		}
		else{

			mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid); //pass in parameters from the input user to the database //s two strings
			mysqli_stmt_execute($stmt); //execute the binded parameters
			$results = mysqli_stmt_get_result($stmt); //store all data from the database
			if ($row = mysqli_fetch_assoc($results)) { //check $result if it contains data
				$pwdCheck = password_verify($password, $row['pwdUsers']); //take input password and password inside the database then compare them if equal
				if($pwdCheck == false){
					header("Location: ../index.php?error=wrongpwd");
					exit();
				}
				else if($pwdCheck == true) { //if 
					session_start();			
					$_SESSION["userUid"] = $row['uidUsers'];				
					$_SESSION["userId"] = $row['idUsers'];	

					header("Location: ../index.php?login=success");
					exit();
				}
				else{
					header("Location: ../index.php?error=wrongpwd");
					exit();	
				}
			}
			else{
				header("Location: ../index.php?error=nouser");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../index.php");
}
