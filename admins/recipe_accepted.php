<?php
    global $connection;
	require_once('../common/database.php');
    foreach($_POST['accepted'] as $recipe_id)
		$result = $connection->query('UPDATE recipes SET accepted = 1 WHERE recipe_id = '.$recipe_id);
	echo '<script type="text/javascript"> history.go(-1) </script>';