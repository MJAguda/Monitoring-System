<?php
	if(isset($_POST['signup-submit'])){
		
		require 'dbh.inc.php'; 

		$username = $_POST['uid'];
		$email = $_POST['mail'];
		$password = $_POST['pwd'];
		$passwordRepeat = $_POST['pwd-repeat'];

		if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){//check if any of the following is empty
			header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
			exit();
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){ //check if email and password is valid
			header("Location: ../signup.php?error=invalidmailuid");
			exit();	
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //check if email is valid
			header("Location: ../signup.php?error=invalidmail&uid=".$username);
			exit();	
		}
		else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){ //check if password is valid
			header("Location: ../signup.php?error=invaliduid&mail=".$email);
			exit();	
		}
		else if($password !== $passwordRepeat){ //check if password entered is the same with the passwordRepeat
			header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
			exit();		
		}
		else{
			$sql = "SELECT uidUsers FROM users WHERE uidUsers = ? OR emailUsers = ?;"; //Check if uidUsers already exists
			$stmt = mysqli_stmt_init($conn); //initializes a statement and returns an object suitable for mysqli_stmt_prepare().
 
			if(!mysqli_stmt_prepare($stmt, $sql)){ //Prepare a SQL statement for execution
				header("Location: ../signup.php?error=sqlerror");
				exit();				
			}
			else{
				mysqli_stmt_bind_param($stmt, "ss", $username, $email); // Binds variables to a prepared statement as parameters
				mysqli_stmt_execute($stmt); //Executes a query that has been previously prepared using the mysqli_prepare function
				mysqli_stmt_store_result($stmt); //Transfers a result set from a prepared statement
				$resultCheck = mysqli_stmt_num_rows($stmt);	//Returns the number of rows in the result set

				if($resultCheck > 0){ //Checks if email already exists in the database 
					header("Location: ../signup.php?error=usertaken&mail=".$email);
					exit();
				}
				else{
			
					$sql = "INSERT INTO users(uidUsers, emailUsers, pwdUsers) VALUES(?, ?, ?);";
					$stmt = mysqli_stmt_init($conn);
			
					if (!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../signup.php?error=sqlerror");
						exit();
					}
					else {
						
						session_start();
						$uid = $_SESSION["userUid"];
						$userId = $_SESSION["userId"];						

						echo $uid;
						echo $userId;

						//if(empty($uid) && empty($userId)){
						//	header("Location: ../signup.php?error=noadmin");
						//	exit();		
						//}
						//else{
							$hashedPwd = password_hash($password, PASSWORD_DEFAULT); //decrypt hashing

							mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
							mysqli_stmt_execute($stmt);
							header("Location: ../signup.php?signup=success");							
							exit();
						//}
					}
				}
			}
		}	
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}	
	else{
		header("Location: ../signup.php");
		exit();
	}