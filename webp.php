<?php

class WP_Squidge_WebP extends WP_Squidge_Service {
    const CMD_NAME = "cwebp";
    const EXTENSION = ".webp";

    public function __construct()
    {
        add_action( 'delete_attachment', [ $this, 'delete' ] );
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
            exec("cwebp -q 80 ".$image['path']." -o ".$image['path'].".webp");
        }

        // TODO: Implement convert() method.
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $attachment = get_attached_file($id); // Gets path to attachment

        foreach ($images as $image) {
            unlink($image['path']);
        }
    }
}