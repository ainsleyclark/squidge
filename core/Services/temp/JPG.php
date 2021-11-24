<?php

/**
 * JPG
 *
 * JPG is responsible for compressing JPG images
 * with the JPG mime type using the jpegoptim
 * library.
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

class JPG extends Service implements Convertor
{
	/**
	 * The quality of the JPG convert.
	 *
	 * @var int
	 */
	public static $Quality = 80;

	/**
	 * Sets up the service.
	 *
	 * @since 0.1.0
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
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function convert($filepath, $mime)
	{
		if ($mime != JPEG_MIME) {
			return;
		}
		exec(sprintf('%s --strip-all --overwrite --max=%d %s', self::$cmd_name, self::$Quality, $filepath));
		Logger::info("Successfully compressed image JPG file: " . $filepath);
	}
}
