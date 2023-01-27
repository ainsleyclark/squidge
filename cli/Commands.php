<?php

/**
 * CLI
 *
 * Command for accessing Squidge compression
 * functions via the WP CLI.
 *
 * @package     Squidge
 * @version     0.1.4
 * @category    CLI
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

if (!defined('WP_CLI')) {
	return; // Exit, WP CLI is not defined.
}

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
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
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function version()
	{
		$this->print_welcome();
		WP_CLI::log(Squidge::boot()->version);
	}

	/**
	 * Prints health status for each service.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function health()
	{
		$this->print_welcome();
		$this->print_health("jpegoptim", JPG::installed());
		$this->print_health("optipng", PNG::installed());
		$this->print_health("cwebp", WebP::installed());
		$this->print_health("avifenc", AVIF::installed());
	}

	/**
	 * Processes all images from the WordPress database
	 * and compresses & optimises.
	 *
	 * JPG and PNG Compression will be run and files will be
	 * converted to .webp and .avif file formats.
	 *
	 * Args:
	 *    - jpg=true       To enable JPG compression.
	 *    - png=true     To enable PNG compression.
	 *    - webp=true     To enable WebP conversion.
	 *    - avif=true       To enable AVIF conversion.
	 *    - quality=80     The quality of compression
	 *    - optimization=02  Optimization of PNG images
	 *    - force=false  Force reoptimization of already optimized images
	 *    - thumbnails-only=false  Only optimize thumbnails
	 *
	 * @param $args
	 * @param $assoc_args
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function run($args, $assoc_args)
	{
		$this->print_welcome();

		$assoc_args = wp_parse_args(
			$assoc_args,
			[
				'quality' => 80,
				'optimization' => 'o2',
				'jpg' => true,
				'png' => true,
				'webp' => true,
				'avif' => true,
				'force' => false,
				'thumbnails-only' => false,
			]
		);

		$assoc_args['jpg'] = filter_var($assoc_args['jpg'], FILTER_VALIDATE_BOOLEAN);
		$assoc_args['png'] = filter_var($assoc_args['png'], FILTER_VALIDATE_BOOLEAN);
		$assoc_args['webp'] = filter_var($assoc_args['webp'], FILTER_VALIDATE_BOOLEAN);
		$assoc_args['avif'] = filter_var($assoc_args['avif'], FILTER_VALIDATE_BOOLEAN);
		$assoc_args['force'] = filter_var($assoc_args['force'], FILTER_VALIDATE_BOOLEAN);
		$assoc_args['thumbnailsOnly'] = filter_var($assoc_args['thumbnails-only'], FILTER_VALIDATE_BOOLEAN);

		$page = 0;
		$counter = 0;
		$query_loop = true;
		while ($query_loop === true) {
			$query_images_args = array(
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'posts_per_page' => 1000,
				'paged' => $page,
			);

			$query_images = new WP_Query($query_images_args);

			foreach ($query_images->posts as $image) {
				$id = $image->ID;
				$image_args = [
					'quality' => $assoc_args['quality'],
					'optimization' => $assoc_args['optimization'],
					'force' => $assoc_args['force'],
					'thumbnailsOnly' => $assoc_args['thumbnailsOnly'],
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
				if ($assoc_args['jpg']) {
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
				$counter++;
			}

			if ($query_images->max_num_pages >= $page) {
				$query_loop = false;
			} else {
				$page++;
			}
		}

		wp_reset_postdata();

		WP_CLI::success('Successfully processed ' . $counter . ' images. ');
	}

	/**
	 * Prints CLI welcome message.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private function print_welcome()
	{
		WP_CLI::line(WP_CLI::colorize('%GWelcome to the Squidge CLI...%n' . PHP_EOL));
	}

	/**
	 * Prints the health information for a service.
	 *
	 * @param $type
	 * @param $active
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private function print_health($type, $active)
	{
		if ($active) {
			WP_CLI::success($type . " active.");
			return;
		}
		WP_CLI::log(WP_CLI::colorize("%RError: %n") . $type . ' not installed, visit docs.');
	}
}

/**
 * Add the main Squidge command to the WP CLI.
 */
WP_CLI::add_command('squidge', 'Squidge_CLI');
