<?php

	session_start();
	require "../system/database.php";
	require "../system/config.php";
	require "../system/authentication.php";

	if(!logged_in()) {
		$_SESSION['error'] = "You need to be logged in.";
		header("Location: ".ROOT_PATH."login.php");
		exit;
	}

	if(isset($_POST['post']) and !empty($_POST['post']['title']) and !empty($_POST['post']['entry'])) {
		$title = strip_tags($_POST['post']['title']);
		$entry = $_POST['post']['entry'];
		$category = $_POST['post']['category'];
		$user_id = current_user_id();

		$stmt = $mysqli->prepare("INSERT INTO posts (title, entry, category, user_id) values (?, ?, ?, ?)");
		if(!$stmt) {
			$_SESSION['error'] = "Query failed!";
			header("Location: ".ROOT_PATH."error.php");
			exit;
		}
		
		$stmt->bind_param('sssi', $title, $entry, $category, $user_id);
		$stmt->execute();
		$stmt->close();

		$_SESSION['success'] = "Post created successfully";
		header("Location: ".ROOT_PATH."index.php");
		exit;

	} else {
		$_SESSION['error'] = "An error ocurred while creating the post. Try again!";
		header("Location: new.php");
	}
	
?>
