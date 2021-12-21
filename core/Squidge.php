<?php

/**
 * Squidge
 *
 * Main squidge class.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge;

use Squidge\Admin;
use function Clue\StreamFilter\fun;

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
	var $version = '0.1.1';

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
	 * @date 24/11/2021
	 * @since 0.1.0
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
	 * @param void
	 * @return void
	 * @since 0.1.2
	 * @date 05/12/2021
	 */
	private function initialize()
	{
		$base = dirname(__FILE__);
		$this->define('SQUIDGE_URL', plugin_dir_url($base));
		$this->define('SQUIDGE_PATH', plugin_dir_path($base));
		$this->define('SQUIDGE_BASENAME', plugin_basename(dirname($base)));
		$this->define('SQUIDGE_TEMPLATE_PATH', dirname($base) . DIRECTORY_SEPARATOR . 'templates');
		$this->define('SQUIDGE_VERSION', $this->version);
		$uploadData = wp_upload_dir();
		$this->define('SQUIDGE_UPLOAD_DIR', $uploadData['basedir']);
		$this->define('SQUIDGE_UPLOAD_URL', $uploadData['baseurl']);
		new Admin\Fields();
		add_action('carbon_fields_fields_registered', function () {
			new Admin\Upload();
		});
	}

	/**
	 * Defines a constant if doesnt already exist.
	 *
	 * @param string $name The constant name.
	 * @param mixed $value The constant value.
	 * @return void
	 * @since 0.1.0
	 * @date    24/11/2021
	 *
	 */
	function define($name, $value = true)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}
}
