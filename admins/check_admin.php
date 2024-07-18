<?php require_once('../common/head.php'); 
	require_once('../common/database.php');
	function check_admin($user_id)
	{
		global $connection;
		$admin_query = 'SELECT * FROM admins WHERE user_id = '.$user_id;
		if ( mysqli_num_rows( $connection->query($admin_query) ) > 0 )
			return true;
		return false;
	}
?>