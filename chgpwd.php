<?php
	require "header.php";
?>

<body>
	<div id="wrapper-main">
		<section class="section-default">
			<h1>Change Password</h1>	

			<?php
				if (isset($_GET["error"])){
					if ($_GET["error"] == "emptyfields") {
						echo'<p class="chgpwderror">Fill in all fields!</p>';
					}
					elseif ($_GET["error"] == "pwdcheck") {
						echo'<p class="chgpwderror">Password do not Match!</p>';	
					}
					elseif ($_GET["error"] == "pwdnochange") {
						echo'<p class="chgpwderror">Password is the same!</p>';
					}
					elseif ($_GET["error"] == "pwdwrong") {
						echo'<p class="chgpwderror">Wrong Password!</p>';
					}
				}
				elseif (isset($_GET["chgpwd"])) {
					if ($_GET["chgpwd"] == "success") {
						echo'<p class="chgpwdsuccess">Change Password successful!</p>';
					}
				}
			?>

			<form class="form-chgpwd" action="includes/chgpwd.inc.php" method="post"> <!--place all inputs in the signup.inc.php-->
				<label>Username: </label>
				<input type="text" name="uid" value="<?php echo $_SESSION["uid"] ?>" placeholder="Username">
				<label>Email: </label>
				<input type="text" name="mail" value="<?php echo $_SESSION["mail"] ?>" placeholder="E-Mail">
				<label>Password: </label>
				<input type="password" name="pwdold" placeholder="Old Password">
				<input type="password" name="pwdold-repeat" placeholder="Repeat Old Password"> 
				<label>New Password: </label>
				<input type="password" name="pwdnew" placeholder="New Password">
				<input type="password" name="pwdnew-repeat" placeholder="Repeat New Password"> 
				<button type="submit" name="chgpwd-submit">Change Password</button>
			</form>

		</section>
	</div>
</body>

<?php
	require "footer.php";
?>

