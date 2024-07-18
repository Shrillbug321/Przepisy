<?php require_once('../common/head.php'); 
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
				<p> Panel administracyjny </p>
				<button onclick="redirect(\''.$admins.'recipes_waitroom.php\')"> Przeglądaj przepisy w poczekalni </button> <br>
				<button onclick="redirect(\''.$admins.'add_category_form.php\')"> Dodaj kategorie </button>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>
</html>