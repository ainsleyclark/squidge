<?php

/**
 * Squidge
 *
 * Main squidge class.
 *
 * @package     Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge;

use Squidge\Admin;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

final class Squidge
{
	/**
	 * The plugin version number.
	 *
	 * @var string
	 */
	var $version = '1.0.0';

	/**
	 * The instance of Squidge.
	 *
	 * @var null
	 */
	private static $instance = NULL;

	/**
	 * Boots Squidge and initialises the
	 * static instance, once.
	 *
	 * @return Squidge|null
	 */
	public static function boot()
	{
		if (self::$instance == null) {
			$squidge = new Squidge();
			$squidge->initialize();
			self::$instance = $squidge;
		}
		return self::$instance;
	}

	/**
	 * Sets up the Squidge plugin.
	 *
	 * @date    24/11/2021
	 * @param void
	 * @return    void
	 * @since    1.0.0
	 *
	 */
	private function initialize()
	{
		$this->define('WP_SQUIDGE_URL', plugin_dir_url(__FILE__));
		$this->define('WP_SQUIDGE_PATH', plugin_dir_path(__FILE__));
		$this->define('WP_SQUIDGE_BASENAME', plugin_basename(__FILE__));
		$this->define('WP_SQUIDGE_VERSION', $this->version);
		new Admin\Fields();
		new Admin\Upload();
	}

	/**
	 * Defines a constant if doesnt already exist.
	 *
	 * @date    24/11/2021
	 * @param string $name The constant name.
	 * @param mixed $value The constant value.
	 * @return    void
	 * @since    1.0.0
	 *
	 */
	function define($name, $value = true)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}
}
