<?php require_once('../common/head.php'); 
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$meal_query = 'SELECT * FROM meals';
		$meal_result = $connection->query($meal_query);
		$difficulty_query = 'SELECT * FROM difficulties';
		$difficulty_result = $connection->query($difficulty_query);
		$categories_query = 'SELECT * FROM categories';
		$categories_result = $connection->query($categories_query);
		$recipe_query = 'SELECT *, DATE_FORMAT(prepare_time, "%H:%i") AS time FROM recipes INNER JOIN recipes_categories USING (recipe_id) WHERE recipe_id = '.$_GET['recipe_id'];
		$recipe_row = $connection->query($recipe_query)->fetch_assoc();
		echo '<div id="content">
		<div>
			<form class="form" name="edit_recipe" method="post" action="edit_recipe_form_step2.php">
				<label> Nazwa przepisu <input type=text name="title" value="'.$recipe_row['title'].'"> </input> <br>
				<label> Danie <select name="meal_id">';
				while ($row = $meal_result->fetch_assoc() )
				{
					if ($recipe_row['meal_id'] == $row['meal_id'])
						echo '<option value='.$row['meal_id'].' selected> '.$row['meal'].' </option>';
					else
						echo '<option value='.$row['meal_id'].'> '.$row['meal'].' </option>';
				}
				echo '</select> </label> <br>
				<label> Rodzaj <select name="category_id">';
				while ($row = $categories_result->fetch_assoc() )
				{
					if ($recipe_row['category_id'] == $row['category_id'])
						echo '<option value='.$row['category_id'].' selected> '.$row['category'].' </option>';
					else
						echo '<option value='.$row['category_id'].'> '.$row['category'].' </option>';
				}
				echo '</select> </label> <br>
				<label> Poziom trudności <select name="difficulty_id">';
				while ($row = $difficulty_result->fetch_assoc() )
				{
					if ($recipe_row['difficulty_id'] == $row['difficulty_id'])
						echo '<option value='.$row['difficulty_id'].' selected> '.$row['difficulty'].' </option>';
					else
						echo '<option value='.$row['difficulty_id'].'> '.$row['difficulty'].' </option>';
				}
				echo '</select> </label> <br>
				<label> Porcji <input type=text name="portions" value="'.$recipe_row['portions'].'"> </input> </label> <br>
				<label> Czas przygotowania <input type=time name="prepare_time" value="'.$recipe_row['time'].'"> </input> </label>
			<input type="hidden" name="recipe_id" value="'.$_GET['recipe_id'].'">
			<input type="submit" value="Przejdź dalej">
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>