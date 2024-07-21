<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php');
	require_once($admins.'check_admin.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
        $queries = ['SELECT unit_id, plural_5pcs FROM units',
            'SELECT * FROM difficulties',
            'SELECT * FROM ingredients_lists WHERE recipe_id = '.$_POST['recipe_id'],
            'SELECT description FROM descriptions INNER JOIN recipes r USING (description_id) WHERE r.recipe_id = '.$_POST['recipe_id']];
		$unit_result = $connection->query($queries[0]);
		$difficulty_result = $connection->query($queries[1]);
		$ingredients_list_result = $connection->query($queries[2]);
		$description = $connection->query($queries[3])->fetch_assoc()['description'];
		echo '<div id="content">
		<div>
			<form class="form_with_table" name="edit_recipe" method="post" action="edit_recipe.php">
                <table id="ingredients_list_edit_recipe">	
                <th colspan=3> Lista składników </th>';
                while ($row = $ingredients_list_result->fetch_assoc())
                {
                    echo '<tr> 
                    <td> <input type="text" name="ingredients[]" value="'.$row['ingredient'].'"> </td> 
                    <td> <input type="text" name="how_many[]" value="'.$row['how_many'].'""> </input> </td> 
                    <td> <select name="units_ids[]">';
                    while ($unit_row = $unit_result->fetch_assoc())
                    {
                        echo '<option value='.$unit_row['unit_id']
                            .$row['unit_id'] == $unit_row['unit_id'] ? 'selected' : ' '.'> '
                            .$unit_row['plural_5pcs'].' </option>';
                    }
                    echo '</select> </td> </tr>';
                    $unit_result = $connection->query($queries[0]);
                }
                echo '</table>
                        <input type="button" id="add_row" 
                            onclick="addRowToTable(\'ingredients_list_edit_recipe\')"
                            value="Dodaj wiersz">
                        <input type="button" id="remove_row" 
                            onclick="removeRowFromTable(\'ingredients_list_edit_recipe\')"
                            value="Usuń wiersz"> <br/>
				<label> Opis <br/>
				<textarea name="description">'.$description.'</textarea> </label>';
				if (check_admin($_SESSION['user_id']))
					echo '<br/> <label> Zaakceptuj <input type="checkbox" name="accepted"> </label>';
				echo '<input type=hidden name="title" value="'.$_POST['title'].'"> <br/>
				<input type=hidden name="meal_id" value="'.$_POST['meal_id'].'"> <br/>
				<input type=hidden name="category_id" value="'.$_POST['category_id'].'"> <br/>
				<input type=hidden name="difficulty_id" value="'.$_POST['difficulty_id'].'"> <br/>
				<input type=hidden name="portions" value="'.$_POST['portions'].'"> <br/>
				<input type=hidden name="prepare_time" value="'.$_POST['prepare_time'].'"> <br/>
				<input type="hidden" name="recipe_id" value="'.$_POST['recipe_id'].'">
			<input type="submit" value="Uaktualnij przepis">
			</form>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>