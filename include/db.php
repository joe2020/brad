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