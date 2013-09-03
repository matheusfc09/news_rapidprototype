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

	if(isset($_POST['id'])) {
		$post_id = $_POST['id'];

		if(admin())
			$stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ?");
		else		
			$stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ? and user_id = ?");
		
		if(!$stmt) {
			$_SESSION['error'] = "Query failed!";
			header("Location: ".ROOT_PATH."error.php");
			exit;
		}
		
		if(admin())
			$stmt->bind_param('i', $post_id);
		else
			$stmt->bind_param('ii', $post_id, current_user_id());

		if(!$stmt->execute()) {
			$_SESSION['error'] = "Post does not exist or you are not the owner!";
			header("Location: ".ROOT_PATH."index.php");
			exit;
		}

		$stmt->close();

		$_SESSION['success'] = "Post deleted successfully";
		header("Location: ".ROOT_PATH."index.php");
		exit;

	} else {
		$_SESSION['error'] = "An error ocurred while deleting the post. Try again!";
		header("Location: ".ROOT_PATH."index.php");
		exit;
	}
	
?>
