<?php
    global $common;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		require_once($common."navbar.php");
		echo '<div id="content">
		<div>
			<form class="form" name="add_category" method="post" action="add_category.php" id="add_category">
				<table id="category_table">	
					<th colspan=2> Kategorie </th>
					<tr> 
						<td> <input type="text" name="categories[]"> </td>
					</tr></table>
					<div>
					    Wiersz
                        <input type="button" id="add_row" onclick="add_row_to_table(\'category_table\')" value="Dodaj">  
                        <input type="button" id="remove_row" onclick="remove_row_from_table(\'category_table\')" value="Usuń">
                    </div>
					  
			<input type="submit" value="Dodaj kategorie">
			</form>
			</div>
		</div>';
	?>	
</body>