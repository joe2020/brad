<?php

function retrieve_comments($video_id) {
	$comments = array();

	$link = db_connect(null);
	
	if ($link !== false) {
		$sql = "select `message`, `created_at` from `comment` where `video_id` = $video_id";
		$comments = db_query($link, $sql);

		if ($comments === false) {
			echo mysqli_error($link);
		}
		mysqli_close($link);
	}

	return $comments;
}

function add_comment($video_id, $handle, $comment_text) {
        $added_comment = false;

        $link = db_connect(null);
        if ($link !== false) {
                $comment_text = mysqli_real_escape_string($link, $comment_text);

                $sql = "insert into comment (`video_id`, `message`) values ($video_id, '$comment_text')";
                db_query($link, $sql);

                if (mysqli_errno($link) === 0) {
                        $added_comment = true;
                }

                mysqli_close($link);
        }

        return $added_comment;
}