<?php
	require_once('../common/head.php');
	require_once($common."database.php");
	echo '<div id="content">';
	$query = 'SELECT * FROM users WHERE user_name = "'.$_POST['user_name'].'" AND password = "'.$_POST['password'].'"';
	$result = $connection->query($query);
	if ($row = $result->fetch_assoc())
	{
		$_SESSION['user_id'] = $row['user_id'];
		echo '<script type="text/javascript"> location.href = "'.$_SESSION['return'].'"</script>';
	}
	else
		echo '<p> Nie udało się zalogować <button class="click_here" onclick="redirect(\'login_form.php\')"> Kliknij tutaj </button> aby spróbować ponownie. </p>';
	echo '</div>';
	require_once($common."footer.php");
?>