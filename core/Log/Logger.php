<?php

/**
 * Logger
 *
 * Responsible for logging out informational and
 * error messages for the plugin.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge\Log;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Logger
{

	/**
	 * Info logs an information message.
	 *
	 * @param $message
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	static function info($message)
	{
		self::log($message, false);
	}

	/**
	 * Error logs an error message.
	 *
	 * @param $message
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	static function error($message)
	{
		self::log($message, true);
	}

	/**
	 * Log uses the error_log function to log
	 * out a Squidge message.
	 *
	 * @param $message
	 * @param $error
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	static function log($message, $error)
	{
		$type = '[INFO] ';
		if ($error) {
			$type = '[ERROR]';
		}
		error_log(sprintf('Squidge: %s - %s', $type, $message));
	}
}
