<?php
    global $connection;
    require_once('../common/head.php');
	require_once('../common/database.php'); ?>
<body>
	<?php
		foreach($_POST['categories'] as $key)
			$connection->query('INSERT INTO categories(category) VALUES ("'.$key.'")');
		echo '<script> history.go(-2) </script>';
	?>	
</body>