<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<meta name = "description" content="This is an example of meta description. This will often show up in search results.">
		<meta name = "viewport" content = "width=device-width, initial-scale=1">
		<title>Radio.Ph</title>
		
	
		<link rel="icon" href="images/logo.png">
		<link rel="stylesheet" type="text/css" href="css/style-header.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-body.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-footer.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-leftnav.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-sign.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-chgpwd.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-add.css" media="screen">
	

	</head>
	<body>
		<div id="header">
			<div id="header-nav">
				<div id="logo">
					<a href="images/logo.png">	
						<img src="images/logo.png"> <!--insert image named logo-->
					</a>
				</div>	

				<div id="header-content">
					<div id="header-content-outer-left">
						<ul>
							<li><a href="index.php">Home</a></li>

							<?php //hides Map button if not logged in
								if (isset($_SESSION['userId'])) {
									echo '
										<li><a href="dashboard.php">Map</a></li>
									';
								}
							?>

							<li><a href="#">About</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</div>

					<div id="header-content-outer-right">
						
						
						<div id="header-content-inner-left">
							<?php
								if (isset($_SESSION['userId'])) { //if you're logged in, hides login button and displays logout button
									echo '	
											<form action="includes/dropdown.inc.php" method="post">
												<select class="dropdown-submit" name="dropdown" onchange="this.form.submit();"><option value="Default">Choose:</option>
													<option value="ChangePassword">Change Password</option>
													<option value="DeleteAccount">Delete Account</option>
													<option value="LogOut">Logout</option>
												</select>
											</form>';
								}
								else{ //if you're logged out, hides logout button and displays login button
									echo '	
											<form action="includes/login.inc.php" method="post"> <!--Inputs-->
												<input type="text" name="mailuid" placeholder="Username/Email">
												<input type="password" name="pwd" placeholder="Password">
												<button type="submit" name="login-submit">Log In</button>
											</form>';
								}
							?>
						</div>
						
						<div id="header-content-inner-right">
							<a href="signup.php"><button>Sign Up</button></a>
						</div>

					</div>
				</div>

			</div>
		</div>