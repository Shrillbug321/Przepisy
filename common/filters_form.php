<?php
    global $common, $connection, $admins, $recipes;
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
                <form class="form" name="filters" method="post" action="filters.php">
                    <fieldset>
                        <legend>Formularz szukania przepisu</legend>
                        <label>
                            <p class="label_for_blind">Szukaj po nazwie przepisu </p>
                            <input type="checkbox" name="checked[]" value="title"> 
                        </label>
                        <label> 
                            <p>Nazwa przepisu </p>
                            <input type=text name="title"> 
                        </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po nazwie użytkownika </p>
                            <input type="checkbox" name="checked[]" value="user_name"> 
                        </label>
                        <label>
                            <p>Użytkownik</p>
                            <input type=text name="user_name"> 
                        </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po średniej ocenie </p>
                            <input type="checkbox" name="checked[]" value="average_mark"> 
                        </label>
                        <label>
                            <p>Średnia ocena</p>
                            <input type="number" step="0.01" min="0" max="5" value="4" name="average_mark"> 
                        </label> <br/>
                        <label>
                            <p class="label_for_blind">Szukaj po daniu </p>
                            <input type="checkbox" name="checked[]" value="meal"> 
                        </label>
                        <label>
                            <p style="margin-bottom: -10px;">Danie</p> <br/>
                            <select name="meal">';
                            while ($row = $meal_result->fetch_assoc())
                                echo '<option value='.$row['meal'].'> '.$row['meal'].' </option>';
                            echo '</select> 
                        </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po rodzaju </p>
                            <input type="checkbox" name="checked[]" value="category"> 
                        </label>
                        <label>
                            <p style="margin-bottom: 5px;"> Rodzaj</p>
                            <select name="category">';
                            while ($row = $categories_result->fetch_assoc())
                                echo '<option value='.$row['category'].'> '.$row['category'].' </option>';
                            echo '</select> 
                        </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po poziomie trudności </p>
                            <input type="checkbox" name="checked[]" value="difficulty"> 
                        </label>
                        <label>
                            <p style="margin-bottom: 5px;">Poziom trudności</p>
                            <select name="difficulty">';
                            while ($row = $difficulty_result->fetch_assoc())
                                echo '<option value='.$row['difficulty'].'> '.$row['difficulty'].' </option>';
                            echo '</select> 
                        </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po liczbie porcji </p>
                            <input type="checkbox" name="checked[]" value="portions"> 
                        </label>
                        <label>
                            <p>Liczba porcji</p>
                            <input type="number" min="1" max="12" value="4" name="portions"> </label> <br/>
                        <label> 
                            <p class="label_for_blind">Szukaj po czasie przygotowania </p>
                            <input type="checkbox" name="checked[]" value="prepare_time"> 
                        </label>
                        <label>
                            <p>Czas przygotowania</p>
                            <input type=time name="prepare_time"> </label> <br/>
                        <input type="submit" value="Szukaj">
                </fieldset>
			</form>
		    <div class="clear"></div>
			</div>
		</div>';
	?>	
</body>