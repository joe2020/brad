<?php

require_once 'db.php';

function display_comments($comments) {
	echo '<div class="comments">' . "\n";
	
	if (is_array($comments)) {
		foreach ($comments as $comment) {
			echo '	<div class="comment">' . "\n";
			echo '		<span class="published_at">' . $comment['created_at'] . '</span>' . "\n";
			echo '		<span class="comment">' . $comment['message'] . '</span>' . "\n";
			echo '	</div>' . "\n";
		}
	}
	
	echo '</div>';
}

function retrieve_comments($video_id) {
	$comments = array();

	$link = db_connect(null);
	
	if ($link !== false) {
		$sql = "select `message`, `created_at` from `comment` where `video_id` = $video_id";
		$results = mysqli_query($link, $sql);

		if (mysqli_errno($link) === 0) {
			$row = mysqli_fetch_assoc($results);

			while ($row !== null) {
				$comments[] = $row;
				$row = mysqli_fetch_assoc($results);
			}
			
			mysqli_free_result($results);
		}
		else {
			echo mysqli_error($link);
		}
		mysqli_close($link);
	}

	return $comments;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="css/site.css" />
	<!--<script src="https://apis.google.com/js/plusone.js"></script>-->
</head>
<body>

<iframe width="560" height="315" src="" frameborder="1" allowfullscreen></iframe>
<div class="g-ytsubscribe" data-channel="" data-layout="default"></div>

<form action="publish-comment.php" method="POST">
<fieldset>
	<legend>Add a Comment</legend>
	<label for="handle">Handle</label>
	<input type="text" name="handle" id="handle" value="" maxlength="64" />
	<br /><br />
	<label for="comment">Comment</label>
	<textarea rows="6" cols="50" name="comment" id="comment"></textarea>
	<br /><br />
	<input type="submit" value="Publish" />
</fieldset>
</form>
<?php display_comments(retrieve_comments(20)); ?>

</body>
</html>
