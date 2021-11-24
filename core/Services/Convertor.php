<?php

namespace Squidge\Services;

/**
 *
 */
interface Convertor {
	/**
	 *
	 *
	 * @param $filepath
	 * @param $mime
	 * @return mixed
	 */
	static function convert($filepath, $mime, $args);

	/**
	 * @return mixed
	 */
	static function cmd_name();

	/**
	 * @return mixed
	 */
	static function extension();
}
