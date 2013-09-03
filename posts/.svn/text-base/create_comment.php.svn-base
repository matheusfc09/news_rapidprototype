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

	if(isset($_POST['comment']) and !empty($_POST['comment']['comment'])) {
		$comment = strip_tags($_POST['comment']['comment']);
		$post_id = $_POST['comment']['post_id'];
		$user_id = current_user_id();

		$stmt = $mysqli->prepare("INSERT INTO comments (comment, post_id, user_id) values (?, ?, ?)");
		if(!$stmt) {
			$_SESSION['error'] = "Query failed!";
			header("Location: ".ROOT_PATH."error.php");
			exit;
		}
		
		$stmt->bind_param('sii', $comment, $post_id, $user_id);
		$stmt->execute();
		$stmt->close();

		$_SESSION['success'] = "Comment created successfully";
		header("Location: ".ROOT_PATH."posts/view.php?id=".$post_id);
		exit;

	} else {
		$_SESSION['error'] = "An error ocurred while creating the comment. Try again!";
		header("Location: view.php?id=".$post_id);
	}
	
?>
