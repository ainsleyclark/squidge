<?php

/**
 * webp
 *
 * WebP health status template.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Templates
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

global $health_valid;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

?>

<!-- =====================
	WebP
	===================== -->
<?php if ($health_valid) : ?>
	<h4>cwebp library installed.</h4>
<?php else : ?>
	<h4>cwebp <strong>not</strong> installed.</h4>
	<p>Use the following commands to install cwebp dependant on your operating system.</p>
	<!-- Linux -->
	<div>
		<h3>Linux:</h3>
		<code>sudo apt-get install webp</code>
		<p>For more information visit <a href="https://www.interserver.net/tips/kb/install-and-serve-webp-images-on-ubuntu/" target="_blank">here</a>.</p>
	</div>
	<!-- Mac -->
	<div>
		<h3>Mac:</h3>
		<code>brew install webp</code>
		<p>For more information visit <a href="https://formulae.brew.sh/formula/webp" target="_blank">here</a>.</p>
	</div>
	<!-- Windows -->
	<div>
		<h3>Windows:</h3>
		<p>To install for Windows, visit <a href="https://developers.google.com/speed/webp/download" target="_blank">here</a>.</p>
	</div>
<?php endif;

