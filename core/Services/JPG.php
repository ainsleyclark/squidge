<?php

/**
 * JPG
 *
 * JPG is responsible for compressing JPG images
 * with the JPG mime type using the jpegoptim
 * library.
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Services;

use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class JPG extends Service
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
	 * @since    1.0.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		parent::__construct('jpegoptim');
	}

	/**
	 * Compresses all image sizes have a png mime type
	 * with the given file path.
	 *
	 * @param $filepath
	 * @param $mime
	 * @return void
	 * @since    1.0.0
	 * @date 24/11/2021
	 */
	public function convert($filepath, $mime)
	{
		if ($mime != JPEG_MIME) {
			return;
		}
		exec(sprintf('%s --strip-all --overwrite --max=%d %s', $this->cmd_name, $this->Quality, $filepath));
		Logger::info("Successfully compressed image JPG file: " . $filepath);
	}
}
