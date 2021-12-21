<?php

/**
 * Service
 *
 * Service os responsible for processing file attachments
 * and executing commands.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge\Package;

use Exception;
use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Service
{

	/**
	 * META_KEY is the meta key for lookup for the
	 * service.
	 */
	const META_KEY = "_squidge_compressed";

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

		// Return if the library is not installed.
		if (!self::installed()) {
			return;
		}

		// Check if the file key exists.
		if (!isset($attachment['file'])) {
			throw new Exception("File attachment is not set.");
		}

		// Obtain the file and check if it exists.
		$mainFile = self::get_file_path($attachment['file']);
		if (!$mainFile) {
			return;
		}

		// Check if the attachment has already been compressed.
		$id = attachment_url_to_postid($attachment['file']);
		if (self::has_compressed($id)) {
			return;
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

		// Update post meta for attachment.
		self::update_meta($id);
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
	 * shell_exec is required to check to see if the library
	 * is installed on the client's operating system.
	 * Checks to see if the command name is in the allowed
	 * array before continuing.
	 *
	 * @return bool
	 * @since 0.1.2
	 * @date 05/12/2021
	 */
	public static function installed()
	{
		$allowed = [
			'jpegoptim',
			'optipng',
			'cwebp',
			'avifenc',
		];
		if (!in_array(static::cmd_name(), $allowed)) {
			return false;
		}
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

	/**
	 * Determines if the attachment has been compressed.
	 *
	 * @param $id
	 * @return bool
	 * @since 0.1.4
	 * @date 21/12/2021
	 */
	public static function has_compressed($id)
	{
		$meta = get_post_meta($id, self::META_KEY . '_' . static::cmd_name());
		return !empty($meta);
	}

	/**
	 * Updates post meta for squidge.
	 *
	 * @param $id
	 * @since 0.1.4
	 * @date 21/12/2021
	 */
	public static function update_meta($id)
	{
		update_post_meta($id, self::META_KEY . '_' . static::cmd_name(), true);
	}
}
