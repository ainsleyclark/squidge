<?php

/**
 * Service
 *
 * Service os responsible for processing file attachments
 * and executing commands.
 *
 * @package     Squidge
 * @version     0.1.0
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Services;

use Exception;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}


class Service
{

	/**
	 * Processes the file attachment.
	 *
	 * @param $attachment
	 * @param $args
	 * @return void
	 * @throws Exception
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function process($attachment, $args)
	{
		// If the attachment is an ID, obtain the metadata.
		if (is_int($attachment)) {
			$attachment = wp_get_attachment_metadata($attachment);
		}

		// Return if the cwebp library is not installed.
		if (!self::installed()) {
			throw new Exception(self::$cmd_name . " is not installed");
		}

		// Check if the file key exists.
		if (!isset($attachment['file'])) {
			throw new Exception("File attachment is not set.");
		}

		// Obtain the file and check if it exists.
		$mainFile = self::get_file_path($attachment['file']);
		if (!$mainFile) {
			throw new Exception("File does not exist");
		}

		// Convert main image.
		static::convert($mainFile, self::get_mime_type($mainFile), $args);

		// Loop over the sizes and convert them.
		foreach ($attachment['sizes'] as $size) {
			if (!isset($size['file'])) {
				continue;
			}
			$path = self::get_file_path($size['file']);
			if (!$path) {
				continue;
			}
			static::convert($path, self::get_mime_type($path), $args);
		}
	}

	/**
	 * Deletes all images  with file extensions associated
	 * with the image (if the file exists).
	 *
	 * @param $id
	 * @return void
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function delete($id)
	{
		// Delete the original file.
		$original = wp_get_original_image_path($id) . static::extension();
		if (file_exists($original)) {
			unlink($original);
		}

		// Delete the image sizes.
		$sizes = get_intermediate_image_sizes();
		foreach ($sizes as $size) {
			$src = wp_get_attachment_image_src($id, $size);
			$path = self::get_file_path($src[0] . static::extension());
			if (!$path) {
				continue;
			}
			unlink($path);
		}
	}

	/**
	 * Checks if a command exists.
	 *
	 * @return bool
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function installed()
	{
		$return = shell_exec(sprintf("which %s", escapeshellarg(static::cmd_name())));
		return !empty($return);
	}

	/**
	 * Obtains the absolute filepath including the
	 * upload directory.
	 * If the file does not exist on the file system, the
	 * function will return false.
	 *
	 * @param $path
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private static function get_file_path($path)
	{
		$file = wp_get_upload_dir()['path'] . DIRECTORY_SEPARATOR . basename($path);
		if (file_exists($file)) {
			return $file;
		}
		return false;
	}

	/**
	 * Returns the mimetype of a file passed.
	 *
	 * @param $file
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private static function get_mime_type($file)
	{
		return mime_content_type($file);
	}
}
