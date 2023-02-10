<?php

	require "header.php";
	
	if (!isset($_SESSION['userId']) || (trim ($_SESSION['userId']) == '')){
		header("Location: index.php");
	}	

	//refreshes page every 5 secs.
	/*($page = $_SERVER['PHP_SELF'];
	$sec = "5";
	header("Refresh: $sec; url=$page");
	*/

?>

	<body>
		<div id="wrapper-main">

			<div id="map"> <!--google map api-->	
				<!--

				<script>
				// Initialize and add the map
				function initMap() { // The location of Capatan
					var capatan = {lat: 17.614754, lng: 121.748159}; // The map, centered at Capatan
					var map = new google.maps.Map(
						document.getElementById('map'), {zoom: 16, center: capatan}); // The marker, positioned at the center of Capatan
					var marker = new google.maps.Marker({position: capatan, map: map});
				}
				</script>
										
				<script async defer
					src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh0ka7aHJAqbeJwsafm8rvA9MVh0r_d0E&callback=initMap">
				</script>

				google api-->

				<object type="text/html" data="http://localhost/_monitoring_system/map.php" width="100%" height="568px"></object><!--Insert and external HTML map.php-->
			</div> <!--google map api-->

			<div id="left-nav"> <!--left navigation bar-->
				<div id="desc"> <!--table-->	
					<table>	
						<tr>
							<th class="resident">Resident(ID)</th>
							<th class="lat">Latitude</th>
							<th class="long">Longitude</th>
							<th class="check">Remove</th>
							<th class="status">Status</th>
						</tr>

					<?php
						require "includes/left-nav.inc.php";
					?>
						
					</table>

				</div>
				<div id="left-nav-footer">
					<!--
					<a href="add.php"
						onclick="window.open('add.php', 'newwindow', 'width=300, height=450');return false;"> <!--open a new small window-->
					<a href="add.php">
						<button>ADD Device</button>
					</a>
				</div>
			</div> <!--left navigation bar-->

		</div> <!-- container -->
	</body>

<?php
	require "footer.php";
?>

