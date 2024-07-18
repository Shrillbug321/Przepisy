<?php
	$server = "localhost";
	$db_user = "root";
	$password = "";
	$database = "culinary_book";
	$connection = new mysqli($server, $db_user, $password, $database);
	if ($connection->connect_error)
		die("Błąd!");
?>