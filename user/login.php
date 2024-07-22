<?php
    global $common, $connection, $admins, $recipes;
	require_once('../common/head.php');
	require_once($common."database.php");
	require_once($common."navbar.php");
	echo '<div id="content"><div>';
	$result = $connection->query(
		'SELECT * FROM users WHERE user_name = "'.$_POST['user_name'].'" AND password = "'.$_POST['password'].'"');
	if ($row = $result->fetch_assoc())
	{
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['user_name'] = $row['user_name'];
		echo '<script> location.href = "'.$common.'index.php" </script>';
	}
	else
	{
		session_unset();
		session_destroy();
		echo '<p> Nie udało się zalogować <br/>
                <button class="click_here" onclick="redirect(\'login_form.php\')"> Spróbuj ponownie </button> </p>';
	}
	echo '</div></div>';