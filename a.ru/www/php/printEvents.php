<?php
    header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT `id`, `name`, `time` FROM events");
    while ($row = $result->fetch_assoc()) {
        echo '<button type="button" onclick="moveToEvent('.$_row['name'].')" value="'.$row['id'].'" class="list-group-item list-group-item-action">'.$row['name'].'</button>';
    }
?>
