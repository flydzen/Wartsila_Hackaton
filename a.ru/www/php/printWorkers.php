<?php
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT `name`, `lastName` FROM obl_peoples WHERE room=".$_GET['room']);
    while ($row = $result->fetch_assoc()) {
        echo '<li>'.$row['name']." ".$row['lastName']."</li>";
    }
?>
