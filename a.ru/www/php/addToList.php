<?php
	header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$mysqli->query("INSERT INTO `nav`.`events` (`id`, `time`, `name`) VALUES (NULL, CURRENT_TIME(''), '".$_GET['name']."')");
?>