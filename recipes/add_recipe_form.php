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
		echo '<div id="content">
		<div>
			<form class="form" name="add_recipe" method="post" action="add_recipe_form_step2.php">
				<label> Nazwa przepisu <input type=text name="title"/> </label> <br>
				<label> Danie <select name="meal_id">';
				while ($row = $meal_result->fetch_assoc() )
					echo '<option value='.$row['meal_id'].'> '.$row['meal'].' </option>';
				echo '</select> </label> <br>
				<label> Rodzaj <select name="category_id">';
				while ($row = $categories_result->fetch_assoc() )
					echo '<option value='.$row['category_id'].'> '.$row['category'].' </option>';
				echo '</select> </label> <br>
				<label> Poziom trudności <select name="difficulty_id">';
				while ($row = $difficulty_result->fetch_assoc() )
					echo '<option value='.$row['difficulty_id'].'> '.$row['difficulty'].' </option>';
				echo '</select> </label> <br>
				<label> Porcji <input type=text name="portions"> </input> </label> <br>
				<label> Czas przygotowania <input type=time name="prepare_time"> </input> </label>
			<input type="submit" value="Przejdź dalej">
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>
</html>