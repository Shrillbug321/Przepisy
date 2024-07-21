<?php
    global $common;
	require_once('../common/head.php');
	session_unset();
	session_destroy();
	echo '<script type="text/javascript"> location.href = "'.$common.'index.php" </script>';
?>