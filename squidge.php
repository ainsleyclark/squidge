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

namespace WPSquidge;

use WPSquidge\Includes\WP_Squidge_WebP;

DEFINE('WP_SQUIDGE_URL', plugin_dir_url(__FILE__));
DEFINE('WP_SQUIDGE_PATH', plugin_dir_path(__FILE__));
DEFINE('WP_SQUIDGE_BASENAME', plugin_basename(__FILE__));

// Include utility functions.
include_once WP_SQUIDGE_PATH . 'inc/util.php';

wp_squidge_include("vendor/autoload.php");
wp_squidge_include("inc/admin/fields.php");
wp_squidge_include("inc/service.php");
wp_squidge_include("inc/webp.php");


add_action('carbon_fields_fields_registered', function () {
    $webp = new WP_Squidge_WebP();

    if (!$webp->installed()) {
        carbon_set_theme_option('wp_squidge_webp_status', 'Enabled');
    }
});


//https://stackoverflow.com/questions/45821726/use-carbon-fields-in-custom-plugin-class


//use Carbon_Fields\Container;
//use Carbon_Fields\Field;
//
//add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
//function crb_attach_theme_options() {
//    Container::make( 'theme_options', 'Theme Options' ) -> add_fields( array(
//        Field::make( 'text', 'crb_text')
//    ) );
//}
//
//add_action( 'after_setup_theme', 'crb_load' );
//function crb_load() {
//    require_once( ABSPATH . 'wp-content/plugins/carbon-fields/vendor/autoload.php' );
//    \Carbon_Fields\Carbon_Fields::boot();
//}
//
//add_action( 'carbon_fields_fields_registered', 'crb_values_are_avail' );
//function crb_values_are_avail() {
//    var_dump( carbon_get_theme_option( 'crb_text' ) ); // -> string(0) "test"
//}