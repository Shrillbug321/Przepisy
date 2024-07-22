<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = 'SELECT * FROM recipe_page WHERE accepted = 1';
		if (isset($_POST['checked'])) 
		{
			foreach ($_POST['checked'] as $key)
			{
				$query .= ' AND ';
                switch ($key)
				{
                    case 'title':
                    case 'user':
					    $query .= $key.' LIKE "%'.$_POST[$key].'%"';
                        break;
                    case 'average_mark':
                    case 'portions':
						$query .= $key.' >= "'.$_POST[$key].'"';
                        break;
                    case 'prepare_time':
						$query .= $key.' <= "'.$_POST[$key].'"';
                        break;
                    default:
						$query .= $key.' = "'.$_POST[$key].'"';
                }
			}
		}	
		echo '<div id="content">
		<div>';
		$result = $connection->query($query);
		if (mysqli_num_rows($result))
		{
			while ($row = $result->fetch_assoc())
			{
				echo '<div class="tile"> 
					 <a href="'.$recipes.'recipe.php?recipe_id='.$row['recipe_id'].'">
						<p class="small_header"> '.$row['title'].' </p>
						<p class="text"> '.$row['description'].' </p> 
					</a>
				</div>';
			}
		}
		else
			echo 'Nie znaleziono przepisu o szukanych parametrach';
		echo '<div class="clear"></div>
			</div>
		</div>';
	?>	
</body>