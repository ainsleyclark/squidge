<?php

/**
 * Functions
 *
 * Helper template functions.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Functions
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use Squidge\Package\File;

if (!function_exists('squidge_image')) {

	/**
	 * Returns a <picture> element with source media for the standard file passed
	 * (such as a JPG), the .avif file, the .webp file (if to exist on the file system).
	 *
	 * Appropriate <source> elements for image sizes with max widths.
	 * Finally, the main be outputted with alt and title text.
	 *
	 * If lazy is true, the data-src or data-srcset will be appended.
	 * If a class is set, the class will be outputted on the <picture> element.
	 *
	 * @param $image_id
	 * @param string $class
	 * @param false $lazy
	 * @return string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	function squidge_image($image_id, $class = '', $lazy = false)
	{
		$image = wp_get_attachment_metadata($image_id);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
		$image_title = get_the_title($image_id);

		$mainImageURL = $image['file'];

		$str = '<picture class="' . $class . '">';

		if (isset($image['sizes'])) {
			foreach ($image['sizes'] as $size) {
				$str .= File::avif(dirname($mainImageURL) . '/' . $size['file'], $mainImageURL, $lazy, $size['width']);
				$str .= File::webp(dirname($mainImageURL) . '/' . $size['file'], $mainImageURL, $lazy, $size['width']);
				$str .= File::source(dirname($mainImageURL) . '/' . $size['file'], $mainImageURL, $lazy, $size['width']);
			}
		}

		$str .= File::avif($image['file'], $mainImageURL, $lazy);
		$str .= File::webp($image['file'], $mainImageURL, $lazy);
		$str .= File::image($mainImageURL, $image_alt, $image_title, $lazy);

		$str .= '</picture>';

		return $str;
	}
}
