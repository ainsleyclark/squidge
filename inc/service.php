<?php

/**
 * Service
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

//namespace WPSquidge\Includes;

abstract class WP_Squidge_Service {

    /**
     * The command name to run
     *
     * @var string
     */
    protected $cmd_name = '';

    /**
     * @param string $cmd_name
     */
    public function __construct(string $cmd_name)
    {
        $this->cmd_name = $cmd_name;
    }

    /**
     * Converts or compresses an image.
     *
     * @param array $images
     * @return mixed
     */
    public abstract function convert(array $images);

    /**
     * Checks if a command exists.
     *
     * @return bool
     */
    protected function installed(): bool
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg($this->cmd_name)));
        return !empty($return);
    }
}
