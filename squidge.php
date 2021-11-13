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

public abstract class WP_Squidge_Service {

    /**
     * Converts or compresses an image.
     *
     * @param array $images
     * @return mixed
     */
    public abstract function convert(array $images);

    /**
     * Check's if the CMD is installed.
     *
     * @return bool
     */
    protected abstract function installed(): bool;

    /**
     * Checks if a command exists.
     *
     * @param $cmd
     * @return bool
     */
    protected function command_exist($cmd): bool
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
        return !empty($return);
    }
}
