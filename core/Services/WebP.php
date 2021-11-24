<?php

/**
 * WebP
 *
 * WebP is responsible for converting JPG and PNG
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

use Mimes;
use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class WebP extends Service implements Convertor
{

	/**
	 * Compress all image sizes if they are jpg or png
	 * to webp with the given file path.
	 *
	 * @param $filepath
	 * @param $mime
	 * @param $args
	 * @return void
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function convert($filepath, $mime, $args)
	{
		if ($mime != Mimes::PNG() && $mime != Mimes::JPEG()) {
			return;
		}
		exec(sprintf('%s -q %d %s -o %s', self::cmd_name(), 80, $filepath, $filepath . self::extension()));
		Logger::info("Successfully converted to WebP file: " . $filepath . self::extension());
	}

	/**
	 * @return string
	 */
	public static function cmd_name()
	{
		return "cwebp";
	}

	/**
	 * @return string
	 */
	public static function extension()
	{
		return ".webp";
	}
}
