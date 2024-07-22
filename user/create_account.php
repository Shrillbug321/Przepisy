<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
    require_once('../common/database.php');
	date_default_timezone_set("Europe/Warsaw");
	if ($_POST["password"] != $_POST["confirm"])
		echo '<p> Potwierdzenie jest różne od hasła. <br/>
                <button class="click_here" onclick="redirect(\'create_account_form.php\')"> Spróbuj ponownie </button> </p>';
	else
	{
		$connection->query('INSERT INTO users (user_name, e_mail, password) VALUES
                    ("'.$_POST['user_name'].'", "'.$_POST['email'].'", "'.$_POST['password'].'")');
		$_SESSION['user_id'] = $connection
			->query('SELECT MAX(user_id) AS max FROM users')->fetch_assoc()['max'];
		$connection->query('INSERT INTO users_stats (user_id, account_created) VALUES
                    ("'.$_SESSION['user_id'].'", "'.date("Y-m-d G:i:s").'")');
		echo '<p> Zarejestrowano pomyślnie. <br/>
                <button class="click_here" onclick="redirect(\''.$_SESSION['return'].'\')">
                 Wróć do poprzedniej strony </button> </p>';
	}