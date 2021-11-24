<?php

/**
 * Fields
 *
 * Register Carbon Field options for the
 * admin part of the section.
 *
 * @package     Squidge
 * @version     1.0.0
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Fields
{

	/**
	 *
	 */
	public function __construct()
	{
		add_action('after_setup_theme', [$this, 'load_carbon_fields']);
		add_action('carbon_fields_register_fields', [$this, 'register_carbon_fields']);
	}

	/**
	 *
	 */
	public function load_carbon_fields()
	{
		define('\Carbon_Fields\URL', WP_SQUIDGE_URL . 'vendor/htmlburger/carbon-fields/');
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 *
	 */
	public function register_carbon_fields()
	{
		Container::make('theme_options', 'wp-squidge')
			->set_page_menu_title('WP Squidge Options')
			->set_page_parent('options-general.php')
			->add_fields([
				Field::make('html', 'wp_squidge_info')
					->set_html('<h1>Welcome to WP Squidge</h1><p>Quisque mattis ligula.</p>'),
				Field::make('text', 'wp_squidge_webp_status', 'WebP Status')
					->set_attribute('readOnly')
					->set_default_value('Disabled')
					->set_help_text("TODO")
			])
			->add_tab(__('JPEG'), [
				Field::make('checkbox', 'wp_squidge_jpg_enable', 'Enable JPEG Compression')
					->set_default_value(true)
					->set_help_text('Select this box to enable JPEG compression.'),
				Field::make('number', 'wp_squidge_jpg_quality', 'JPEG Optim Quality')
					->set_min(0)
					->set_max(100)
					->set_step(1)
					->set_default_value(80)
					->set_help_text('Enter the quality of the JPEG image compression, this can be a number from 0 to 100, with the default being 80.'),
			])
			->add_tab(__('PNG'), [
				Field::make('checkbox', 'wp_squidge_png_enable', 'Enable PNG Compression')
					->set_default_value(true)
					->set_help_text('Select this box to enable JPEG compression.'),
				Field::make('select', 'wp_squidge_png_quality', 'Opti PNG Level')
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
				Field::make('checkbox', 'wp_squidge_webp_enable', 'Enable WebP Conversion')
					->set_default_value(true)
					->set_help_text('Select this box to enable webp conversion.'),
				Field::make('number', 'wp_squidge_webp_quality', 'WebP Quality')
					->set_min(0)
					->set_max(100)
					->set_step(1)
					->set_default_value(80)
					->set_help_text('Enter the quality of the webp image conversion, this can be a number from 0 to 100, with the default being 80.'),
			])
			->add_tab(__('AVIF'), [
				Field::make('checkbox', 'wp_squidge_avif_enable', 'Enable AVIF Conversion')
					->set_default_value(true)
					->set_help_text('Select this box to enable AVIF conversion.'),
			])
			->add_tab(__('SVG'), [
				Field::make('checkbox', 'wp_squidge_svg_enable', 'Enable SVG compression.')
					->set_default_value(true)
					->set_help_text('Select this box to enable SVG compression.'),
			]);
	}
}
