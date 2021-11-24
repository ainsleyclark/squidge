<?php

/**
 * CLI
 *
 * Command for accessing Squidge compression
 * functions via the WP CLI.
 *
 * @package     Squidge
 * @version     0.1.0
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

if (!defined('WP_CLI')) {
	return; // Exit, WP CLI is not defined.
}

use Squidge\Squidge;
use Squidge\Services\JPG;
use Squidge\Services\PNG;
use Squidge\Services\WebP;
use Squidge\Services\AVIF;

class Squidge_CLI extends WP_CLI_Command
{

	/**
	 * Returns the version number of the plugin.
	 */
	public function version()
	{
		Squidge::boot()->version;
	}

	/**
	 * Processes all images from the WordPress database
	 * and compresses & optimises.
	 *
	 * JPG and PNG Compression will be run and files will be
	 * converted to .webp and .avif file formats.
	 *
	 * Args:
	 * 	- jpeg=false : To disable JPG compression.
	 * 	- png=false : To disable PNG compression.
	 * 	- webp=false : To disable WebP conversion.
	 * 	- avif=false : To disable AVIF conversion.
	 *  -
	 *
	 * @param $args
	 * @param $assoc_args
	 */
	public function run($args, $assoc_args)
	{
		WP_CLI::line(WP_CLI::colorize('%GWelcome to the Squidge CLI...%n' . PHP_EOL));

		$assoc_args = wp_parse_args(
			$assoc_args,
			[
				'quality'      => 80,
				'optimization' => 'o2',
				'jpeg'         => true,
				'png'          => true,
				'webp'         => true,
				'avif'         => true,
			]
		);

		$query_images_args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
		);

		$query_images = new WP_Query($query_images_args);

		foreach ($query_images->posts as $image) {
			$id = $image->ID;
			$image_args = [
				'quality' => $assoc_args['quality'],
				'optimization' => $assoc_args['optimization']
			];

			WP_CLI::log(WP_CLI::colorize("%BProcessing image: %n") . $image->post_title);

			// WebP
			if ($assoc_args['webp']) {
				try {
					WP_CLI::log('WebP Conversion...');
					WebP::process($id, $image_args);
				} catch (Exception $e) {
					WP_CLI::error($e->getMessage());
				}
			}

			// Avif
			if ($assoc_args['avif']) {
				try {
					WP_CLI::log('AVIF Conversion...');
					AVIF::process($id, $image_args);
				} catch (Exception $e) {
					WP_CLI::error($e->getMessage());
				}
			}

			// JPG
			if ($assoc_args['jpeg']) {
				try {
					WP_CLI::log('JPG Compression...');
					JPG::process($id, $image_args);
				} catch (Exception $e) {
					WP_CLI::error($e->getMessage());
				}
			}

			// PNG
			if ($assoc_args['png']) {
				try {
					WP_CLI::log('PNG Compression...');
					PNG::process($id, $image_args);
				} catch (Exception $e) {
					WP_CLI::error($e->getMessage());
				}
			}

			WP_CLI::success("Processed image: " . $image->post_title . PHP_EOL);
		}

		WP_CLI::success('Successfully processed images.' );
	}
}

/**
 * Add the main Squidge command to the WP CLI.
 */
WP_CLI::add_command('squidge', 'Squidge_CLI');
