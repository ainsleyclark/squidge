<?php

/**
 * WebP
 *
 * WebP is responsible for converting JPG and PNG
 * images to webp with the .webp extension using
 * the cwebp library.
 *
 * @package     Squidge
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

class WebP extends Service
{
	/**
	 * The quality of the WebP convert.
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
		parent::__construct('cwebp', '.webp');
	}

	/**
	 * Compress all image sizes if they are jpg or png
	 * to webp with the given file path.
	 *
	 * @param $filepath
	 * @param $mime
	 * @return void
	 * @since    1.0.0
	 * @date 24/11/2021
	 */
	public function convert($filepath, $mime)
	{
		if ($mime != PNG_MIME && $mime != JPEG_MIME) {
			return;
		}
		exec(sprintf('%s -q %d %s -o %s', $this->cmd_name, $this->Quality, $filepath, $filepath . $this->extension));
		Logger::info("Successfully converted to WebP file: " . $filepath . $this->extension);
	}
}
