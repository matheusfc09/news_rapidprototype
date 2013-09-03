<?php
	
	if(!function_exists("admin")) {	
		function admin() {
			return (isset($_SESSION['user']) and $_SESSION['user']['role'] == "admin");
		}
	}

	if(!function_exists("registered")) {	
		function registered() {
			return (isset($_SESSION['user']) and $_SESSION['user']['role'] == "registered");
		}
	}

	if(!function_exists("owner")) {	
		function owner($user_id) {
			return (isset($_SESSION['user']) and !empty($user_id) and $_SESSION['user']['id'] == $user_id);
		}
	}

	if(!function_exists("logged_in")) {	
		function logged_in() {
			return (isset($_SESSION['user']) and !empty($_SESSION['user']['role']));
		}
	}

	if(!function_exists("logout")) {
		function logout() {
			if(isset($_SESSION['user']))
				unset($_SESSION['user']);
		}
	}

	if(!function_exists("current_user_id")) {
		function current_user_id() {
			if(isset($_SESSION['user']) and !empty($_SESSION['user']['id']))
				return $_SESSION['user']['id'];
		}
	}

?>
