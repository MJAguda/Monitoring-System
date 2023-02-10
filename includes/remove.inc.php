<?php
	if(isset($_POST['remove-submit'])){
		require 'dbh.inc.php'; 

		$did = $_POST['remove-submit'];

		if (empty($did)) {
			header("Location: ../dashboard.php?error=emptyfields&uid=".$did);
			exit();
		}
		else{
			$sql = "SELECT didCoordinates FROM holders WHERE didCoordinates=?;";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../dashboard.php?error=sqlerror");
				exit();				
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $did);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);

				if($resultCheck > 0){ //Add confirm/warning message before sql execution
					$sql = "DELETE FROM holders WHERE didCoordinates = ?;"; //Archived Deleted Profile with retention days
					$stmt = mysqli_stmt_init($conn);

					if (!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../dashboard.php?error=sqlerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt, "s", $did);
						mysqli_stmt_execute($stmt);


						//Delete File/Image of Holder
						$targetDir = "../images/holders/";

						unlink($targetDir . $did . ".jpg");
						unlink($targetDir . $did . ".png");
						unlink($targetDir . $did . ".jpeg");
						unlink($targetDir . $did . ".gif");
						unlink($targetDir . $did . ".pdf");		
					}
				}
			}
		}
			$sql = "SELECT didCoordinates FROM coordinates WHERE didCoordinates=?;";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../dashboard.php?error=sqlerror");
				exit();				
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $did);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);

				if($resultCheck > 0){
					$sql = "DELETE FROM coordinates WHERE didCoordinates = ?;";
					$stmt = mysqli_stmt_init($conn);

					if (!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../dashboard.php?error=sqlerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt, "s", $did);
						mysqli_stmt_execute($stmt);						
						header("Location: ../dashboard.php?remove=success");		
					}
				}
			}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	elseif (isset($_POST["alter-status-submit"])) {
		
		require "dbh.inc.php";

		$did = $_POST["alter-status-submit"];

			$sql = "SELECT didCoordinates FROM holders WHERE didCoordinates=?;";
			$stmt = mysqli_stmt_init($conn);
	
			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../dashboard.php?error=sqlerror");
				exit();				
			}
			else{
				mysqli_stmt_bind_param($stmt, "s", $did);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);
	
				if($resultCheck > 0){
					$sql = "UPDATE coordinates SET statCoordinates=0 WHERE didCoordinates = ?;";
					$stmt = mysqli_stmt_init($conn);

					if (!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../dashboard.php?error=sqlerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt, "s", $did);
						mysqli_stmt_execute($stmt);
												
						header("Location: ../dashboard.php?alter=success");						
					}
				}
			}
	}
	else{
		header("Location: ../dashboard.php");
		exit();
	}