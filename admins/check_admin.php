<?php require_once('../common/head.php'); 
	require_once('../common/database.php');
	function check_admin($user_id)
	{
		global $connection;
		$query = 'SELECT * FROM admins WHERE user_id = '.$user_id;
		return mysqli_num_rows($connection->query($query)) > 0;
	}