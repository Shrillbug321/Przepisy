<?php require_once('../common/head.php'); 
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = 'SELECT * FROM recipe_page';
		$result = $connection->query($query);
		$meal_query = 'SELECT * FROM meals';
		$meal_result = $connection->query($meal_query);
		$difficulty_query = 'SELECT * FROM difficulties';
		$difficulty_result = $connection->query($difficulty_query);
		$categories_query = 'SELECT * FROM categories';
		$categories_result = $connection->query($categories_query);
		echo '<div id="content">
		<div>
		<div id="content">
		<div>
			<form class="form" name="filters" method="post" action="filters.php">
				<label> 
					<input type="checkbox" name="checked[]" value="title"> Nazwa przepisu </input> <input type=text name="title"> </input> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="user_name"> Użytkownik </input> <input type=text name="user_name"> </input> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="average_mark"> Ocena </input> <input type=text name="average_mark"> </input> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="meal"> Danie </input> <select name="meal">';
					while ($row = $meal_result->fetch_assoc() )
						echo '<option value='.$row['meal'].'> '.$row['meal'].' </option>';
					echo '</select> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="category"> Rodzaj </input> <select name="category">';
					while ($row = $categories_result->fetch_assoc() )
						echo '<option value='.$row['category'].'> '.$row['category'].' </option>';
					echo '</select> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="difficulty"> Poziom trudności </input> <select name="difficulty">';
					while ($row = $difficulty_result->fetch_assoc() )
						echo '<option value='.$row['difficulty'].'> '.$row['difficulty'].' </option>';
					echo '</select> 
				</label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="portions"> Porcji </input> <input type=text name="portions"> </input> </label> <br>
				<label> 
					<input type="checkbox" name="checked[]" value="prepare_time"> Czas przygotowania </input> <input type=time name="prepare_time"> </input> </label>
			<input type="submit" value="Przejdź dalej">
			</form>
		<div class="clear"></div>
			</div>
		</div>';
		require_once($common."footer.php");
		//<label>  <input type=text name=""> </input>
	?>	
</body>
</html>