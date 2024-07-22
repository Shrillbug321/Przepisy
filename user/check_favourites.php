<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$user_id = $_SESSION['user_id'];
		$result = $connection->query('SELECT * FROM recipes_favourites rf WHERE user_id = '.$user_id);
		echo '<div id="content">
		<div>';
		if (mysqli_num_rows($result) > 0)
			while ($row = $result->fetch_assoc())
				echo '<div class="tile"> 
				 <a href="'.$recipes.'recipe.php?recipe_id='.$row['recipe_id'].'">
					<p class="small_header"> '.$row['title'].' </p>
				</a>
			</div>';
		else
			echo '<p> Jeszcze nie dodano niczego do ulubionych. </p>';
		echo '<div class="clear"></div>
		</div>';
	?>	
</body>