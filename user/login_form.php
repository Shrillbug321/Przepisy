<?php require_once('../common/head.php'); ?>
<body>
	<?php
		require_once($common."/navbar.php");
		echo $_SESSION['return'] = $_SERVER['HTTP_REFERER'];
		echo '<div id="content">
			<div>
			<p class="form_message"> Nie masz konta? <button class="click_here" onclick="redirect(\'create_account_form.php\')"> Kliknij tutaj </button> aby je stworzyć </p>
			<form class="form" id="login_form" action="login.php" method="post">
				<label> Nazwa użytkownika <br> <input type="text" name="user_name"> </input> </label> <br>
				<label> Hasło <br> <input type="password" name="password"> </input> </label> <br>
				<input type="submit" name="submit" value="Wpisz się"> </input>
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>
</html>