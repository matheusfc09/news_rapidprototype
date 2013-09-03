<?php

	session_start();
	require '../system/database.php';
	require '../system/config.php';
	require "../system/authentication.php";
	
	$stmt_post = $mysqli->prepare("SELECT posts.id, posts.title, posts.entry, posts.category, posts.creation, users.id, users.full_name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
	$stmt_comments = $mysqli->prepare("SELECT comments.id, comments.comment, comments.creation, users.id, users.full_name FROM (posts JOIN comments ON comments.post_id = posts.id) JOIN users ON comments.user_id = users.id WHERE posts.id = ?");

	if(!$stmt_post or !$stmt_comments){
		$_SESSION['error'] = "Query Failed!";
		header("Location: ".ROOT_PATH."error.php");
		exit;
	}

	if(isset($_GET['id'])) {
		$stmt_post->bind_param('i', $_GET['id']);
		$stmt_comments->bind_param('i', $_GET['id']);
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

	<title><?php echo SITE_TITLE." - View Post"; ?></title>

	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	<link href="<?php echo ROOT_PATH."css/style.css"; ?>" rel="stylesheet" type="text/css" media="screen" />

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

					$stmt_post->execute();
					$stmt_post->bind_result($post_id, $title, $entry, $category, $creation, $user_id, $user_name);
					if(!$stmt_post->fetch()) {
						$_SESSION['error'] = "The requested post is not available or does not exist!";
						header("Location: ".ROOT_PATH."index.php");
						exit;
					}

				?>
				<div id="post_<?php echo $post_id; ?>" class="post">
					<h2 class="title"><?php echo htmlspecialchars($title); ?></h2>
					<p class="meta">
						<span class="date"><?php echo date("F d, Y", strtotime($creation)); ?></span>
						<span class="posted">
							<span>In <?php echo "<a href=\"".ROOT_PATH."?cat=".$category."\">".$category."</a>"; ?>,</span>
							<span>Posted by <?php echo $user_name; ?></span>
						</span>
					</p>
					<div style="clear: both;"></div>
					<div class="entry">
						<?php echo html_entity_decode($entry); ?>
					</div>
				</div>
				<?php

					$stmt_post->close();

				?>

				<div id="comments">
					<h3>Comments</h3>
					<ul>
						<?php
						
							$stmt_comments->execute();
							$stmt_comments->bind_result($comment_id, $comment_comment, $comment_creation, $comment_user_id, $comment_user_name);
							
							$stmt_comments->store_result();
							$num_comments = $stmt_comments->num_rows;

							if($num_comments < 1)
								echo "<li class=\"no_comments\">There are no comments yet. Be the first one!</li>";
		
							while($stmt_comments->fetch()) {
						?>
						<li id="<?php echo $comment_id; ?>" class="comment">
							<div class="meta">
								<span class="date"><?php echo date("F d, Y \a\\t h:ia", strtotime($comment_creation)); ?></span>
								<span class="posted">
									<span>Posted by <?php echo $comment_user_name; ?></span>
									<?php if(owner($comment_user_id) or admin()) { ?>
										<span> - </span>
										<span class="link_bt">
											<form action="delete_comment.php" method="POST" onsubmit="return confirm('Are you sure you want to delete?')";>
												<input type="hidden" name="id" value="<?php echo $comment_id; ?>">
												<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
												<input type="submit" value="Remove Comment">
											</form>
										</span>
									<?php } ?>
								</span>
							</div>
							<div class="text"><?php echo strip_tags($comment_comment); ?></div>
						</li>
						<?php
							}

							$stmt_comments->close();
						?>
					</ul>
					<?php if(logged_in()) { ?>
						<form id="new_comment" action="create_comment.php" method="POST">
							<input type="hidden" name="comment[post_id]" value="<?php echo $post_id; ?>">
							<textarea name="comment[comment]" rows="5" placeholder="Enter a new comment"></textarea>
							<div class="submit">
								<input type="submit" value="Create comment">
							</div>
						</form>
					<?php } else { ?>
						<div id="new_comment" class="login_links">You need to be logged in to comment. Log in <a href="<?php echo ROOT_PATH.'login.php'; ?>">here</a></div>
					<?php } ?>
				</div>
			</div>
			<!-- end #content -->
			<div id="sidebar">
				<ul>
					<li>
						<h2>Options</h2>
						<ul>
							<li><a href="#new_comment">New Comment</a></li>
							<?php

								if(owner($user_id))
									echo "<li><a href=\"edit.php?id=$post_id\">Edit</a></li>";

								if(owner($user_id) or admin()) {
									echo "<li class=\"link_bt\">";
										echo "<form action=\"delete.php\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete?')\";>";
											echo "<input type=\"hidden\" name=\"id\" value=\"$post_id\">";
											echo "<input type=\"submit\" value=\"Remove\">";
										echo "</form>";
									echo "</li>";
								}
							?>
						</ul>
					</li>
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
