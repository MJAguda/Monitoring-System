<?php 
	require "header.php";
?> <!--put header.php-->

	<body>
		<div id="wrapper-main">
			<section class="section-default">
				<?php
					if (isset($_SESSION['userId'])) {
						echo '<p class="login-status">You are logged in!</p>';
					}
					else{
						echo '<p class="logout-status">You are logged out!</p>';	
					}
				?>	
			</section>
		</div>
	</body>

<?php
	require "footer.php"
?> <!--put footer.php-->