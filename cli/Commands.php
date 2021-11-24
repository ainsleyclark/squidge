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

class Squidge_CLI extends WP_CLI_Command
{


	/**
	 * Creates a new service & container.
	 */
	public function __construct()
	{
		$this->squidge = Squidge::boot();
	}

	/**
	 * Returns the version number of the plugin.
	 */
	public function version()
	{
		echo $this->squidge->version;
	}

	/**
	 *
	 */
	public function run()
	{
		$query_images_args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
		);

		$query_images = new WP_Query($query_images_args);

		foreach ($query_images->posts as $image) {

			\Squidge\Services\WebP::process();

			//echo wp_get_attachment_url( $image->ID );
//			echo '\n';
//			print_r(wp_get_attachment_metadata($image->ID));
			$this->squidge->WebP->process($image->ID);
		}
	}
}

/**
 * Add the main Squidge command to the WP CLI.
 */
WP_CLI::add_command('squidge', 'Squidge_CLI');
