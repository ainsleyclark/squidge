<?php

/**
 * File
 *
 * Is a helper for obtaining image html data for the
 * front end.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge\Package;

use Squidge\Services\AVIF;
use Squidge\Services\WebP;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class File
{

	/**
	 * Returns source media element with the WebP
	 * extension, if it exists.
	 *
	 * @param $file
	 * @param $url
	 * @param bool $lazy
	 * @param bool $width
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function webp($file, $url, $lazy = false, $width = false)
	{

		if (self::file_exists($file)) {
			return '<source ' . self::get_media_width($width) . '' . self::get_lazy_str($lazy) . 'srcset="' . SQUIDGE_UPLOAD_URL . '/' . $url . WebP::extension() . '" type="image/webp">';
		}
		return '';
	}

	/**
	 * Returns source media element with the AVIF
	 * extension, if it exists.
	 *
	 * @param $file
	 * @param $url
	 * @param bool $lazy
	 * @param bool $width
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function avif($file, $url, $lazy = false, $width = false)
	{
		if (self::file_exists($file)) {
			return '<source ' . self::get_media_width($width) . '' . self::get_lazy_str($lazy) . 'srcset="' . SQUIDGE_UPLOAD_URL . '/' . $url . AVIF::extension() . '" type="image/avif">';
		}
		return '';
	}

	/**
	 * Returns a source media element.
	 *
	 * @param $file
	 * @param $url
	 * @param bool $lazy
	 * @param bool $width
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function source($file, $url, $lazy = false, $width = false)
	{
		if (self::file_exists($file)) {
			return '<source ' . self::get_media_width($width) . '' . self::get_lazy_str($lazy) . 'srcset="' . SQUIDGE_UPLOAD_URL . '/' . $url . '">';
		}
		return '';
	}

	/**
	 * Returns the normal image.
	 *
	 * @param $url
	 * @param $alt
	 * @param $title
	 * @param false $lazy
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public static function image($url, $alt, $title, $lazy = false)
	{
		return '<img ' . self::get_lazy_str($lazy) . 'src="' . SQUIDGE_UPLOAD_URL . '/' . $url . '" alt="' . $alt . '" title="' . $title . '">';
	}

	/**
	 * Returns media-max width if it's set.
	 *
	 * @param $width
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private static function get_media_width($width)
	{
		if (!$width) {
			return '';
		}
		$int_width = (int)$width;
		return 'media="(max-width: ' . ($int_width + 100) . 'px)"';
	}

	/**
	 * Returns the lazy load string if set.
	 *
	 * @param $lazy
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private static function get_lazy_str($lazy)
	{
		return $lazy ? 'data-' : '';
	}

	/**
	 * Determines if image file exists,
	 *
	 * @param $file
	 * @return bool
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private static function file_exists($file)
	{
		return file_exists(SQUIDGE_UPLOAD_DIR . DIRECTORY_SEPARATOR . $file);
	}
}
