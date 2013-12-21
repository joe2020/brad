<?php

function db_connect($link, $identifier = 'MYSQL') {
	$settings = parse_ini_file('../app.ini');
	$link = mysqli_connect($settings['db_servername'],
						   $settings['db_username'],
						   $settings['db_password'],
						   $settings['db_database']);

	if ((mysqli_connect_errno($link) !== 0) || (mysqli_set_charset($link, 'utf8') !== true)) {
		$link = false;	
	}
	
	return $link;
}

function db_query($link, $query) {
	$results = false;
	
	if ($link === null) {
		$link = db_connect($link);
	}

	$query_results = mysqli_query($link, $query);

	if ((mysqli_errno($link) === 0) && ($query_results !== true)) {
		$row = mysqli_fetch_assoc($query_results);

		while ($row !== null) {
			$results[] = $row;
			$row = mysqli_fetch_assoc($query_results);
		}
		
		mysqli_free_result($query_results);
	}

	return $results;
}