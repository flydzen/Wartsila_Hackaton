<?php
    $result = $mysqli->query("SELECT name, sluz FROM rooms");
    while ($row = $result->fetch_assoc()) {
        if ($row['sluz'] == 1) {
            $row['name'] = str_replace('_', ' ', $row['name']);
            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
        }
    }
?>
