<?php

	session_start();
	require 'system/database.php';
	require 'system/config.php';
	require 'system/authentication.php';
	require 'system/pagination.php';

		
	if(isset($_GET['cat']) and $_GET['cat'] != 'all')
		$stmt = $mysqli->prepare("SELECT posts.id, posts.title, posts.entry, posts.category, posts.creation, users.id, users.full_name, COUNT(comments.id) FROM (posts JOIN users ON posts.user_id = users.id) LEFT JOIN comments ON posts.id = comments.post_id WHERE category = ? GROUP BY posts.id ORDER BY creation DESC LIMIT ?, 4");
	else
		$stmt = $mysqli->prepare("SELECT posts.id, posts.title, posts.entry, posts.category, posts.creation, users.id, users.full_name, COUNT(comments.id) FROM (posts JOIN users ON posts.user_id = users.id) LEFT JOIN comments ON posts.id = comments.post_id GROUP BY posts.id ORDER BY creation DESC LIMIT ?, 4");
	
	if(!$stmt){
		$_SESSION['error'] = "Query Failed!";
		header("Location: error.php");
		exit;
	}

	if(isset($_GET['cat']) and $_GET['cat'] != 'all')
		$stmt->bind_param('si', $_GET['cat'], $start);
	else 
		$stmt->bind_param('i', $start);

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

	<title><?php echo SITE_TITLE." - Welcome"; ?></title>

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
				<?php

					$stmt->execute();
					$stmt->bind_result($post_id, $title, $entry, $category, $creation, $user_id, $user_name, $comments_count);

					$stmt->store_result();					
					$num_rows = $stmt->num_rows;
					
					if($num_rows < 1)
						echo "<div id=\"alert\" class=\"normal\">There are no more entries</div>";

					while($stmt->fetch()) {

				?>
				<div id="post_<?php echo $post_id; ?>" class="post">
					<h2 class="title">
						<a href="posts/view.php?id=<?php echo $post_id; ?>"><?php echo htmlspecialchars($title); ?></a>
					</h2>
					<p class="meta">
						<span class="date"><?php echo date("F d, Y", strtotime($creation)); ?></span>
						<span class="posted">
							<span>In <?php echo "<a href=\"?cat=".$category."\">".$category."</a>"; ?>,</span>
							<span>Posted by <?php echo $user_name; ?></span>
						</span>
					</p>
					<div style="clear: both;"></div>
					<div class="entry">
						<?php echo html_entity_decode($entry); ?>
						<div class="links">
							<span><a href="posts/view.php?id=<?php echo $post_id; ?>"><?php printf(ngettext("%d Comment", "%d Comments", $comments_count), $comments_count); ?></a></span>
							<?php

								if(owner($user_id))
									echo "<span><a href=\"posts/edit.php?id=$post_id\">Edit</a></span>";

								if(owner($user_id) or admin()) { 
									echo "<span class=\"link_bt\">";
										echo "<form action=\"posts/delete.php\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete?')\";>";
											echo "<input type=\"hidden\" name=\"id\" value=\"$post_id\">";
											echo "<input type=\"submit\" value=\"Remove\">";
										echo "</form>";
									echo "</span>";
								}
							?>
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
					<?php require 'system/profile.php'; ?>
					<li>
						<h2>Categories</h2>
						<ul>
							<li><a href="?cat=all">All</a></li>
							<li><a href="?cat=news">News</a></li>
							<li><a href="?cat=science">Science</a></li>
							<li><a href="?cat=entertainment">Entertainment</a></li>
							<li><a href="?cat=events">Events</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- end #sidebar -->	

			<div class="paginator">
				<?php
					if(isset($_GET['cat']))	
						$cat = "&amp;cat=".$_GET['cat'];
					else
						$cat = "";

					if($num_rows > 0)
						echo "<div class=\"prev_pag\"><a href=\"?page=".($page+1).$cat."\">Previous</a></div>";
					else
						echo "<div class=\"prev_pag disabled\">Previous</div>";
					if($page > 1)
						echo "<div class=\"next_pag\"><a href=\"?page=".($page-1).$cat."\">Next</a></div>";
					else
						echo "<div class=\"next_pag disabled\">Next</div>";
				?>
			</div>
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
