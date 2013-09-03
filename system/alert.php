<?php

	if(isset($_SESSION['error'])) {
		echo "<div id=\"alert\" class=\"error\">".$_SESSION['error']."</div>";
		unset($_SESSION['error']);
	}

	if(isset($_SESSION['success'])) {
		echo "<div id=\"alert\" class=\"success\">".$_SESSION['success']."</div>";
		unset($_SESSION['success']);
	}

	if(isset($_SESSION['normal'])) {
		echo "<div id=\"alert\" class=\"normal\">".$_SESSION['normal']."</div>";
		unset($_SESSION['normal']);
	}

?>
