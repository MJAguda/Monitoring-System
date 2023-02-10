<?php

	require 'dbh.inc.php'; 

	if(isset($_POST['add-submit'])){
		
		$did = $_POST['did']; //device id
		$password = $_POST['password']; //device id
		$repassword = $_POST['re-password']; //device id
		$ln = $_POST['lastname']; //Holder Lastname
		$fn = $_POST['firstname']; //Holder First Name
		$mn = $_POST['middlename']; //Holder Middle Name
		$add = $_POST['address']; //Home Address of the Device Holder
		$cn = $_POST['contact']; //contact number of the holder

		$targetDir = "../images/holders/";
		$fileName = basename($_FILES["file"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

		$newfileName = $did.".".$fileType;
		$targetFilePath = $targetDir.$newfileName;

		$allowTypes = array('jpg','png','jpeg','gif','pdf');

		$CheckNumbers = false;
		for($i = 0 ; $i < strlen($password) ; $i++){
			if(ctype_digit($password[$i])){
				$CheckNumbers = true;
			}
		}

		if(empty($did) || empty($password) || empty($repassword) || empty($ln) || empty($fn) || empty($mn) || empty($add)|| empty($cn) || empty($fileName)){ // check if all fields are empty
			header("Location: ../add.php?error=emptyfields&uid=".$did);
			exit();
		}
		elseif (preg_match('/![\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)){
			header("Location: ../add.php?error=passwordrequirements");
			exit();
		}		
		elseif(!$CheckNumbers){
			header("Location: ../add.php?error=passwordrequirements");
			exit();
		}
		elseif($password != $repassword){ //check if password and repeat password is the same
			header("Location: ../add.php?error=passwordsnotequal");
			exit();
		}
		elseif (!preg_match("/^[0-9]*$/", $cn)) { // check if $cn consists only with number (0-9)
			header("Location: ../add.php?error=invalidcn");
			exit();	
		}
		elseif(!in_array($fileType, $allowTypes)){
			header("Location: ../add.php?error=invalidfiletype");
			exit();		
		}
		else{

			move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath); //Move Uploaded File to targetFilePath

			$sql = "SELECT didCoordinates FROM holders WHERE didCoordinates=?;"; 
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../add.php?error=sqlerror");
				exit();				
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $did);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);

				if($resultCheck > 0){ // check if $did already exists on the database
					header("Location: ../add.php?error=idexist&did=".$did);
					exit();
				}
				else {
					//Insert data to Table holders
					$sql = "INSERT INTO holders(didCoordinates, passHolders, lnHolders, fnHolders, mnHolders, addHolders, cnHolders, image_dir) VALUES(?, ?, ?, ?, ?, ?, ?, ?);"; // add inputs to the database
					$stmt = mysqli_stmt_init($conn);

					if(!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../add.php?error=sqlerror");
						exit();
					}
					else{
						$targetFilePath = "images/holders/".$newfileName;
						
						mysqli_stmt_bind_param($stmt, "ssssssss", $did, $password, $ln, $fn, $mn, $add, $cn, $targetFilePath);
						mysqli_stmt_execute($stmt);

						//Insert data to coordinates
						$sql = "INSERT INTO coordinates(didCoordinates) VALUES (?);"; // add inputs to the database
						$stmt = mysqli_stmt_init($conn);

						if(!mysqli_stmt_prepare($stmt, $sql)){
							header("Location: ../add.php?error=sqlerror");
							exit();
						}
						else{
							mysqli_stmt_bind_param($stmt, "s", $did);
							mysqli_stmt_execute($stmt);
							
							header("Location: ../add.php?add=success");
							exit();
						}
					}


				}
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	else{
		header("Location: ../add.php");
		exit();
	}