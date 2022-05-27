<?php

/**
<<<<<<< HEAD
 * Plugin Name:     Squidge modified
=======
 * Plugin Name:     Squidge
>>>>>>> 7b619e303dee40a5fc93bd2fb1d2e1beb4a3823c
 * Plugin URI:      https://github.com/ainsleyclark/squidge
 * Description:     A image optimisation plugin to compress and convert images using cwebp, jpegoptim, optipng and libavif.
 * Author:          Ainsley Clark
 * Author URI:      https://github.com/ainsleyclark
 * Text Domain:     squidge
 * Version:         0.1.4
 * License:         GNU
 *
 * @package         Squidge
 * @repo            https://github.com/ainsleyclark/squidge
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Require autoload.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require(__DIR__ . '/vendor/autoload.php');
}

// Boot Squidge (Once).
Squidge\Squidge::boot();

// Require CLI.
<<<<<<< HEAD
if (file_exists(__DIR__ . '/cli/Commands.php')) {
	require(__DIR__ . '/cli/Commands.php');
=======
if (file_exists(__DIR__ . '/cli/commands.php')) {
	require(__DIR__ . '/cli/commands.php');
>>>>>>> 7b619e303dee40a5fc93bd2fb1d2e1beb4a3823c
}

// Require Functions.
if (file_exists(__DIR__ . '/functions/functions.php')) {
	require(__DIR__ . '/functions/functions.php');
}

if (!function_exists('squidge_add_settings_link')) {

	/**
	 * Add Settings Link.
	 *
	 * @param $links
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	function squidge_add_settings_link($links)
	{
		$links[] = '<a href="' .
			admin_url('options-general.php?page=crb_carbon_fields_container_squidge.php') .
			'">' . __('Settings') . '</a>';
		return $links;
	}
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'squidge_add_settings_link');
}
