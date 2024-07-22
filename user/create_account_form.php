<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php'); ?>
<body>
	<?php
		require_once($common."/navbar.php");
		echo '<div id="content">
			<div>
			<form class="form" id="create_account_form" action="create_account.php" method="post">
				<label> Nazwa użytkownika <br/> <input type="text" name="user_name"> </label> <br/>
				<label> E-poczta <br/> <input type="email" name="email"> </label> <br/> 
				<label> Hasło <br/> <input type="password" name="password"> </label> <br/>
				<label> Potwierdź hasło <br/> <input type="password" name="confirm"> </label> </input> <br/>
				<input type="submit" name="submit" value="Załóż konto">
			</form>
			</div>
		</div>';
	?>	
</body>