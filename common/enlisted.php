<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = "";
        $is_filtered = isset($_GET['id']);
        if ($is_filtered)
        {
			switch ($_GET['type']) {
				case 'category':
					$query = 'SELECT * FROM recipes_for_category WHERE category_id = ' . $_GET['id'];
					break;
				case 'meal':
					$query = 'SELECT * FROM recipes_for_meal WHERE meal_id = ' . $_GET['id'];
					break;
				case 'recipe_by_user':
					$query = 'SELECT * FROM recipes_for_user WHERE user_id = ' . $_GET['id'];
					break;
			}
		}
        else
        {
			switch ($_GET['type']) {
				case 'category':
					$query = 'SELECT * FROM categories';
					break;
				case 'meal':
					$query = 'SELECT * FROM meals';
					break;
				case 'recipe_by_user':
					$query = 'SELECT * FROM recipes_for_user';
					break;
			}
		}
		$result = $connection->query($query);
		$row = $result->fetch_assoc();
		echo '<div id="content">
		<div>';
		if ($row == NULL)
		{
			switch ($_GET['type'])
			{
                case 'category':
                    echo 'Niczego nie znaleziono w przeglądanej kategorii.';
                    break;
                case 'meal':
                    echo 'Niczego nie znaleziono według dania.';
                    break;
                case 'recipe_by_user':
                    echo 'Ten użytkownik jeszcze niczego nie dodał.';
                    break;
			}
			exit();
		}
        if ($is_filtered)
		{
			switch ($_GET['type'])
			{
				case 'category':
					echo '<h2 class="header"> '.$row['category'].' </h2>';
					break;
				case 'meal':
					echo '<h2 class="header"> '.$row['meal'].' </h2>';
					break;
				case 'recipe_by_user':
					echo '<h2 class="header"> Przepisy użytkownika '.$row['user_name'].' </h2>';
					break;
			}
			do
			{
				echo '<div class="tile"> 
				 <a href="'.$recipes.'recipe.php?recipe_id='.$row['recipe_id'].'">
					<p class="small_header"> '.$row['title'].' </p>
					<p class="text"> '.$row['description'].' </p> 
				</a>
			</div>';
			} while ($row = $result->fetch_assoc());
        }
		else
        {
			switch ($_GET['type'])
			{
				case 'category':
					echo '<h2 class="header"> Rodzaje </h2>';
					break;
				case 'meal':
					echo '<h2 class="header"> Dania </h2>';
					break;
				case 'recipe_by_user':
					echo '<h2 class="header"> Przepisy użytkownika '.$row['user_name'].' </h2>';
					break;
			}
            echo '<ul class="category_list">';
			do
			{
				echo '<li class="navbar_menu"> 
				 <a href="'.$common.'enlisted.php?id='.$row[$_GET['type'].'_id'].'&type='.$_GET['type'].'">
					'.$row[$_GET['type']].'
				</a>
			</li>';
			} while ($row = $result->fetch_assoc());
            echo '</ul>';
        }
		echo '<div class="clear"></div>
			</div>
		</div>';
	?>	
</body>