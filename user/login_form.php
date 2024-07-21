<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php'); ?>
<body>
	<?php
		require_once($common."/navbar.php");
		echo '<div id="content">
			<div>
			<p class="form_message"> Nie masz konta? 
			    <button class="click_here" onclick="redirect(\'create_account_form.php\')"> Stwórz konto </button> </p>
			<form class="form" id="login_form" action="login.php" method="post">
				<label> Nazwa użytkownika <br/> <input type="text" name="user_name"> </label> <br/>
				<label> Hasło <br/> <input type="password" name="password"> </label> <br/>
				<input type="submit" name="submit" value="Wpisz się"> 
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>