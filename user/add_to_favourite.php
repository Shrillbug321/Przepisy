<?php
	session_start();
	require_once("../common/database.php"); 
	$query = 'INSERT INTO favourites(user_id, recipe_id) VALUES('.$_SESSION['user_id'].', '.$_GET['recipe_id'].')';
	$connection->query($query);
	echo '<script> history.go(-1); </script>';
?>