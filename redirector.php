<?php
/**
 * Created by PhpStorm.
 * User: focus
 * Date: 10.06.2018
 * Time: 17:06
 */
require_once 'conf.php';

$mysqli = new mysqli(
	$conf['database']['host'],
	$conf['database']['user'],
	$conf['database']['password'],
	$conf['database']['database_name']
);

$shortcode = $_SERVER["REDIRECT_URL"];
$shortcode = $mysqli->real_escape_string($shortcode);
$shortcode = trim($shortcode, "/");

$url = $mysqli->query("SELECT `url` FROM `urls` WHERE `shortcode` = '$shortcode'");
$url = $url->fetch_all(MYSQLI_NUM);

if (count($url) === 0) {
	exit("Unknown shortcode");
} else {
	$url = urldecode($url[0][0]);
	header("Location: $url", true, 301);
}
