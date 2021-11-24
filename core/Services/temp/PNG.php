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

class PNG extends Service implements Convertor
{

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
	 * @param $args
	 * @return void
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function convert($filepath, $mime, $args)
	{
		if (!isset($args['quality'])) {
			// TODO convert to CONST
			$args['quality'] = 80;
		}
		if ($mime != PNG_MIME) {
			return;
		}
		exec(sprintf('%s -clobber -strip all -o %d %s', self::$cmd_name, $args['quality'], $filepath));
		Logger::info("Successfully compressed image PNG file: " . $filepath);
	}
}
