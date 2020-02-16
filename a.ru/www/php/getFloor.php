<?php
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT floor FROM rooms WHERE name='".$_GET['name']."'");
    if ($row = $result->fetch_assoc()) {
        echo $row['floor'];
    }
?>
