<?php

/**
 * Convertor
 *
 * Should be implemented by any service that
 * coverts or compresses an image.
 *
 * @package     Squidge
 * @version     0.1.0
 * @category    Package
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Package;

interface Convertor {

	/**
	 * Converts or compresses a file taking in a filepath
	 * mime type and any arguments associated with
	 * the CLI such as quality.
	 *
	 * @date 24/11/2021
	 * @since 0.1.0
	 *
	 * @param $filepath
	 * @param $mime
	 * @param $args
	 * @return mixed
	 */
	static function convert($filepath, $mime, $args);

	/**
	 * Returns the command line name of the service.
	 *
	 * @return mixed
	 * @date 24/11/2021
	 * @since 0.1.0
	 */
	static function cmd_name();

	/**
	 * Returns the extension used for converting (not
	 * for compressing).
	 *
	 * @return mixed
	 * @date 24/11/2021
	 * @since 0.1.0
	 */
	static function extension();
}
