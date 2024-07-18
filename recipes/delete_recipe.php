<?php require_once('../common/head.php'); 
	require_once('../common/database.php'); 
	$query = 'DELETE FROM recipes_categories WHERE recipe_id = '.$_GET['recipe_id'];
	$connection->query($query);
	$query = 'DELETE FROM recipes_metadatas WHERE metadata_id = '.$_GET['recipe_id'];
	$connection->query($query);
	$query = 'DELETE FROM ingredients_lists WHERE ingredients_lists_id = '.$_GET['recipe_id'];
	$connection->query($query);
	$query = 'DELETE FROM recipes WHERE recipe_id = '.$_GET['recipe_id'];
	$connection->query($query);
	echo '<script type="text/javascript"> history.go(-3) </script>';
?>