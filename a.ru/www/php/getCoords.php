<?php
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT * FROM rooms WHERE name = ".$_GET['room']."");
	while ($row = $result->fetch_assoc()) {
	    echo $row['x']." ".$row['y'];
	}
?>