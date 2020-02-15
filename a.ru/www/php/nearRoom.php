<?php
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$x = $_GET['x'];
	$y = $_GET['y'];
	$f = $_GET['floor'];
	$result = $mysqli->query("SELECT name, x, y FROM rooms WHERE floor=".$f);
	$ansX = 0;
	$ansY = 0;
	$ans = "";
	$dist = 1000000000;
	while ($row = $result->fetch_assoc()) {
	    $tx = $row['x'];
	    $ty = $row['y'];
	    if (($x - $tx) * ($x - $tx) + ($y - $ty) * ($y - $ty) < $dist) {
	    	$dist = ($x - $tx) * ($x - $tx) + ($y - $ty) * ($y - $ty);
	    	$ansX = $tx;
	    	$ansY = $ty;
	    	$ans = $row['name'];
	    }
	}
	echo $ansX." ".$ansY." ".$ans;
?>