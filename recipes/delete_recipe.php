<?php
    global $connection;
    require_once('../common/head.php');
	require_once('../common/database.php');
    $queries = ['DELETE FROM recipes_categories WHERE recipe_id = '.$_GET['recipe_id'],
        'DELETE FROM recipes_metadatas WHERE metadata_id = '.$_GET['recipe_id'],
        'DELETE FROM ingredients_lists WHERE ingredients_list_id = '.$_GET['recipe_id'],
        'DELETE FROM recipes WHERE recipe_id = '.$_GET['recipe_id']];
    foreach ($queries as $query)
        $connection->query($query);
	echo '<script type="text/javascript"> history.go(-3) </script>';
?>