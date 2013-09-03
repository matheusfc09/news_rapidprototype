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

	if(isset($_POST['id']) and isset($_POST['post_id'])) {
		$comment_id = $_POST['id'];
		$post_id = $_POST['post_id'];

		if(admin())
			$stmt = $mysqli->prepare("DELETE FROM comments WHERE id = ?");
		else
			$stmt = $mysqli->prepare("DELETE FROM comments WHERE id = ? and user_id = ?");
		
		if(!$stmt) {
			$_SESSION['error'] = "Query failed!";
			header("Location: ".ROOT_PATH."error.php");
			exit;
		}
		
		if(admin())
			$stmt->bind_param('i', $comment_id);
		else
			$stmt->bind_param('ii', $comment_id, current_user_id());
			
		if(!$stmt->execute()) {
			$_SESSION['error'] = "Comment does not exist or you are not the owner!";
			header("Location: ".ROOT_PATH."index.php");
			exit;
		}

		$stmt->close();

		$_SESSION['success'] = "Comment deleted successfully";
		header("Location: view.php?id=".$post_id);
		exit;

	} else {
		$_SESSION['error'] = "An error ocurred while deleting the comment. Try again!";
		if(isset($_POST['post_id']))
			header("Location: view.php?id=".$_POST['post_id']);
		else
			header("Location: ".ROOT_PATH."index.php");
		exit;
	}
	
?>
