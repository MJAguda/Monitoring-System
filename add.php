<?php 
	require "header.php"
?> <!--put header.php-->

	<body>
		<div id="wrapper-main">
			<section class="section-default">
				<h1>Add Device Holder</h1>

				<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] == "emptyfields") {
							echo'<p class="adderror">Fill in all fields!</p>';
						}
						elseif($_GET['error'] == "passwordrequirements"){
							echo'<p class="adderror">Password Must Contain Atleast one number and one symbol!</p>';
						}
						elseif($_GET['error'] == "passwordsnotequal"){
							echo'<p class="adderror">Your passwords do not match!</p>';
						}
						elseif($_GET['error'] == "invalidcn"){
							echo'<p class="adderror">Invalid Contact Number!</p>';
						}
						elseif($_GET['error'] == "idexist"){
							echo'<p class="adderror">Device ID already exists!</p>';
						}
						elseif($_GET['error'] == "invalidfiletype"){
							echo'<p class="adderror">Invalid File Type!</p>';
						}
						elseif($_GET['error'] == "sqlerror"){
							echo'<p class="adderror">SQL Error!</p>';
						}
						else{
							echo'<p class="adderror">Error!</p>';	
						}
					}
					elseif (isset($_GET['add'])) {
						if($_GET['add'] == 'success')
							echo'<p class="addsuccess">Success!</p>';
					}
				?>

				<form class="form-add" action="includes/add.inc.php" method="post" enctype="multipart/form-data">
					
					<h4>Select Image File to Upload:</h4> 

		    		<input type="file" name="file">
					<input type="text" name="did" placeholder="Device ID">
					<input type="password" name="password" placeholder="Password">
					<input type="password" name="re-password" placeholder="Repeat Password">
					<input type="text" name="lastname" placeholder="Last Name">
					<input type="text" name="firstname" placeholder="First Name">
					<input type="text" name="middlename" placeholder="Middle Name">
					<input type="text" name="address" placeholder="Address">
					<input type="text" name="contact" placeholder="Contact Number">
					<button type="submit" name="add-submit">Add</button>
				</form>
			</section>
		</div>
	</body>

<?php
	require "footer.php"
?> <!--put footer.php-->