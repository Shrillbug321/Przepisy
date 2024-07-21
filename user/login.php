<?php
    global $common, $connection, $admins, $recipes;
	require_once('../common/head.php');
	require_once($common."database.php");require_once($common."/navbar.php");
	echo '<div id="content"><div>';
	$query = 'SELECT * FROM users WHERE user_name = "'.$_POST['user_name'].'" AND password = "'.$_POST['password'].'"';
	$result = $connection->query($query);
	if ($row = $result->fetch_assoc())
	{
		$_SESSION['user_id'] = $row['user_id'];
		echo '<script type="text/javascript"> location.href = "'.$_SESSION['return'].'"</script>';
	}
	else
		echo '<p> Nie udało się zalogować <br/>
                <button class="click_here" onclick="redirect(\'login_form.php\')"> Spróbuj ponownie </button> </p>';
	echo '</div></div>';
	require_once($common."footer.php");
?>