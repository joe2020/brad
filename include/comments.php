<?php

function retrieve_comments($video_id, $last_insert_id) {
	$comments = array();

	$link = db_connect(null);
	
	if ($link !== false) {
		if ($last_insert_id === false) {
			$sql = "select `message`, unix_timestamp(convert_tz(`created_at`, @@global.time_zone, '+00:00')) as `created_at` from `comment` where `video_id` = $video_id";
		}
		else {
			$sql = "select `message`, unix_timestamp(convert_tz(`created_at`, @@global.time_zone, '+00:00')) as `created_at` from `comment` where `video_id` = $video_id and `id` = $last_insert_id
					union
					select `message`, unix_timestamp(convert_tz(`created_at`, @@global.time_zone, '+00:00')) as `created_at` from `comment` where `video_id` = $video_id and `id` != $last_insert_id					
			";
		}
		$comments = db_query($link, $sql);

		if ($comments === false) {
			echo mysqli_error($link);
		}
		mysqli_close($link);
	}

	return $comments;
}

function add_comment($video_id, $handle, $comment_text) {
	$last_insert_id = false;

	$link = db_connect(null);
	if ($link !== false) {
		$comment_text = mysqli_real_escape_string($link, $comment_text);

		$sql = "insert into comment (`video_id`, `message`) values ($video_id, '$comment_text')";
		db_query($link, $sql);

		if (mysqli_errno($link) === 0) {
			$last_insert_id = mysqli_insert_id($link);
			$added_comment = true;
		}

		mysqli_close($link);
	}

	return $last_insert_id;
}