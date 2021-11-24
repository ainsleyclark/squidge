<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/*
 * acf_include
 *
 * Includes a file within the ACF plugin.
 *
 * @date    10/3/14
 * @since   5.0.0
 *
 * @param   string $filename The specified file.
 * @return  void
 */
function wp_squidge_include($filename = '')
{
    $file_path = wp_squidge_get_path($filename);
    if (file_exists($file_path)) {
        include_once $file_path;
    }
}

/**
 * acf_get_path
 *
 * Returns the plugin path to a specified file.
 *
 * @date    28/9/13
 * @param string $filename The specified file.
 * @return  string
 * @since   5.0.0
 *
 */
function wp_squidge_get_path($filename = '')
{
    return WP_SQUIDGE_PATH . ltrim($filename, '/');
}