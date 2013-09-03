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

	function selected($option, $category) {
		if($option == $category)
			echo "selected=\"selected\"";
	}
		
	$stmt = $mysqli->prepare("SELECT posts.id, posts.title, posts.entry, posts.category, posts.user_id FROM posts WHERE posts.id = ?");
	
	if(!$stmt){
		$_SESSION['error'] = "Query Failed!";
		header("Location: ".ROOT_PATH."error.php");
		exit;
	}

	if(isset($_GET['id'])) {
		$stmt->bind_param('i', $_GET['id']);
	} else {
		$_SESSION['error'] = "The requested post is not available or does not exist!";
		header("Location: ".ROOT_PATH."index.php");
		exit;
	}
?>
<!DOCTYPE html>
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Emerald 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20120902

-->
<html>
<head>

	<title><?php echo SITE_TITLE." - Edit Post"; ?></title>

	<link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css">
	<link href="<?php echo ROOT_PATH."/css/style.css"; ?>" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>

	<div id="wrapper">
		<div id="header-wrapper" class="container">
		<div id="header" class="container">
			<div id="logo">
				<h1><?php echo SITE_NAME; ?></h1>
			</div>
			<div id="menu"><?php require "../system/menu.php"; ?></div>
		</div>
		<div><img src="<?php echo ROOT_PATH."images/img03.png"; ?>" width="1000" height="40" alt="" /></div>
		</div>
		<!-- end #header -->

		<div id="page">
			<div id="content">
				<?php require "../system/alert.php"; ?>
				<?php

					$stmt->execute();
					$stmt->bind_result($post_id, $title, $entry, $category, $user_id);
					if(!$stmt->fetch()) {
						$_SESSION['error'] = "The requested post is not available or does not exist!";
						header("Location: ".ROOT_PATH."index.php");
						exit;
					}

					if(!owner($user_id)) {
						$_SESSION['error'] = "You are not the owner of the post!";
						header("Location: view.php?id=".$post_id);
						exit;
					}

				?>
				<div class="post">
					<h2 class="title">Edit Post</h2>
					<div class="entry">
						<form action="update.php" method="POST">
							<input type="hidden" name="post[id]" value="<?php echo $post_id; ?>">
							<input type="text" name="post[title]" value="<?php echo $title; ?>"><br>
							<textarea name="post[entry]" rows="20"><?php echo $entry; ?></textarea><br>
							<select name="post[category]">
								<option <?php selected("news", $category); ?> value="news">News</option>
								<option <?php selected("science", $category); ?> value="science">Science</option>
								<option <?php selected("entertainment", $category); ?> value="entertainment">Entertainment</option>
								<option <?php selected("events", $category); ?> value="events">Events</option>
							</select>
							<div class="submit">
								<input type="submit" value="Update Post">
							</div>
						</form>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end #content -->
			<div id="sidebar">
				<ul>
					<?php require '../system/profile.php'; ?>
				</ul>
			</div>
			<!-- end #sidebar -->

			<div style="clear: both;"></div>
		</div>
		<div class="container"><img src="<?php echo ROOT_PATH."images/img03.png"; ?>" width="1000" height="40" alt="" /></div>
		<!-- end #page -->

	</div>
	<div id="footer-content"></div>
	<div id="footer">
		<p>Copyright (c) 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">FCT</a>.</p>
	</div>
	<!-- end #footer -->

</body>
</html>
