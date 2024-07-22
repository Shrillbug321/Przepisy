<?php
    global $connection;
	session_start();
	require_once("../common/database.php");
	$connection->query('INSERT INTO marks(user_id, recipe_id, mark) VALUES
            			('.$_SESSION['user_id'].', '.$_POST['recipe_id'].', '.$_POST['mark'].')');
	echo '<script> history.go(-1); </script>';