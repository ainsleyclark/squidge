<?php

/**
 * jpg
 *
 * JPG health status template.
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
	JPG
	===================== -->
<?php if ($health_valid) : ?>
	<h4>jpegoptim library installed.</h4>
<?php else : ?>
	<h4>jpegoptim <strong>not</strong> installed.</h4>
	<p>Use the following commands to install jpegoptim dependant on your operating system.</p>
	<!-- Linux -->
	<div>
		<h3>Linux:</h3>
		<code>sudo apt-get install jpegoptim</code>
		<p>For more information visit <a href="https://vitux.com/optimize-jpeg-jpg-images-in-ubuntu-with-jpegoptim/" target="_blank">here</a>.</p>
	</div>
	<!-- Mac -->
	<div>
		<h3>Mac:</h3>
		<code>brew install jpegoptim</code>
		<p>For more information visit <a href="https://formulae.brew.sh/formula/jpegoptim" target="_blank">here</a>.</p>
	</div>
	<!-- Windows -->
	<div>
		<h3>Windows:</h3>
		<p>To install for Windows, visit <a href="https://github.com/XhmikosR/jpegoptim-windows" target="_blank">here</a>.</p>
	</div>
<?php endif;


