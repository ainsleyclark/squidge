<?php

/*
Plugin Name: WP Squidge
Plugin URI: https://github.com/ainsleyclark/wp-squidge
Description: A Wordpress Plugin to compress and convert images using cwebp, jpegoptim and optipng.
Version: 1
Author: Ainsley Clark
Author URI: https://github.com/ainsleyclark
License: MIT
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

