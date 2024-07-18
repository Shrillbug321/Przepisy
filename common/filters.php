<?php require_once('../common/head.php'); 
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$query = 'SELECT * FROM recipe_page';
		if (isset($_POST['checked'])) 
		{
			$i = 0;
			foreach($_POST['checked'] as $key)
			{
				if ($i == 0)
					$query .= ' WHERE ';
				else
					$query .= ' AND ';
				$query .= $key.' = "'.$_POST[$key].'"';
				$i++;
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
		require_once($common."footer.php");
	?>	
</body>
</html>