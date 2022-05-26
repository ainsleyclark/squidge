<?php

/**
 * avif
 *
 * AVIF health status template.
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
	AVIF
	===================== -->
<?php if ($health_valid) : ?>
	<h4>avifenc library installed.</h4>
<?php else : ?>
	<h4>avifenc <strong>not</strong> installed.</h4>
	<p>Use the following commands to install avifenc dependant on your operating system.</p>
	<!-- Linux -->
	<div>
		<h3>Linux:</h3>
		<p>Dependant on your distro, you may need to build from source. Please visit <a href="https://aomediacodec.github.io/av1-avif/" target="_blank">here</a> for mor information.</p>
	</div>
	<!-- Mac -->
	<div>
		<h3>Mac:</h3>
		<code>brew install libavif</code>
		<p>For more information visit <a href="https://formulae.brew.sh/formula/libavif" target="_blank">here</a>.</p>
	</div>
	<!-- Windows -->
	<div>
		<h3>Windows:</h3>
		<p>To install for Windows, visit <a href="https://github.com/AOMediaCodec/libavif/releases" target="_blank">here</a>.</p>
	</div>
<?php endif;

