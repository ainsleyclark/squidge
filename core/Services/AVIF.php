<?php

/**
 * AVIF
 *
 * Avif is responsible for converting JPG and PNG
 * images to webp with the .webp extension using
 * the cwebp library.
 *
 * @package     Squidge
 * @version     0.1.1
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
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

class AVIF extends Service implements Convertor
{

	/**
	 * Compresses all image sizes have a png mime type
	 * with the given file path.
	 *
	 * @param $filepath
	 * @param $mime
	 * @param $args
	 * @return voidwp_terms
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function convert($filepath, $mime, $args)
	{
		if ($mime != Mimes::PNG && $mime != Mimes::JPG) {
			return;
		}
		exec(sprintf('%s --min 0 --max 63 --speed 6 -a end-usage=q -a cq-level=18 -a tune=ssim %s %s 2> /dev/null', self::cmd_name(), $filepath, $filepath . self::extension()));
		Logger::info("Successfully converted to Avif file: " . $filepath . self::extension());
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
		return "avifenc";
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
		return ".avif";
	}
}
