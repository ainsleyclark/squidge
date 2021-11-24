<?php

/**
 * Fields
 *
 * Register Carbon Field options for the
 * admin part of the section.
 *
 * @package     Squidge
 * @version     0.1.0
 * @author      Ainsley Clark
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Squidge\Services\JPG;
use Squidge\Services\WebP;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Fields
{

	/**
	 * Boots carbon and register's custom fields.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		add_action('after_setup_theme', [$this, 'load_carbon_fields']);
		add_action('carbon_fields_register_fields', [$this, 'register_carbon_fields']);
		add_action('admin_enqueue_scripts', [$this, 'styles_and_scripts']);
	}

	/**
	 *Load carbon fields and reassigns vendor path.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function load_carbon_fields()
	{
		define('\Carbon_Fields\URL', WP_SQUIDGE_URL . 'vendor/htmlburger/carbon-fields/');
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Registers custom admin style.
	 */
	public function styles_and_scripts()
	{
		wp_enqueue_style('admin-styles', WP_SQUIDGE_URL . '/assets/admin.css');
	}

	/**
	 * Registers the admin fields (options).
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function register_carbon_fields()
	{

		ob_start();
		global $health_valid;
		$health_valid = false;
		include WP_SQUIDGE_PATH . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'webp.php';
		$result = ob_get_clean();


		$webp_field = Field::make('text', 'squidge_webp_statusgf', 'WebP Status')
			->set_attribute('readOnly')
			->set_attribute('placeholder', 'Inactive')
			->set_classes('squidge squidge-disabled squidge-health squidge-health-inactive')
			->set_help_text($result);


		if (WebP::installed()) {
			$webp_field
				->set_attribute('placeholder', 'Active')
				->set_classes('squidge squidge-disabled squidge-health squidge-health-active')
				->set_help_text($result);
		}


		Container::make('theme_options', 'Squidge')
			->set_page_menu_title('Squidge Options')
			->set_page_parent('options-general.php')
			->add_fields([
				Field::make('html', 'squidge_info')
					->set_html('<h1>Welcome to WP Squidge</h1><p>Quisque mattis ligula.</p>'),
				$webp_field,
			])
			->add_tab(__('JPEG'), [
				Field::make('checkbox', 'squidge_jpg_enable', 'Enable JPEG Compression')
					->set_default_value(true)
					->set_help_text('Select this box to enable JPEG compression.'),
				Field::make('number', 'squidge_jpg_quality', 'JPEG Optim Quality')
					->set_min(0)
					->set_max(100)
					->set_step(1)
					->set_default_value(80)
					->set_help_text('Enter the quality of the JPEG image compression, this can be a number from 0 to 100, with the default being 80.'),
			])
			->add_tab(__('PNG'), [
				Field::make('checkbox', 'squidge_png_enable', 'Enable PNG Compression')
					->set_default_value(true)
					->set_help_text('Select this box to enable JPEG compression.'),
				Field::make('select', 'squidge_png_quality', 'Opti PNG Level')
					->add_options([
						'0' => 'o1',
						'1' => 'o2',
						'2' => 'o3',
						'3' => 'o5',
						'4' => 'o4',
						'5' => 'o5',
						'6' => 'o6',
						'7' => 'o7',
					])
					->set_default_value('3')
					->set_width(100)
					->set_help_text('Pick a color')
			])
			->add_tab(__('WebP'), [
				Field::make('checkbox', 'squidge_webp_enable', 'Enable WebP Conversion')
					->set_default_value(true)
					->set_help_text('Select this box to enable webp conversion.'),
				Field::make('number', 'squidge_webp_quality', 'WebP Quality')
					->set_min(0)
					->set_max(100)
					->set_step(1)
					->set_default_value(80)
					->set_help_text('Enter the quality of the webp image conversion, this can be a number from 0 to 100, with the default being 80.'),
			])
			->add_tab(__('AVIF'), [
				Field::make('checkbox', 'squidge_avif_enable', 'Enable AVIF Conversion')
					->set_default_value(true)
					->set_help_text('Select this box to enable AVIF conversion.'),
			]);
	}
}
