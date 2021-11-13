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
        parent::__construct(self::CMD_NAME);
        add_action('delete_attachment', [$this, 'delete']);
    }

    /**
     * Converts all image sizes if they are jpg or png
     * to webp with the given file extension.
     *
     * @param array $images
     * @return void
     */
    public function convert(array $images)
    {
        if (!$this->installed()) {
            error_log("WP Squidge - cwebp is not installed");
            return;
        }
        foreach ($images as $image) {
            exec("cwebp -q 80 " . $image['path'] . " -o " . $image['path'] . self::EXTENSION);
        }
    }

    /**
     * Deletes all webp images associated with the
     * image (if the file exists).
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $images = get_attached_file($id); // Gets path to attachment

        foreach ($images as $image) {
            if (file_exists($image['path'] . self::EXTENSION)) {
                unlink($image['path']);
            }
        }
    }
}