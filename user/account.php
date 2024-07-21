<?php
    global $common, $connection, $admins, $recipes, $user;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$user_id = $_SESSION['user_id'];
		$user_query = 'SELECT * FROM users WHERE user_id = '.$user_id;
		$result = $connection->query($user_query);
		$user_row = $result->fetch_assoc();
		echo '<div id="content">
			<div>
				<p> <b>'.$user_row['user_name'].'</b><br/>'.$user_row['e_mail'].'  </p>
				<button onclick="redirect(\''.$recipes.'add_recipe_form.php\')">
				 Dodaj przepis </button> <br/>
				<button onclick="redirect(\''.$user.'check_favourites.php?user_id='.$_SESSION['user_id'].'\')">
				 Sprawdź ulubione </button> <br/>
				<button onclick="redirect(\''.$user.'check_stats.php?user_id='.$_SESSION['user_id'].'\')">
				 Sprawdź statystyki </button>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>