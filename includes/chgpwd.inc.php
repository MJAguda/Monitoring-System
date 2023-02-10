<?php 
	session_start();

	if(isset($_POST["chgpwd-submit"])){
		require "dbh.inc.php";
		
		$pwd_old = $_POST["pwdold"];
		$pwd_old_repeat = $_POST["pwdold-repeat"];
		$pwd_new = $_POST["pwdnew"];
		$pwd_new_repeat = $_POST["pwdnew-repeat"];

		//check if all fields are empty
		if(empty($pwd_old) || empty($pwd_old_repeat) || empty($pwd_new) || empty($pwd_new_repeat)){
			header("Location: ../chgpwd.php?error=emptyfields&uid=".$uid."&mail=".$mail);
			exit();
		}
		elseif(($pwd_old != $pwd_old_repeat) && ($pwd_new != $pwd_new_repeat)){ //check if password is not equal to password-repeat
			header("Location: ../chgpwd.php?error=pwdcheck");
			exit();		
		}
		elseif($pwd_old == $pwd_new){
			header("Location: ../chgpwd.php?error=pwdnochange");
			exit();		
		}
		else{
			$pwdCheck = password_verify($pwd_old, $_SESSION['password']);
			
			if ($pwdCheck == FALSE) {
				header("Location: ../chgpwd.php?error=pwdwrong");
				exit();				
			}
			elseif ($pwdCheck == TRUE) {
				$sql = "UPDATE users SET pwdUsers = ? WHERE idUsers = ?;";
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt, $sql)){
					header("Location: ../chgpwd.php?error=sqlerror");
					exit();
				}
				else{

					$hashedPwd = password_hash($pwd_new, PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $_SESSION["userId"]);
					mysqli_stmt_execute($stmt);

					$_SESSION["userId"] = NULL;
					
					header("Location: ../chgpwd.php?chgpwd=success");
					exit();

				}
			}
			else{
				header("Location: ../chgpwd.php?error=pwdwrong");
				exit();
			}

		}
	}
	else{
		header("Location: ../chgpwd.php");
		exit();
	}
	
