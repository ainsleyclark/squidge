<?php

/**
 * PNG
 *
 * PNG is responsible for compressing PNG images
 * with the PNG mime type using the optipng
 * library.
 *
 * @package     Squidge
 * @version     0.1.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Services;

use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class PNG extends Service
{
	/**
	 * The quality of the JPG convert.
	 *
	 * @var int
	 */
	public $Quality = 80;

	/**
	 * Sets up the service.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		parent::__construct('optipng', '.png');
	}

	/**
	 * Compresses all image sizes have a jpg mime type
	 * with the given file path.
	 *
	 * @param $filepath
	 * @param $mime
	 * @return void
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function convert($filepath, $mime)
	{
		if ($mime != PNG_MIME) {
			return;
		}
		exec(sprintf('%s -clobber -strip all -o %d %s', $this->cmd_name, $this->Quality, $filepath));
		Logger::info("Successfully compressed image PNG file: " . $filepath);
	}
}
