<?php

/**
 * SVG
 *
 * TODO
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

class SVG extends Service
{
	/**
	 * Sets up the service.
	 *
	 * @since    1.0.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		parent::__construct('svgo');
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
		if ($mime != SVG_MIME) {
			return;
		}
		exec(sprintf('%s --input=%s', $this->cmd_name, $filepath));
		Logger::info("Successfully compressed SVG file: " . $filepath);
	}
}
