<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php');
		date_default_timezone_set("Europe/Warsaw");
		$connection->autocommit(false);
		$connection->begin_transaction();
		try
		{
			$index = $_POST['recipe_id'];
			$elements = $connection->query(
                'SELECT COUNT(*) AS elements FROM ingredients_lists WHERE recipe_id = '.$index)
                ->fetch_assoc()['elements'];
			$ingredients_list_ids = $connection->query(
                'SELECT ingredients_list_id FROM ingredients_lists WHERE recipe_id = '.$index);
			$query = 'UPDATE descriptions SET description = "'.$_POST['description'].'" WHERE recipe_id = '.$index;
			$connection->query($query);

			$i = 0;
			foreach ($_POST['ingredients'] as $key)
			{
				if ($i < $elements)
					$query = 'UPDATE ingredients_lists 
                                SET ingredient = "'.$_POST['ingredients'][$i].'", 
                                how_many = '.$_POST['how_many'][$i].', 
                                unit_id = '.$_POST['units_ids'][$i].' 
                                WHERE ingredients_list_id = '.$ingredients_list_ids->fetch_assoc()['ingredients_list_id'];
				else 
					$query = 'INSERT INTO ingredients_lists(recipe_id, ingredient, how_many, unit_id) VALUES 
                                ('.$index.', "'.$_POST['ingredients'][$i].'", '.$_POST['how_many'][$i].', '.$_POST['units_ids'][$i].')';
				$connection->query($query);
				$i++;
			}

			while ($i++ < mysqli_num_rows($ingredients_list_ids))
			{
				$ingredients_list_id = $ingredients_list_ids->fetch_assoc()['ingredients_list_id'];
				$connection->query('DELETE FROM ingredients_lists WHERE ingredients_list_id = '.$ingredients_list_id);
			}

            $queries = ['UPDATE recipes_metadatas SET update_date = "'.date("Y-m-d G:i:s").'" WHERE recipe_id = '.$index,
                'UPDATE recipes SET title = "'.$_POST['title'].'", meal_id = '.$_POST['meal_id'].', difficulty_id = '.$_POST['difficulty_id'].', portions = '.$_POST['portions'].', prepare_time = "'.$_POST['prepare_time'].'" WHERE recipe_id = '.$index,
                'UPDATE recipes_categories SET category_id = '.$_POST['category_id'].' WHERE recipe_id = '.$index];
            foreach ($queries as $query)
                $connection->query($query);

			$connection->commit();
			$connection->autocommit(true);
			echo '<script type="text/javascript"> history.go(-3) </script>';
		}
		catch (mysqli_sql_exception $exception)
		{
			$connection->rollback();
			echo 'Nie udało się uaktualnić przepisu
			<button onclick="history.go(-2)"> Spróbuj ponownie </button>'.
			$connection->autocommit(true);
		}