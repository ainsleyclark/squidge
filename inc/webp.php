<?php

/**
 * WebP
 *
 * Service for converting and deleting webp files using
 * the cwebp library. This service extends WP_Squidge
 * to implement the installed and convert methods.
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace WPSquidge\Includes;

/**
 *
 */
class WP_Squidge_WebP extends WP_Squidge_Service
{
    /**
     * The command name to run.
     */
    const CMD_NAME = "cwebp";

    /**
     * The extension to save.
     */
    const EXTENSION = ".webp";

    /**
     * Sets up actions.
     */
    public function __construct()
    {
        parent::__construct(self::CMD_NAME, self::EXTENSION, true);
    }

    /**
     * Converts all image sizes if they are jpg or png
     * to webp with the given file extension.
     *
     * @param $path
     * @return void
     */
    public function convert($path)
    {
        $quality = carbon_get_theme_option('wp_squidge_webp_quality');
        exec("cwebp -q " . $quality . " " . $path . " -o " . $path . self::EXTENSION);
    }
}