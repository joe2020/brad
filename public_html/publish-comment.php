<?php

ob_start();
session_start();

require_once 'db.php';
require_once 'comments.php';

$_SESSION['add_comment']['form_data'] = $_POST;

$comment = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (!empty($comment['comment'])) {
	$last_insert_id = add_comment(20, '', $comment['comment']);

	if (last_insert_id !== false) {
		$_SESSION['add_comment']['message'] = 'Thanks for the comment';
		$_SESSION['add_comment']['last_insert_id'] = $last_insert_id;
	}
	else {
		$_SESSION['add_comment']['errors'][] = 'Whoops. There was a problem.  Please try again later.';
	}
}
else {
	$_SESSION['add_comment']['errors'][] = 'Did you mean to leave a comment?';
}

header('Location: /video.php');

ob_end_clean();