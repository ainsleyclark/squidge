<?php

/**
 * AVIF
 *
 * Avif is responsible for converting JPG and PNG
 * images to webp with the .webp extension using
 * the cwebp library.
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

class AVIF extends Service
{
	/**
	 * Sets up the service.
	 *
	 * @since    1.0.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		parent::__construct('avifenc', '.avif');
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
		if ($mime != PNG_MIME && $mime != JPEG_MIME) {
			return;
		}
		exec(sprintf('%s --min 0 --max 63 -a end-usage=q -a cq-level=18 -a tune=ssim %s %s', $this->cmd_name, $filepath, $filepath . $this->extension));
		Logger::info("Successfully converted to Avif file: " . $filepath . $this->extension);
	}
}
