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

	if(isset($_POST['post']) and !empty($_POST['post']['id']) and !empty($_POST['post']['title']) and !empty($_POST['post']['entry'])) {
		$post_id = $_POST['post']['id'];
		$title = strip_tags($_POST['post']['title']);
		$entry = $_POST['post']['entry'];
		$category = $_POST['post']['category'];

		$stmt = $mysqli->prepare("UPDATE posts SET title = ?, entry = ?, category = ? WHERE id = ? and user_id = ?");
		if(!$stmt) {
			$_SESSION['error'] = "Query failed!";
			header("Location: ".ROOT_PATH."error.php");
			exit;
		}
		
		$stmt->bind_param('sssii', $title, $entry, $category, $post_id, current_user_id());

		if(!$stmt->execute()) {
			$_SESSION['error'] = "Post does not exist or you are not the owner!";
			header("Location: ".ROOT_PATH."index.php");
			exit;
		}

		$stmt->close();

		$_SESSION['success'] = "Post updated successfully";
		header("Location: view.php?id=".$post_id);
		exit;

	} else {
		$_SESSION['error'] = "An error ocurred while updating the post. Try again!";
		if(isset($_POST['post']) and !empty($_POST['post']['id']))
			header("Location: edit.php?id=".$_POST['post']['id']);
		else
			header("Location: ".ROOT_PATH."index.php");
		exit;
	}
	
?>
