<?php
	foreach($_POST['accepted'] as $recipe_id)
	{
		$query = 'UPDATE recipes SET accepted = 1 WHERE recipe_id = '.$recipe_id;
		$result = $connection->query($query);
	}
	echo '<script type="text/javascript"> history.go(-1) </script>';
?>