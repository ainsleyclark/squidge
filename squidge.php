<?php

/**
 * Plugin Name:     Wp Squidge
 * Plugin URI:      https://github.com/ainsleyclark/wp-squidge
 * Description:     A WordPress Plugin to compress and convert images using cwebp, jpegoptim and optipng.
 * Author:          Ainsley Clark
 * Author URI:      https://github.com/ainsleyclark
 * Text Domain:     wp-squidge
 * Domain Path:     /languages
 * Version:         0.0.1
 * License: MIT
 *
 * @package         Squidge
 * @repo			https://github.com/ainsleyclark/wp-squidge
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



