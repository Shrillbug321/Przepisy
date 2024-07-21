<?php
    global $connection;
	session_start();
	require_once("../common/database.php"); 
	$query = 'DELETE FROM favourites WHERE user_id = '.$_SESSION['user_id'].' AND recipe_id = '.$_GET['recipe_id'];
	$connection->query($query);
	echo '<script> history.go(-1); </script>';
?>