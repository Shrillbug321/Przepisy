<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = 'SELECT * FROM recipes WHERE accepted = 0';
		$result = $connection->query($query);
		echo '<div id="content">
		<div>
			<form name="accepted" method="post" action="recipe_accepted.php">';
			while ($row = $result->fetch_assoc())
			{
				echo '<label> <a href="'.$recipes.'recipe.php?recipe_id='.$row['recipe_id'].'">' .$row['title']. ' </a> 
				<input type=checkbox name=accepted[] value='.$row['recipe_id'].'> </label> <br/> ';
			}
			echo '<input type="submit" value="Zaakceptuj przepisy">
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>