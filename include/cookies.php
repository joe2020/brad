<?php

function does_client_accept_cookies() {
	$session_name = session_name();
	$accepts_cookies = true;

	if ((!isset($_COOKIE[$session_name])) && (!isset($_GET['c']))) {
		header('Location: ' . $_SERVER['PHP_SELF'] . '?c=1');
		exit;
	}
	else if (!isset($_COOKIE[$session_name])) {
		$accepts_cookies = false;
	}
	
	return $accepts_cookies;
}