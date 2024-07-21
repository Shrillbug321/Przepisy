<?php
    global $common, $connection, $admins, $recipes;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
        $queries = ['SELECT * FROM meals','SELECT * FROM difficulties','SELECT * FROM categories'];
		$meal_result = $connection->query($queries[0]);
		$difficulty_result = $connection->query($queries[1]);
		$categories_result = $connection->query($queries[2]);
		echo '<div id="content">
		<div>
		<div id="content">
		<div>
			<form class="form" name="filters" method="post" action="filters.php">
				<label> 
					<input type="checkbox" name="checked[]" value="title"> 
					    <p>Nazwa przepisu </p></input>
					<input type=text name="title"> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="user_name"> 
					    <p>Użytkownik</p>
					</input>
					<input type=text name="user_name"> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="average_mark">
					    <p>Średnia ocena</p> </input>
					<input type="number" step="0.01" min="0" max="5" value="4" name="average_mark"> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="meal">
					    <p style="margin-bottom: -10px;">Danie</p>  </input> <br/>
					<select name="meal">';
					while ($row = $meal_result->fetch_assoc())
						echo '<option value='.$row['meal'].'> '.$row['meal'].' </option>';
					echo '</select> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="category">
					    <p style="margin-bottom: 5px;"> Rodzaj</p> </input>
					    <select name="category">';
					while ($row = $categories_result->fetch_assoc())
						echo '<option value='.$row['category'].'> '.$row['category'].' </option>';
					echo '</select> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="difficulty">
					    <p style="margin-bottom: 5px;">Poziom trudności</p> </input>
					    <select name="difficulty">';
					while ($row = $difficulty_result->fetch_assoc())
						echo '<option value='.$row['difficulty'].'> '.$row['difficulty'].' </option>';
					echo '</select> 
				</label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="portions">
					    <p>Porcji</p> </input>
					<input type="number" min="1" max="12" value="4" name="portions"> </label> <br/>
				<label> 
					<input type="checkbox" name="checked[]" value="prepare_time">
					    <p>Czas przygotowania</p> </input>
					<input type=time name="prepare_time"> </label> <br/>
			<input type="submit" value="Szukaj">
			</form>
		<div class="clear"></div>
			</div>
		</div>';
		require_once($common."footer.php");
	?>	
</body>