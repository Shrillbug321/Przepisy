<?php
    global $common, $connection, $admins, $recipes, $user;
    require_once('../common/head.php');
	require_once($admins.'check_admin.php'); 
?>
<nav id="site_header">
	<h1 id="site_name"> <a href="../common/index.php"> 👨‍🍳Przepisy👩‍🍳 </a> </h1>
	<ul id="navbar">
		<li class="navbar_button" id="meal">
            <a href="enlisted.php?type=meal"> Danie </a>
			<ul> 
			<?php
				$result = $connection->query('SELECT * FROM meals');
				while ($row = $result->fetch_assoc())
					echo '<li class="navbar_menu"> <a href="enlisted.php?id='.$row['meal_id'].'&type=meal"> '.$row['meal'].' </a> </li>';
			?>
			</ul>
		</li>
		<li class="navbar_button" id="category">
            <a href="enlisted.php?type=category"> Rodzaj </a>
            <ul>
			<?php
				$result = $connection->query('SELECT * FROM categories');
				$cells = mysqli_num_rows($result);
				$actual_cell = 0;
                while ($actual_cell < $cells)
                {
                    echo '<div class="category_row">';
                    for ($i = 0; $i < 3; $i++)
                    {
                        $row = $result->fetch_assoc();
                        echo '<div class="category_col">
                                <a class="navbar_menu"
                                 href="'.$common.'enlisted.php?id='.$row['category_id'].'&type=category"> '.$row['category'].' </a> </div>';
                        if ($actual_cell++ == $cells)
                            break;
                    }
                    echo '</div>';
                }
			?>
			</ul>
		</li>
		<li class="navbar_button"> <a href="../common/filters_form.php"> Szukaj </a> </li>

	<?php
		if (!isset($_SESSION['user_id']))
			echo '<li class="navbar_button" id="login_button"> 
                    <a href="'.$user.'login_form.php"> Zaloguj się </a> </li>';
		else
		{
			echo '<li class="navbar_button">
                    <a href="'.$user.'account.php"> Konto </a> </li>';

			$query = 'SELECT * FROM admins WHERE user_id = '.$_SESSION['user_id'];
			if (mysqli_num_rows($connection->query($query)) > 0)
				echo '<li class="navbar_button"> 
                        <a href="'.$admins.'admin_panel.php"> Admin </a> </li>';

            echo '<li class="navbar_text">'
			    .$_SESSION['user_name'].' </li>
			    <li class="navbar_button" id="login_button"> 
			    <a href="'.$user.'logout.php"> Wyloguj się </a> </li>';
		}
	?>
	</ul>
	<div style="clear: both;"> </div>
	<div id="underline"> </div>
</nav>