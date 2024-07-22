<?php
    global $connection;
	session_start();
	require_once("../common/database.php");
	$connection->query('INSERT INTO favourites(user_id, recipe_id) VALUES
                        ('.$_SESSION['user_id'].', '.$_GET['recipe_id'].')');
	echo '<script> history.go(-1); </script>';