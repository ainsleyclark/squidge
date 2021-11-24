<?php

/**
 * AVIF
 *
 * Avif is responsible for converting JPG and PNG
 * images to webp with the .webp extension using
 * the cwebp library.
 *
 * @package     Squidge
 * @version     0.1.0
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Services;

use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AVIF extends Service implements Convertor
{
	/**
	 * Sets up the service.
	 *
	 * @since 0.1.0
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
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function convert($filepath, $mime)
	{
		if ($mime != PNG_MIME && $mime != JPEG_MIME) {
			return;
		}
		exec(sprintf('%s --min 0 --max 63 -a end-usage=q -a cq-level=18 -a tune=ssim %s %s', self::$cmd_name, $filepath, $filepath . self::$extension));
		Logger::info("Successfully converted to Avif file: " . $filepath . self::$extension);
	}
}
