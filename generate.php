<?php
/**
 * Created by PhpStorm.
 * User: focus
 * Date: 10.06.2018
 * Time: 14:31
 */
//VALIDATE
if (!filter_var($_GET["url"], FILTER_VALIDATE_URL)) {
	exit(json_encode([
		'type' => 'error',
		'text' => 'invalid url'
	]));
}

if ($_GET["setShort"] === 'true' && !preg_match('/^[a-z0-9]{8}$/', $_GET["short"])) {
	exit(json_encode([
		'type' => 'error',
		'text' => 'invalid short code'
	]));
}

require_once 'conf.php';
require_once 'lib.php';

$mysqli = new mysqli(
	$conf['database']['host'],
	$conf['database']['user'],
	$conf['database']['password'],
	$conf['database']['database_name']
);

$exist_shortcodes = $mysqli->query('SELECT `shortcode` FROM `urls`');
$exist_shortcodes = $exist_shortcodes->fetch_all(MYSQLI_NUM);

$url = urlencode($_GET['url']);
$url = $mysqli->real_escape_string($url);

if ($_GET["setShort"] === 'true') {
	foreach ($exist_shortcodes as $code) {
		if (in_array($_GET["short"], $code)) {
			exit(json_encode([
				'type' => 'error',
				'text' => 'short code already exists'
			]));
		}
	}

	$mysqli->query("INSERT INTO `urls` VALUES (NULL , '$url', '{$_GET["short"]}')");

	exit(json_encode([
		'type' => 'success',
		'text' => "http://{$_SERVER["HTTP_HOST"]}/{$_GET["short"]}"
	]));
} else {
	$new_shortcode = getUniqueShortcode($exist_shortcodes);

	$mysqli->query("INSERT INTO `urls` VALUES (NULL , '$url', '$new_shortcode')");

	exit(json_encode([
		'type' => 'success',
		'text' => "http://{$_SERVER["HTTP_HOST"]}/$new_shortcode"
	]));
}

$mysqli->close();
