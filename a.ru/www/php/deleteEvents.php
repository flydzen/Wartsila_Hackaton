<?php
	header('Content-type: text/html; charset=utf-8');
	$mysqli = new mysqli("localhost", "root", "", "nav");
	$mysqli->query("DELETE FROM `nav`.`events` WHERE id='".$_GET['id']."'");
?>