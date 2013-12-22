<?php

require_once 'db.php';
require_once 'comments.php';

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="css/site.css" />
	<!--<script src="https://apis.google.com/js/plusone.js"></script>-->
	<script type="text/javascript">
		function on_load_handler() {
			show_all_time_difference_descriptions("published_at");
		}

		function show_all_time_difference_descriptions(class_name) {
			var elements = document.getElementsByClassName(class_name);
			var current_time = Math.floor(new Date().getTime() / 1000);
			var tz_offset = new Date().getTimezoneOffset() * 60;

			for (var index = 0; index < elements.length; index++) {
				elements[index].innerHTML = time_difference_description(elements[index].innerHTML, current_time + tz_offset);
			}
		}

		function time_difference_description(event_time, current_time) {
			var seconds_ago = current_time - event_time;
			var SECONDS_IN_MINUTE = 60;
			var SECONDS_IN_HOUR = 3600;
			var SECONDS_IN_DAY = 86400;
			var metric = '';
			var result = '';

			if (seconds_ago < SECONDS_IN_MINUTE) {
				result = seconds_ago;
				metric = 'second';
			}
			else if (seconds_ago < SECONDS_IN_HOUR) {
				result = Math.floor(seconds_ago / SECONDS_IN_MINUTE);
				metric = 'minute';
			}
			else if (seconds_ago < SECONDS_IN_DAY) {
				result = Math.floor(seconds_ago / SECONDS_IN_HOUR);
				metric = 'hour';
			}
			else {
				result = Math.floor(seconds_ago / SECONDS_IN_DAY);
				metric = 'day';
			}

			if (result > 1) {
				result = result + ' ' + metric + 's';
			}
			else {
				result = result + ' ' + metric;
			}

			return result;
		}
	</script>
</head>
<body onLoad="on_load_handler();">

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
