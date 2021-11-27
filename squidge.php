<?php

/**
 * Plugin Name:     Squidge
 * Plugin URI:      https://github.com/ainsleyclark/wp-squidge
 * Description:     A WordPress Plugin to compress and convert images using cwebp, jpegoptim and optipng.
 * Author:          Ainsley Clark
 * Author URI:      https://github.com/ainsleyclark
 * Text Domain:     wp-squidge
 * Version:         0.1.0
 * License:         GNU
 *
 * @package         Squidge
 * @repo            https://github.com/ainsleyclark/wp-squidge
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
if (file_exists(__DIR__ . '/cli/commands.php')) {
	require(__DIR__ . '/cli/commands.php');
}

// Require Functions.
if (file_exists(__DIR__ . '/functions/functions.php')) {
	require(__DIR__ . '/functions/functions.php');
}

// Add Settings Link.
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_settings_link');
function add_settings_link($links)
{
	$links[] = '<a href="' .
		admin_url('options-general.php?page=crb_carbon_fields_container_squidge.php') .
		'">' . __('Settings') . '</a>';
	return $links;
}
