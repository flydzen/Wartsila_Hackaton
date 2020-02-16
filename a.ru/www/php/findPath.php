<?php
	header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$result = $mysqli->query("SELECT x, y FROM edges");
	$g = array();
	$len = array();
	while ($row = $result->fetch_assoc()) {
	    $g[$row['x']][count($g[$row['x']])] = $row['y'];
	    $g[$row['y']][count($g[$row['y']])] = $row['x'];
	}
	$start = $_GET['start'];
	$result = $mysqli->query("SELECT id FROM rooms where name='".$start."'");
	$row = $result->fetch_assoc();
	$start = $row['id'];
	$end = $_GET['end'];
	$result = $mysqli->query("SELECT id FROM rooms where name='".$end."'");
	$row = $result->fetch_assoc();
	$end = $row['id'];
	$x = array();
	$y = array();
	$z = array();
	$result = $mysqli->query("SELECT id, x, y, floor FROM rooms");
	while ($row = $result->fetch_assoc()) {
	    $x[$row['id']] = $row['x'];
	    $y[$row['id']] = $row['y'];
	    $z[$row['id']] = $row['floor'];
	}
	$row = $result->fetch_assoc();
	$d = array();
	$last = array();
	$used = array();
	$n = $mysqli->query("SELECT COUNT(id) FROM rooms");
	$n = $n->fetch_assoc();
	$n = $n["COUNT(id)"];
	for ($i = 0; $i < $n; $i++) {
		$d[$i] = 1000000000;
		$used[$i] = 0;
		$last[$i] = -1;
	}
	$d[$start] = 0;
	for ($i = 0; $i < $n; $i++) {
		$v = 0;
		$dist = 1000000000;
		for ($j = 0; $j < $n; $j++) {
			if ($used[$j] == 0 && $d[$j] < $dist) {
				$v = $j;
				$dist = $d[$j];
			}
		}
		$used[$v] = 1;
		for ($j = 0; $j < count($g[$v]); $j++) {
			$s = $v;
			$e = $g[$v][$j];
			$len = sqrt(($x[$s] - $x[$e]) * ($x[$s] - $x[$e]) + ($y[$s] - $y[$e]) * ($y[$s] - $y[$e]) + ($floor[$s] - $floor[$e]) * 100);
			if ($d[$e] > $d[$s] + $len) {
				$d[$e] = $d[$s] + $len;
				$last[$e] = $s;
			}
		}
	}
	$ansX = array();
	$ansY = array();
	$ansZ = array();
	while ($end != -1) {
		$ansX[count($ansX)] = $x[$end];
		$ansY[count($ansY)] = $y[$end];
		$ansZ[count($ansZ)] = $z[$end];
		$end = $last[$end];
	}
	$lastZ = $ansZ[count($ansZ) - 1];
	echo $lastZ.",";
	for ($i = count($ansX) - 1; $i >= 0; $i--) {
		if ($ansZ[$i] != $lastZ) {
			echo $ansZ[$i].",";
		} 
		$lastZ = $ansZ[$i];
	}
	echo "@";
	for ($i = count($ansX) - 1; $i >= 0; $i--) {
		if ($ansZ[$i] != $lastZ) {
			echo "|";
		} 
		$lastZ = $ansZ[$i];
		echo $ansX[$i].",".$ansY[$i];
		if ($i != 0) {
			echo " ";
		}
	}
?>