<?php
	
	require "includes/dbh.inc.php";

	$sql = "SELECT * FROM coordinates ORDER BY statCoordinates DESC;";
	$result = $conn -> query($sql);

	if($result -> num_rows > 0){
		while ($row = $result -> fetch_assoc()) {
			echo "
			<tr>
				<form action='includes/remove.inc.php' method='post' role='form'>
					<td class='resident-data'>".$row["didCoordinates"]."</td>
					<td class='lat-data'> ".$row["latCoordinates"]."</td>
					<td class='long-data'>".$row["longCoordinates"]."</td>
					<td>
						<button type='submit' class='remove-button' name='remove-submit' value=".$row['didCoordinates'].">Delete</button>
					</td>";


					if ($row["statCoordinates"] == 0) {
						echo "<td class='status-data' bgcolor='green'>SAFE</td>";
					}
					else{
						echo "	<td class='status-data'>
									<button type='submit' class='alter-status' name='alter-status-submit' value=".$row['didCoordinates'].">ALERT</button>
								</td>";
					}
			echo "
				</form>
			</tr>";
		}
	}
	else{
		echo "<tr><td>0 Device is deployed</td></tr>";
	}
	mysqli_close($conn);
