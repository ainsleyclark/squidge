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
        add_action('delete_attachment', [$this, 'delete']);
    }

    /**
     * Check's if the webp library is installed.
     *
     * @return bool
     */
    public function installed(): bool
    {
        return $this->command_exist(self::CMD_NAME);
    }

    /**
     * @param array $images
     * @return mixed|void
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