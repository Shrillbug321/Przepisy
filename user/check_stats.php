<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	 require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$user_id = $_SESSION['user_id'];
		$account_created = $connection->query(
                'SELECT account_created FROM users_stats 
                       WHERE user_id = '.$user_id)->fetch_assoc()['account_created'];
		$user_recipes = $connection->query(
                'SELECT COUNT(*) AS user_recipes FROM recipes_metadatas 
                        WHERE user_id = '.$user_id)->fetch_assoc()['user_recipes'];
		$user_recipes_accepted = $connection->query(
                'SELECT COUNT(*) AS user_recipes_accepted FROM recipes_metadatas INNER JOIN recipes USING (recipe_id) 
                       WHERE user_id = '.$user_id.' AND accepted')->fetch_assoc()['user_recipes_accepted'];
		$user_favourites = $connection->query(
                'SELECT COUNT(*) AS user_favourites FROM favourites 
                       WHERE user_id = '.$user_id)->fetch_assoc()['user_favourites'];
		$user_marks = $connection->query(
                'SELECT COUNT(*) AS user_marks FROM marks 
                       WHERE user_id = '.$user_id.' AND mark')->fetch_assoc()['user_marks'];
		$user_average_marks = $connection->query(
                'SELECT AVG(mark) AS user_average_marks FROM marks 
                       WHERE user_id = '.$user_id.' AND mark')->fetch_assoc()['user_average_marks'];
		$other_average_marks = $connection->query(
                'SELECT mark AS other_average_marks FROM marks 
                        WHERE recipe_id IN 
                              (SELECT recipe_id FROM recipes_metadatas 
                                WHERE user_id = '.$user_id.')
                        AND user_id != '.$user_id)->fetch_assoc()['other_average_marks'];
		echo '
        <div id="content">
			<div>
				<table> 
                    <tr>
                        <td> Konto utworzono </td><td>'.$account_created.'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: 600"> Przepisy </td>
                    </tr>
                    <tr>
                        <td> Dodano </td><td>'.$user_recipes.'</td>
                    </tr>
                    <tr>
                        <td> Zaakceptowano </td><td>'.$user_recipes_accepted.'</td>
                    </tr>
                    <tr>
                        <td> Ulubionych </td><td>'.$user_favourites.'</td>
                    </tr>
                    <tr>
                        <td> Ocenionych </td><td>'.$user_marks.'</td>
                    </tr>
                    <tr>
                        <td> Średnio oceniasz na </td><td>'.$user_average_marks.'</td>
                    </tr>
                    <tr>
                        <td> Inni oceniają Cię na </td><td>'.$other_average_marks.'</td>
                    </tr>
                </table>
			</div>
		</div>';
	?>	
</body>