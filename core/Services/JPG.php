<?php

/**
 * JPG
 *
 * JPG is responsible for compressing JPG images
 * with the JPG mime type using the jpegoptim
 * library.
 *
 * @package     Squidge
 * @version     0.1.4
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

class JPG extends Service implements Convertor
{

	/**
	 * DEFAULT_QUALITY is the default image quality
	 * when processing a PNG image.
	 */
	const DEFAULT_QUALITY = 80;

	/**
	 * Compresses all image sizes have a png mime type
	 * with the given file path.
	 *
	 * exec is required to compress the WP JPG image.
	 *
	 * @param $filepath
	 * @param $mime
	 * @param $args
	 * @return void
	 * @since 0.1.2
	 * @date 05/12/2021
	 */
	public static function convert($filepath, $mime, $args)
	{
		if ($mime != Mimes::JPG) {
			return;
		}
		if (!isset($args['quality'])) {
			$args['quality'] = self::DEFAULT_QUALITY;
		}
		exec(sprintf('%s --strip-all --overwrite --max=%d %s 2> /dev/null', escapeshellarg(self::cmd_name()), $args['quality'], escapeshellarg($filepath)));
		Logger::info("Successfully compressed image JPG file: " . $filepath);
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
		return "jpegoptim";
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
		return "";
	}
}
