<?php

/**
 * Service
 *
 * Service os responsible for processing file attachments
 * and executing commands.
 *
 * @package     Squidge
 * @version     0.1.0
 * @category    Class
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Services;

use Squidge\Log\Logger;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Jpeg Mime Type
 */
const JPEG_MIME = 'image/jpeg';

/**
 * PNG Mime Type
 */
const PNG_MIME = 'image/png';

/**
 * SVG Mime Type
 */
const SVG_MIME = 'image/svg+xml';


abstract class Service
{
	/**
	 * The command name to run
	 *
	 * @var string
	 */
	protected $cmd_name = '';

	/**
	 * @var string
	 */
	protected $extension = '';

	/**
	 * Constructs command name and extension
	 * if one is passed.
	 *
	 * @param string $cmd_name
	 * @param string $extension
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function __construct($cmd_name, $extension = '')
	{
		$this->cmd_name = $cmd_name;
		$this->extension = $extension;
	}

	/**
	 * Converts or compresses an image.
	 *
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public abstract function convert($filepath, $mime);

	/**
	 * Processes the file attachment.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function process($attachment)
	{
		// Return if the cwebp library is not installed.
		if (!$this->installed()) {
			Logger::error($this->cmd_name . " is not installed");
			return $attachment;
		}

		// Check if the file key exists.
		if (!isset($attachment['file'])) {
			Logger::error("File attachment is not set.");
			return $attachment;
		}

		// Obtain the file and check if it exists.
		$mainFile = $this->get_file_path($attachment['file']);
		if (!$mainFile) {
			Logger::error("File does not exist");
			return $attachment;
		}

		// Convert main image.
		$this->convert($mainFile, $this->get_mime_type($mainFile));

		// Loop over the sizes and convert them.
		foreach ($attachment['sizes'] as $size) {
			if (!isset($size['file'])) {
				continue;
			}
			$path = $this->get_file_path($size['file']);
			if (!$path) {
				continue;
			}
			$this->convert($path, $this->get_mime_type($path));
		}

		return $attachment;
	}

	/**
	 * Deletes all images  with file extensions associated
	 * with the image (if the file exists).
	 *
	 * @param $id
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function delete($id)
	{
		// Delete the original file.
		$original = wp_get_original_image_path($id) . $this->extension;
		if (file_exists($original)) {
			unlink($original);
			Logger::info("Successfully deleted file: " . $original);
		}

		// Delete the image sizes.
		$sizes = get_intermediate_image_sizes();
		foreach ($sizes as $size) {
			$src = wp_get_attachment_image_src($id, $size);
			$path = $this->get_file_path($src[0] . $this->extension);
			if (!$path) {
				continue;
			}
			unlink($path);
			Logger::info("Successfully deleted file: " . $path);
		}

		return $id;
	}

	/**
	 * Checks if a command exists.
	 *
	 * @return bool
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function installed()
	{
		$return = shell_exec(sprintf("which %s", escapeshellarg($this->cmd_name)));
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
	private function get_file_path($path)
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
	private function get_mime_type($file)
	{
		return mime_content_type($file);
	}
}
