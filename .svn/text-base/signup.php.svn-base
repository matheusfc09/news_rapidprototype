<?php

	session_start();
	require 'system/config.php';
	require 'system/authentication.php';

	
	if(logged_in()) {
		$_SESSION['normal'] = "You are already logged in.";
		header("Location: index.php");
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

	<title><?php echo SITE_TITLE." - Login"; ?></title>

	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>

	<div id="wrapper">
		<div id="header-wrapper" class="container">
		<div id="header" class="container">
			<div id="logo">
				<h1><?php echo SITE_NAME; ?></h1>
			</div>
			<div id="menu"><?php require "system/menu.php"; ?></div>
		</div>
		<div><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		</div>
		<!-- end #header -->

		<div id="page">
			<div id="content">
				<?php require "system/alert.php"; ?>	
				<div class="post">
					<h2 class="title">Sign Up</h2>
					<div class="entry">
						<form action="create_user.php" method="POST">
							<input type="text" name="user[full_name]" placeholder="Enter your full name" size="50"><br>
							<input type="text" name="user[username]" placeholder="Enter your username"><br>
							<input type="password" name="user[password]" placeholder="Enter your password"><br>
							<input type="password" name="user[password_confirmation]" placeholder="Re-enter your password"><br>
							<div class="submit">
								<input type="submit" value="Sign up">
							</div>
						</form>
						<div class="login_links">Already registered? <a href="login.php">Log In</a></div>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end #content -->

			<div style="clear: both;"></div>
		</div>
		<div class="container"><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		<!-- end #page -->

	</div>
	<div id="footer-content"></div>
	<div id="footer">
		<p>Copyright (c) 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">FCT</a>.</p>
	</div>
	<!-- end #footer -->

</body>
</html>





















