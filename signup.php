<?php 
	require "header.php"
?> <!--put header.php-->

	<body>
		<div id="wrapper-main">
			<section class="section-default">
				<h1>SIGN UP</h1>

				<?php
					if(isset($_GET['error'])){
						if($_GET['error'] == "emptyfields")
							echo'<p class="signuperror">Fill in all fields!</p>';
						elseif ($_GET['error'] == "invalidmailuid") {
							echo'<p class="signuperror">Invalid username and e-mail!</p>';
						}
						elseif ($_GET['error'] == "invalidmail") {
							echo'<p class="signuperror">Invalid e-mail!</p>';
						}
						elseif ($_GET['error'] == "invaliduid") {
							echo'<p class="signuperror">Invalid username!</p>';
						}
						elseif ($_GET['error'] == "passwordcheck") {
							echo'<p class="signuperror">Your passwords do not match!</p>';
						}
						elseif ($_GET['error'] == "usertaken") {
							echo'<p class="signuperror">Username or Email is already taken!</p>';
						}
						elseif ($_GET['error'] == "noadmin") {
							echo'<p class="signuperror">Login an Admin account first!</p>';
						}
					}
					elseif (isset($_GET['signup'])) {
						if($_GET['signup'] == 'success')
							echo'<p class="signupsuccess">Signup successful!</p>';
					}
				?>

				<form class="form-signup" action="includes/signup.inc.php" method="post"> <!--place all inputs in the signup.inc.php-->
					<input type="text" name="uid" placeholder="Username">
					<input type="text" name="mail" placeholder="E-Mail">
					<input type="password" name="pwd" placeholder="Password">
					<input type="password" name="pwd-repeat" placeholder="Repeat Password"> 
					<button type="submit" name="signup-submit">Sign Up</button>
				</form>
			</section>
		</div>
	</body>

<?php
	require "footer.php"
?> <!--put footer.php-->