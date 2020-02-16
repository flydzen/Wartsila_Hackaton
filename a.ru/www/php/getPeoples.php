<?php
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT name, lastName FROM obl_peoples");
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['name'].' '.$row['lastName'].'>'.$row['name'].' '.$row['lastName'].'.</option>';
    }
?>
