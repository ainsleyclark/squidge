<?php

/**
 * Upload
 *
 * Upload is responsible for adding filters
 * and actions for the WordPress media
 * library.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge\Admin;

use Exception;
use Squidge\Log\Logger;
use Squidge\Services\AVIF;
use Squidge\Services\JPG;
use Squidge\Services\PNG;
use Squidge\Services\WebP;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Upload
{

	/**
	 * Adds filters to process web and jpg
	 * images.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		add_filter('big_image_size_threshold', '__return_false');
		add_filter("wp_generate_attachment_metadata", [$this, 'process_webp'], 20, 1);
		add_filter("wp_generate_attachment_metadata", [$this, 'process_avif'], 30, 1);
		add_filter("wp_generate_attachment_metadata", [$this, 'process_jpg'], 40, 1);
		add_filter("wp_generate_attachment_metadata", [$this, 'process_png'], 50, 1);
		add_filter("delete_attachment", [$this, 'delete_webp'], 20, 1);
		add_filter("delete_attachment", [$this, 'delete_avif'], 20, 1);
	}

	/**
	 * Compress a JPG file on upload.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function process_jpg($attachment)
	{
		if (!carbon_get_theme_option('squidge_jpg_enable')) {
			return $attachment;
		}

		try {
			$args = [
				'quality' => carbon_get_theme_option('squidge_jpg_quality'),
			];
			JPG::process($attachment, $args);
		} catch (Exception $e) {
			Logger::error($e->getMessage());
		}

		return $attachment;
	}

	/**
	 * Compress a PNG file on upload.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function process_png($attachment)
	{
		if (!carbon_get_theme_option('squidge_png_enable')) {
			return $attachment;
		}

		try {
			$args = [
				'optimization' => carbon_get_theme_option('squidge_webp_quality'),
			];
			PNG::process($attachment, $args);
		} catch (Exception $e) {
			Logger::error($e->getMessage());
		}

		return $attachment;
	}

	/**
	 * Process a JPG/PNG upload and converts to
	 * a WebP file with the .webp extension.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function process_webp($attachment)
	{
		if (!carbon_get_theme_option('squidge_webp_enable')) {
			return $attachment;
		}

		try {
			$args = [
				'quality' => carbon_get_theme_option('squidge_webp_quality'),
			];
			WebP::process($attachment, $args);
		} catch (Exception $e) {
			Logger::error($e->getMessage());

		}
		return $attachment;
	}

	/**
	 * Process a JPG/PNG upload and converts to
	 * a WebP file with the .avif extension.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function process_avif($attachment)
	{
		if (!carbon_get_theme_option('squidge_avif_enable')) {
			return $attachment;
		}

		try {
			AVIF::process($attachment, []);
		} catch (Exception $e) {
			Logger::error($e->getMessage());
		}

		return $attachment;
	}

	/**
	 * Deletes .webp files when the attachment is
	 * deleted from the media library.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function delete_webp($attachment)
	{
		WebP::delete($attachment);
		return $attachment;
	}

	/**
	 * Deletes .avif files when the attachment is
	 * deleted from the media library.
	 *
	 * @param $attachment
	 * @return mixed
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function delete_avif($attachment)
	{
		AVIF::delete($attachment);
		return $attachment;
	}
}
