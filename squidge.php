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

DEFINE('WP_SQUIDGE_PATH', plugin_dir_path(__FILE__));
DEFINE('WP_SQUIDGE_BASENAME', plugin_basename(__FILE__));

// Include utility functions.
include_once WP_SQUIDGE_PATH . 'inc/util.php';

wp_squidge_include("vendor/autoload.php");
wp_squidge_include("inc/admin/fields.php");
//wp_squidge_include("/inc/service.php");
//wp_squidge_include("/inc/webp.php");

//new WP_Squidge_WebP();