<?php
/**
 * Created by PhpStorm.
 * User: focus
 * Date: 10.06.2018
 * Time: 15:22
 */

/**
 * @param $exist_shortcodes
 * @return string
 */
function getUniqueShortcode($exist_shortcodes)
{
	$new_shortcode = `/home/f/ford315/.local/bin/pwgen -1 --no-capitalize --numerals`;
	$new_shortcode = trim($new_shortcode);
	$indicator = false;

	foreach ($exist_shortcodes as $code) {
		if (in_array($new_shortcode, $code)) {
			$indicator = true;
		}
	}

	if ($indicator) {
		getUniqueShortcode($exist_shortcodes);
	}

	return $new_shortcode;
}
