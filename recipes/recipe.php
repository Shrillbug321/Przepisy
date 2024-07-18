<?php 
	require_once("../common/head.php");
	require_once($common."database.php");
	require_once($admins."check_admin.php");
?>
<body>
	<?php require_once($common."navbar.php") ?>
	<div id="content">
		<div id="recipe"> 
			<div id="recipe_header">
			<?php
				$recipe_query = "SELECT * FROM recipe_page WHERE recipe_id =".$_GET['recipe_id'];
				$recipe_row = $connection->query($recipe_query)->fetch_assoc();
				$categories_query = "SELECT * FROM recipes_categories_with_name WHERE recipe_id = ".$_GET['recipe_id'];
				$categories_result = $connection->query($categories_query);
				$ingredients_query = 'SELECT * FROM ingredients_lists_units WHERE recipe_id ='.$_GET['recipe_id'];
				$ingredients_result = $connection->query($ingredients_query);
				echo '<div id="metadata">'; 
				while ($categories_row = $categories_result->fetch_assoc())
					echo '<a href="'.$common.'categories.php?category_id='.$categories_row['category_id'].'"> '.$categories_row['category'].' </a>'; 
				echo '<br> <a href="'.$common.'enlisted.php?user_id='.$recipe_row['user_id'].'&type=recipe_by_user"> '.$recipe_row['user_name'].' </a> <p id="metadatas"> '.$recipe_row['add_date'].' '.$recipe_row['update_date'].'     </p> </div>
				<h2 class="header">'.$recipe_row['title'].' </h2>
				<div id="mark_and_favourite">';
				if (isset($_SESSION['user_id']))
				{
					$favourites_query = 'SELECT * FROM favourites WHERE recipe_id = '.$_GET['recipe_id'].' AND user_id = '.$_SESSION['user_id'];
					if ( mysqli_num_rows($connection->query($favourites_query)) > 0 )
						echo '<a href="'.$user.'remove_from_favourite.php?recipe_id='.$_GET['recipe_id'].'" alt="Usuń z ulubionych"> ♥ </a>';
					else
						echo '<a href="'.$user.'add_to_favourite.php?recipe_id='.$_GET['recipe_id'].'" alt="Dodaj do ulubionych"> ♡ </a>';
					$marks_query = 'SELECT * FROM marks WHERE recipe_id = '.$_GET['recipe_id'].' AND user_id = '.$_SESSION['user_id'];
					$marks_result = $connection->query($marks_query);
					$marks_row = $marks_result->fetch_assoc();
					$rows = mysqli_num_rows($marks_result);
					if ( $rows > 0 && $marks_row ['mark'] != NULL)
						echo '<p> Już oceniono </p> <button onclick="redirect(\'remove_mark.php?user_id='.$_SESSION['user_id'].'&recipe_id='.$_GET['recipe_id'].'\')"> Cofnij </button>';
					else
					{
						if ($rows > 0 && $marks_row['mark'] == NULL)
							echo '<form method="post" action="update_mark.php">';
						else
							echo '<form method="post" action="add_mark.php">';
						echo '<label>Ocena <select name="mark">';
						for ($i=1; $i<=5; $i++)
							echo '<option value="'.$i.'"> '.$i.' </option>';
						echo '</select></label>
						<input type="submit" value="Oceń"> </input>
						<input type="hidden" name="recipe_id" value="'.$_GET['recipe_id'].'" > </input>
						</form>';
					}
					if (check_admin($_SESSION['user_id']))
					{
						echo '<a href="'.$recipes.'delete_recipe_form.php?recipe_id='.$_GET['recipe_id'].'" alt="Usuń przepis"> ✕ </a>
						<a href="'.$recipes.'edit_recipe_form.php?recipe_id='.$_GET['recipe_id'].'" alt="Edytuj przepis"> ✐ </a>';
					}
				}
				echo '<p> Ocena '.$recipe_row['average_mark'].'</p> </div>
				<div id="info_box"> 
					<p> 
						'.$recipe_row['meal'].' <br> 
						Porcje: '.$recipe_row['portions'].' <br> 
						Czas: '.$recipe_row['prepare_time'].' <br> 
						Trudność: '.$recipe_row['difficulty'].' <br> 
					</p>
				</div>
				<table id="ingredients_list">					
					<tr> <th colspan=3> Lista składników </th>';
					while ($ingredients_row = $ingredients_result->fetch_assoc())
					{
						echo '<tr> <td> '.$ingredients_row['ingredient'].' </td> <td> '.$ingredients_row['how_many'].' </td> <td> ';
						if ($ingredients_row['how_many'] == 1)
							echo $ingredients_row['singular'];
						else if ( ($ingredients_row['how_many'] % 10) >= 5 || ($ingredients_row['how_many'] % 10) == 0)
							echo $ingredients_row['plural_5pcs'];
						else
							echo $ingredients_row['plural_2pcs'];
						echo ' </td> </tr>';
					}
				echo '</table>
			</div>
			<div style="clear:both"> </div>
			<div>
				<p> '.$recipe_row['description'].' </p>
			</div>';
			?>
		</div>
	</div>
</body>
</html>