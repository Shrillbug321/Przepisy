<?php
    global $connection;
	session_start();
	require_once("../common/database.php"); 
	$marks_query = 'SELECT * FROM marks WHERE recipe_id = '.$_GET['recipe_id'].' AND user_id = '.$_SESSION['user_id'];
	$marks_result = $connection->query($marks_query);
	if (mysqli_num_rows($marks_result) == 1)
		$query = 'UPDATE marks SET mark = NULL WHERE user_id = '.$_SESSION['user_id'].' AND recipe_id = '.$_GET['recipe_id'];
	else
		$query = 'DELETE FROM marks WHERE user_id = '.$_SESSION['user_id'].' AND recipe_id = '.$_GET['recipe_id'];
	$connection->query($query);
	echo '<script> history.go(-1); </script>';