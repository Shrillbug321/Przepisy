<?php require_once('../common/head.php');
require_once('../common/database.php');
	date_default_timezone_set("Europe/Warsaw");
	if ($_POST["password"] != $_POST["confirm"])
		echo '<p> Potwierdzenie jest różne od hasła. <button class="click_here" onclick="redirect(\'create_account_form.php\')"> Kliknij tutaj </button> aby spróbować ponownie. </p>';
	else
	{
		$query = 'INSERT INTO users (user_name, e_mail, password) VALUES ("'.$_POST['user_name'].'", "'.$_POST['email'].'", "'.$_POST['password'].'")';
		$connection->query($query);
		$query = 'SELECT MAX(user_id) AS max FROM users';
		$_SESSION['user_id'] = $connection->query($query)->fetch_assoc()['max'];
		$query = 'INSERT INTO users_stats (user_id, account_created) VALUES ("'.$_SESSION['user_id'].'", "'.date("Y-m-d G:i:s").'")';
		$connection->query($query);
		echo '<p> Zarejestrowano pomyślnie. <button class="click_here" onclick="redirect(\''.$_SESSION['return'].'\')"> Kliknij tutaj </button> aby wrócić do wcześniejszej strony. </p>';
	}
?>