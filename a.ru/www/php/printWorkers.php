<?php
    echo "AAAAAAAAA";
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT `name`, `lastName` FROM obl_peoples WHERE room=106");
    while ($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item">'.$row['name']." ".$row['lastName']."</li>";
    }
?>
