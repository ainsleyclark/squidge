<?php

/**
 * Functions
 *
 * Helper template functions.
 *
 * @package     Squidge
 * @version     0.1.0
 * @author      Ainsley Clark
 * @category    Functions
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

if (!function_exists('squidge_image')) {
	function squidge_image($image_id, $class = '', $lazy = false) {

		if (empty($image)) {
			return "";
		}

		if (!$image) {
			return "";
		}

		$str = '';
		$lazyStr = '';
		$origClass = $class;

		if ($lazy) {
			$class = trim($class . ' lazy', ' ');
			$lazyStr = 'data-';
		}

		if (!in_array('sizes', $image) || $image['mime_type'] === "image/svg+xml") {
			return '<img ' . $lazyStr . ' src="' . $image['url'] . '" class="' . $class . '" alt="' . $image['alt'] . '">';
		}

		$sizes = $image['sizes'];

		if ($sizes['mobile']) {
			$str .= '<source media="(max-width: 767px)" ' . $lazyStr . 'srcset="' . $sizes['mobile'] . '">';
		}

		if ($sizes['tablet']) {
			$str .= '<source media="(max-width: 1024px)" ' . $lazyStr . 'srcset="' . $sizes['tablet'] . '">';
		}

		$str .= '<img class="' . $class . '"' . $lazyStr . 'src="' . $image['url'] . '"  alt="' . $image['alt'] . '">';

		if ($lazy) {
			$str .= '<noscript><img class="' . $origClass . '" src="' . $image['url'] . '"  alt="' . $image['alt'] . '"></noscript>';
		}

		return $str;
	}
}
