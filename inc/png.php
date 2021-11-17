<?php

/**
 * PNG
 *
 * Service for converting imagery to compressed
 * files using optipng.
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace WPSquidge\Includes;

class WP_Squidge_PNG extends WP_Squidge_Service {

    /**
     * The command name to run.
     */
    const CMD_NAME = "optipng";

    /**
     * Sets up actions.
     */
    public function __construct()
    {
        $this->quality = carbon_get_theme_option('wp_squidge_png_quality');
        parent::__construct(self::CMD_NAME);
        add_action('delete_attachment', [$this, 'delete']);
    }

    public function convert(array $images)
    {
        if (!$this->installed()) {
            error_log("WP Squidge - cwebp is not installed");
            return;
        }
    }

    protected function installed(): bool
    {
        // TODO: Implement installed() method.
    }
}