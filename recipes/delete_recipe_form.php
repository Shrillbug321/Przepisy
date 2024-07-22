<?php
    global $common, $connection, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = 'SELECT * FROM recipes WHERE recipe_id = '.$_GET['recipe_id'];
		$row = $connection->query($query)->fetch_assoc();
		echo '<div id="content">
		<div>
			<p> Na pewno chcesz usunąć przepis '.$row['title'].'? </p>
			<button onclick="redirect(\''.$recipes.'delete_recipe.php?recipe_id='.$_GET['recipe_id'].'\')"> Tak </button>
			<button onclick="history.go(-1)"> Nie </button>
			</div>
		</div>';
	?>	
</body>