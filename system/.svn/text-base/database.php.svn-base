<?php

	$mysqli = new mysqli('localhost', 'news_inst', 'news_pass', 'news');

	if($mysqli->connect_errno) {
		$_SESSION['error'] = "Connection with database failed!";
		header("Location: error.php");
		exit;
	}

?>
