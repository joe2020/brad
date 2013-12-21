<?php

require_once 'db.php';
require_once 'comments.php';

$comment = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (!empty($comment['comment'])) {
	if (add_comment(20, '', $comment['comment']) === true) {
		echo 'Thanks for the comment';
	}
	else {
		echo 'Whoops. There was a problem.  Please try again later.';
	}
}
else {
	echo 'Did you mean to level a comment?';
}