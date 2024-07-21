<?php
    global $common, $connection, $admins, $recipes, $user;
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
                $queries = ['SELECT * FROM recipe_page WHERE recipe_id ='.$_GET['recipe_id'],
                    'SELECT * FROM recipes_categories_with_name WHERE recipe_id = '.$_GET['recipe_id'],
                    'SELECT * FROM ingredients_lists_units WHERE recipe_id ='.$_GET['recipe_id']];
				$recipe_row = $connection->query($queries[0])->fetch_assoc();
				$categories_result = $connection->query($queries[1]);
				$ingredients_result = $connection->query($queries[2]);
				echo '<div id="metadata">';
				while ($categories_row = $categories_result->fetch_assoc())
					echo '<a href="'.$common.'categories.php?category_id='.$categories_row['category_id'].'"> '
                        .$categories_row['category'].' </a>';
				echo '<br/>
                    <a href="'.$common.'enlisted.php?id='.$recipe_row['user_id'].'&type=recipe_by_user"> '
                    .$recipe_row['user_name'].' </a>
                    <p id="metadatas"> '.$recipe_row['add_date'].' '.$recipe_row['update_date'].' </p> </div>
				<h2 class="header">'.$recipe_row['title'].' </h2>
				<div id="mark_and_favourite">';
				if (isset($_SESSION['user_id']))
				{
                    if (check_admin($_SESSION['user_id']))
                    {
                        echo '<div style="margin-bottom: 10px;">
                                <a class="icon"
                                    href="'.$recipes.'edit_recipe_form.php?recipe_id='.$_GET['recipe_id'].'"
                                    title="Edytuj przepis"> ✐ </a>
                                <a class="icon"
                                    href="'.$recipes.'delete_recipe_form.php?recipe_id='.$_GET['recipe_id'].'"
                                    title="Usuń przepis"> ✕ </a>
                            </div> <br/>';
                    }
					$favourites_query = 'SELECT * FROM favourites 
                                            WHERE recipe_id = '.$_GET['recipe_id'].' AND user_id = '.$_SESSION['user_id'];
					if (mysqli_num_rows($connection->query($favourites_query)) > 0)
						echo '<a class="icon"
						        href="'.$user.'remove_from_favourite.php?recipe_id='.$_GET['recipe_id'].'"
                                title="Usuń z ulubionych"> ♥ </a>';
					else
						echo '<a class="icon"
						        href="'.$user.'add_to_favourite.php?recipe_id='.$_GET['recipe_id'].'"
                                title="Dodaj do ulubionych"> ♡ </a>';
					$marks_query = 'SELECT * FROM marks 
                                        WHERE recipe_id = '.$_GET['recipe_id'].' AND user_id = '.$_SESSION['user_id'];
					$marks_result = $connection->query($marks_query);
					$marks_row = $marks_result->fetch_assoc();
					$rows = mysqli_num_rows($marks_result);
					if ($rows > 0 && $marks_row['mark'] != NULL)
						echo '<p> Twoja ocena: '.$marks_row['mark'].'</p> 
                                <button onclick="redirect(\'remove_mark.php?user_id='.$_SESSION['user_id'].'&recipe_id='.$_GET['recipe_id'].'\')">
                                 Cofnij ocenę</button> <br/>';
					else
					{
						if ($rows > 0 && $marks_row['mark'] == NULL)
							echo '<form method="post" action="update_mark.php">';
						else
							echo '<form method="post" action="add_mark.php">';
						echo '<label>Oceń przepis <select name="mark">';
						for ($i = 1; $i <= 5; $i++)
							echo '<option value="'.$i.'"> '.$i.' </option>';
						echo '</select></label>
						<input type="submit" value="Oceń">
						<input type="hidden" name="recipe_id" value="'.$_GET['recipe_id'].'" >
						</form> <br/>';
					}
				}
				echo '<p> Ocena '.$recipe_row['average_mark'].'</p> </div>
				<table id="info_box"> 
					<tr>
					    <th colspan="2"> <a href="enlisted.php?id='.$recipe_row['meal_id'].'&type=meal"> '.$recipe_row['meal'].' </a></th>
                    </tr>
                    <tr>
                        <td>Porcje</td><td>'.$recipe_row['portions'].'</td>
                    </tr>
                    <tr>
                        <td>Czas</td><td>'.$recipe_row['prepare_time'].'</td>
                    </tr>
                    <tr>
                        <td>Trudność</td><td>'.$recipe_row['difficulty'].'</td>
                    </tr>
				</table>
				<table id="ingredients_list">					
					<tr> <th colspan=3> Lista składników </th>';
					while ($ingredients_row = $ingredients_result->fetch_assoc())
					{
						echo '<tr> <td> '.$ingredients_row['ingredient'].' </td> <td> '.$ingredients_row['how_many'].' </td> <td> ';
						if ($ingredients_row['how_many'] == 1)
							echo $ingredients_row['singular'];
						else if (($ingredients_row['how_many'] % 10) >= 5 || ($ingredients_row['how_many'] % 10) == 0)
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