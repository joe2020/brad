<?php

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

function add_comment($video_id, $handle, $comment_text) {
	$added_comment = false;

	$settings = parse_ini_file('../app.ini');
	$link = mysqli_connect($settings['db_servername'],
						   $settings['db_username'],
						   $settings['db_password'],
						   $settings['db_database']);

	if (mysqli_connect_errno($link) === 0) {
		if (mysqli_set_charset($link, 'utf8') === true) {
			$comment_text = mysqli_real_escape_string($link, $comment_text);

			$sql = "insert into comment (`video_id`, `message`) values ($video_id, '$comment_text')";
			mysqli_query($link, $sql);

			if (mysqli_errno($link) === 0) {
				$added_comment = true;
			}
		}
		mysqli_close($link);
	}

	return $added_comment;
}