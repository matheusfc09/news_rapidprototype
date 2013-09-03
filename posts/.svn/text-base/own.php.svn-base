<?php

	session_start();
	require '../system/database.php';
	require '../system/config.php';
	require '../system/authentication.php';

	if(!logged_in()) {
		$_SESSION['error'] = "You need to be logged in.";
		header("Location: ".ROOT_PATH."login.php");
		exit;
	}
		
	$stmt = $mysqli->prepare("SELECT posts.id, posts.title, posts.entry, posts.category, posts.creation, COUNT(comments.id) FROM posts LEFT JOIN comments ON posts.id = comments.post_id WHERE posts.user_id = ? GROUP BY posts.id ORDER BY creation DESC");
	
	if(!$stmt){
		$_SESSION['error'] = "Query Failed!";
		header("Location: error.php");
		exit;
	}

	$stmt->bind_param('i', current_user_id());

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

	<title><?php echo SITE_TITLE." - My Posts"; ?></title>

	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
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
				<h2 class="title">My Posts</h2>
				<?php

					$stmt->execute();
					$stmt->bind_result($post_id, $title, $entry, $category, $creation, $comments_count);

					$stmt->store_result();					
					$num_rows = $stmt->num_rows;
					
					if($num_rows < 1)
						echo "<div id=\"alert\" class=\"normal\">You have no posts</div>";

					while($stmt->fetch()) {

				?>
				<div id="post_<?php echo $post_id; ?>" class="post_row">
					<h1 class="title">
						<a href="view.php?id=<?php echo $post_id; ?>"><?php echo htmlspecialchars($title); ?></a>
					</h1>
					<div class="meta">
						<ul class="options">
							<li><a href="view.php?id=<?php echo $post_id; ?>"><?php printf(ngettext("%d Comment", "%d Comments", $comments_count), $comments_count); ?></a></li>
							<li><a href="edit.php?id=<?php echo $post_id; ?>">Edit</a></li>
							<li class="link_bt">
								<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
									<input type="hidden" name="id" value="<?php echo $post_id; ?>">
									<input type="submit" value="Remove">
								</form>
							</li>
						</ul>
						<div class="info">
							<span>In <?php echo "<a href=\"".ROOT_PATH."index.php?cat=".$category."\">".$category."</a>"; ?>,</span>
							<span><?php echo date("F d, Y", strtotime($creation)); ?></span>
						</div>
					</div>
				</div>
				
				<?php

					}
					$stmt->close();

				?>

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
