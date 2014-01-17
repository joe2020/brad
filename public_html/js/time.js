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