<?php

/**
 * png
 *
 * PNG health status template.
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
	PNG
	===================== -->
<?php if ($health_valid) : ?>
	<h4>optipng library installed.</h4>
<?php else : ?>
	<h4>optipng <strong>not</strong> installed.</h4>
	<p>Use the following commands to install optipng dependant on your operating system.</p>
	<!-- Linux -->
	<div>
		<h3>Linux:</h3>
		<code>sudo apt-get install optipng</code>
		<p>For more information visit <a href="https://zoomadmin.com/HowToInstall/UbuntuPackage/optipng" target="_blank">here</a>.</p>
	</div>
	<!-- Mac -->
	<div>
		<h3>Mac:</h3>
		<code>brew install optipng</code>
		<p>For more information visit <a href="https://formulae.brew.sh/formula/optipng" target="_blank">here</a>.</p>
	</div>
	<!-- Windows -->
	<div>
		<h3>Windows:</h3>
		<p>To install for Windows, visit <a href="http://optipng.sourceforge.net/" target="_blank">here</a>.</p>
	</div>
<?php endif;

