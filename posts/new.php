<?php

	session_start();
	require "../system/config.php";
	require "../system/authentication.php";

	if(!logged_in()) {
		$_SESSION['error'] = "You need to be logged in.";
		header("Location: ".ROOT_PATH."login.php");
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

	<title><?php echo SITE_TITLE." - New Post"; ?></title>

	<link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css">
	<link href="<?php echo ROOT_PATH.'/css/style.css'; ?>" rel="stylesheet" type="text/css" media="screen" />

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
				<div class="post">
					<h2 class="title">New Post</h2>
					<div class="entry">
						<form action="create.php" method="POST">
							<input type="text" name="post[title]" placeholder="Enter the title"><br>
							<textarea name="post[entry]" rows="20" placeholder="Enter the post text"></textarea><br>
							<select name="post[category]">
								<option selected="selected" value="news">News</option>
								<option value="science">Science</option>
								<option value="entertainment">Entertainment</option>
								<option value="events">Events</option>
							</select>
							<div class="submit">
								<input type="submit" value="Create Post">
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
