<?php

	require "config.php";
	require "authentication.php";

	if(logged_in()) {
		echo "<li>";
			echo "<h2>Profile</h2>";
			echo "<ul>";
				echo "<li><a href=\"".ROOT_PATH."posts/own.php\">My Posts</a></li>";
				echo "<li><a href=\"".ROOT_PATH."posts/new.php\">New Post</a></li>";
				echo "<li><a href=\"".ROOT_PATH."change_password.php\">Change Password</a></li>";
				echo "<li><a href=\"".ROOT_PATH."logout.php\">Logout</a></li>";
			echo "</ul>";
		echo "</li>";
	}

?>
