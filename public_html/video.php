<?php

session_start();

require_once 'db.php';
require_once 'comments.php';

$form_data = array();
if (isset($_SESSION['add_comment']['form_data'])) {
	$form_data = $_SESSION['add_comment']['form_data'];
}

$message = '';
if (isset($_SESSION['add_comment']['message'])) {
	$message = $_SESSION['add_comment']['message'];
}

$errors = array();
if (isset($_SESSION['add_comment']['errors'])) {
	$errors = $_SESSION['add_comment']['errors'];
}

$last_insert_id = false;
if (isset($_SESSION['add_comment']['last_insert_id'])) {
	$last_insert_id = $_SESSION['add_comment']['last_insert_id'];
}



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

<?php 
	if (!empty($message)) {
		echo '<div class="message">' . $message . '</div>';
	}
	
	if ((!empty($errors)) && (is_array($errors))) {
		echo '<div class="errors">Errors:';
		echo '<ul>';
			foreach ($errors as $error) {
				echo '<li>' . $error . '</li>';
			}
		echo '</ul>';
	}
?>

<?php if (empty($message)) { ?>
<form name="add_comment" action="publish-comment.php" method="POST">
<fieldset>
	<legend>Add a Comment</legend>
	<label for="handle">Handle</label>
	<input type="text" name="handle" id="handle" value="<?php echo (isset($form_data['handle'])) ? $form_data['handle'] : ''; ?>" maxlength="64" />
	<br /><br />
	<label for="comment">Comment</label>
	<textarea rows="6" cols="50" name="comment" id="comment"><?php echo (isset($form_data['comment'])) ? $form_data['comment'] : ''; ?></textarea>
	<br /><br />
	<input type="submit" value="Publish" />
</fieldset>
</form>
<?php } ?>
<?php display_comments(retrieve_comments(20, $last_insert_id)); ?>

<?php unset($_SESSION['add_comment']); ?>

</body>
</html>
