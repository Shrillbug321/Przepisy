<?php
    global $connection;
	session_start();
	require_once("../common/database.php");
	$connection->query('DELETE FROM favourites 
       					WHERE user_id = '.$_SESSION['user_id'].' AND recipe_id = '.$_GET['recipe_id']);
	echo '<script> history.go(-1); </script>';