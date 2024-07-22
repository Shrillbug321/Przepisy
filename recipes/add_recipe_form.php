<?php
    global $common, $connection;
    require_once('../common/head.php'); 
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		$meal_result = $connection->query('SELECT * FROM meals');
		$difficulty_result = $connection->query('SELECT * FROM difficulties');
		$categories_result = $connection->query('SELECT * FROM categories');
		echo '
        <div id="content">
		    <div>
                <form class="form" name="add_recipe" method="post" action="add_recipe_form_step2.php">
                    <fieldset>
                        <legend> Formularz dodawania przepisu </legend>
                        <label> Nazwa przepisu <input type=text name="title"/> </label> <br/>
                        <label> Danie <br/>
                            <select name="meal_id">';
                            while ($row = $meal_result->fetch_assoc() )
                                echo '<option value='.$row['meal_id'].'> '.$row['meal'].' </option>';
                            echo '</select>
                        </label> <br/>
                        <label> Rodzaj <br/>
                            <select name="category_id">';
                            while ($row = $categories_result->fetch_assoc() )
                                echo '<option value='.$row['category_id'].'> '.$row['category'].' </option>';
                            echo '</select>
                        </label> <br/>
                        <label> Poziom trudności <br/>
                            <select name="difficulty_id">';
                            while ($row = $difficulty_result->fetch_assoc() )
                                echo '<option value='.$row['difficulty_id'].'> '.$row['difficulty'].' </option>';
                            echo '</select>
                        </label> <br/>
                        <label> Porcji <br/>
                            <input type=number min="1" max="12" name="portions"> 
                        </label> <br/>
                        <label> Czas przygotowania 
                            <input type=time name="prepare_time" alt="godzina"> 
                        </label>
                        <input type="submit" value="Dalej">
                    </fieldset>
                </form>
			</div>
		</div>';
	?>	
</body>