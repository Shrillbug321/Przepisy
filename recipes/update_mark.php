<?php
    global $connection;
	session_start();
	require_once("../common/database.php");
	$connection->query('UPDATE marks SET mark = '.$_POST['mark'].'
	            WHERE user_id = '.$_SESSION['user_id'].' AND recipe_id = '.$_POST['recipe_id']);
	echo '<script> history.go(-1); </script>';