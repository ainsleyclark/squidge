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

use Squidge\Log\Logger;
use Squidge\Package\Convertor;
use Squidge\Package\Service;
use Squidge\Types\Mimes;

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
		if ($mime != Mimes::PNG && $mime != Mimes::JPG) {
			return;
		}
		exec(sprintf('%s -q %d %s -o %s 2> /dev/null', self::cmd_name(), 80, $filepath, $filepath . self::extension()));
		Logger::info("Successfully converted to WebP file: " . $filepath . self::extension());
	}

	/**
	 * Returns the command name of the service.
	 *
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function cmd_name()
	{
		return "cwebp";
	}

	/**
	 * Returns the extension to convert too.
	 *
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function extension()
	{
		return ".webp";
	}
}
