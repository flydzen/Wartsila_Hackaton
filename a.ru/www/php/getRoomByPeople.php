<?php
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT room FROM obl_peoples WHERE name='".$_GET['name']."' AND lastName='".$_GET['lastName']."'");
    if ($row = $result->fetch_assoc()) {
        echo $row['room'];
    }
?>
