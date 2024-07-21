<?php
    global $connection;
    require_once('../common/head.php');
	require_once('../common/database.php'); 
		date_default_timezone_set("Europe/Warsaw");
		$connection->autocommit(false);
		$connection->begin_transaction();
		try
		{
			$index = $connection->query('SELECT MAX(recipe_id) AS max FROM recipes')->fetch_assoc()['max']+1;
			$query = 'INSERT INTO descriptions(recipe_id, description) VALUES ('.$index.', "'.$_POST['description'].'")';
			$connection->query($query);
			$i = 0;
			foreach ($_POST['ingredients'] as $key)
			{
				$query = 'INSERT INTO ingredients_lists(recipe_id, ingredient, how_many, unit_id) VALUES
                          ('.$index.', "'.$_POST['ingredients'][$i].'", '.$_POST['how_many'][$i].', '.$_POST['units_ids'][$i].')';
				$connection->query($query);
				$i++;
			}
			$query = 'INSERT INTO recipes_metadatas(recipe_id, user_id, add_date, update_date) VALUES
                      ('.$index.', '.$_SESSION['user_id'].', "'.date("Y-m-d G:i:s").'", '.'NULL)';
			$connection->query($query);
			$query = 'INSERT INTO recipes(metadata_id, title, meal_id, difficulty_id, portions, prepare_time, ingredients_list_id, description_id, accepted) VALUES
                      ('.$index.', "'.$_POST['title'].'", '.$_POST['meal_id'].', '.$_POST['difficulty_id'].', '.$_POST['portions'].', "'.$_POST['prepare_time'].'", '.$index.', '.$index.',';
			if (isset($_POST['accepted']) && $_POST['accepted'] )
				$query .= 'TRUE)';
			else
				$query .= 'FALSE)';
			$connection->query($query);
			$query = 'INSERT INTO recipes_categories(recipe_id, category_id) VALUES ('.$index.', '.$_POST['category_id'].')';
			$connection->query($query);
			$query = 'INSERT INTO marks(user_id, recipe_id) VALUES ('.$_SESSION['user_id'].', '.$index.')';
			$connection->query($query);
			$connection->commit();
			$connection->autocommit(true);
			echo '<script> history.go(-3) </script>';
		}
		catch (mysqli_sql_exception $exception)
		{
			$connection->rollback();
			echo 'Nie udało się dodać przepisu
			<button onclick="history.go(-2)"> Spróbuj ponownie </button>'.
			$exception;
			$connection->autocommit(true);
		}
?>