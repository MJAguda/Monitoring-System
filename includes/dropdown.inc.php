<?php
	require "dbh.inc.php";
	session_start();

	$value = $_POST["dropdown"];

	switch ($value) {
		case 'Default':{
			header("Location: ../index.php");
			break;
		}

		//Changing Password of Users
		case 'ChangePassword': {				

				if(!isset($_SESSION["userId"]) || (trim ($_SESSION['userId']) == '')){
					header("Location: ../index.php");
				}
				else{
					$sql = "SELECT * FROM users WHERE idUsers = ?;";
					$stmt = mysqli_stmt_init($conn);

					if(!mysqli_stmt_prepare($stmt, $sql)){ //Prepare a SQL statement for execution
						header("Location: ../index.php?error=sqlerror");
						exit();				
					}
					else{
						mysqli_stmt_bind_param($stmt, "s", $_SESSION["userId"]);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);
						$resultCheck = mysqli_stmt_num_rows($stmt);
			
						if($resultCheck > 0){
							mysqli_stmt_bind_param($stmt, "s", $_SESSION["userId"]);
							mysqli_stmt_execute($stmt);
							$results = mysqli_stmt_get_result($stmt);
							$row = mysqli_fetch_assoc($results);

							$_SESSION["uid"] = $row["uidUsers"];
							$_SESSION["mail"] = $row["emailUsers"];
							$_SESSION["password"] = $row["pwdUsers"];
							header("Location: ../chgpwd.php");

						}
						else{
							header("Location: ../index.php");
						}
					}
				}
			break;
		}
		//Log Out any User that is Logged In
		case 'DeleteAccount':{
			$sql = "DELETE FROM users WHERE idUsers = ?";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../index.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $_SESSION["userId"]);
				mysqli_stmt_execute($stmt);

				$_SESSION["userId"] = NULL;
				session_start();
				session_unset(); //selects value of all session variable
				session_destroy();

				header("Location: ../index.php");
				exit();
			}

			break;			
		}


		case 'LogOut': {
			session_start();
			session_unset(); //selects value of all session variable
			session_destroy();
			
			header("Location: ../index.php");		
			break;
		}
			

		default:
				header("Location: ../index.php");		
			break;
	}

	
