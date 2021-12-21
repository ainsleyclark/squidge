<?php

/**
 * Fields
 *
 * Register Carbon Field options for the
 * admin part of the plugin.
 *
 * @package     Squidge
 * @version     0.1.4
 * @author      Ainsley Clark
 * @category    Class
 * @repo        https://github.com/ainsleyclark/squidge
 *
 */

namespace Squidge\Admin;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Squidge\Services\AVIF;
use Squidge\Services\JPG;
use Squidge\Services\PNG;
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
	 * Load carbon fields and reassigns vendor path.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function load_carbon_fields()
	{
		define('\Carbon_Fields\URL', SQUIDGE_URL . 'vendor/htmlburger/carbon-fields/');
		Carbon_Fields::boot();
	}

	/**
	 * Registers custom admin style.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function styles_and_scripts()
	{
		wp_enqueue_style('admin-styles', SQUIDGE_URL . '/assets/admin.css');
	}

	/**
	 * Registers the admin fields (options).
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function register_carbon_fields()
	{
		Container::make('theme_options', 'Squidge')
			->set_page_menu_title('Squidge Options')
			->set_page_parent('options-general.php')
			->add_fields([
				Field::make('html', 'squidge_info')
					->set_html($this->render_template('info.php')),
				$this->get_health_field('jpg', 'jpg.php', 'JPG', JPG::installed()),
				$this->get_health_field('png', 'png.php', 'PNG', PNG::installed()),
				$this->get_health_field('webp', 'webp.php', 'WebP', WebP::installed()),
				$this->get_health_field('avif', 'avif.php', 'AVIF', AVIF::installed()),
			])
			->add_tab(__('JPG'), [
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
					->set_help_text('Select this box to enable PNG compression.'),
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
					->set_help_text('Enter the optimisation level of the PNG compression. The default is o2 with o7 being the fastest and o1 being the slowest.')
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

	/**
	 * Gets a Carbon health field dependent on if
	 * it is valid or installed. Classes and
	 * attributes will be set accordingly.
	 *
	 * @param $name
	 * @param $templateName
	 * @param $niceName
	 * @param $valid
	 * @return Field\Field
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private function get_health_field($name, $templateName, $niceName, $valid)
	{
		$tpl = $this->get_health_text('health' . DIRECTORY_SEPARATOR . $templateName, $valid);

		$field = Field::make('text', 'squidge_' . $name . '_status', $niceName . ' Status')
			->set_attribute('readOnly')
			->set_attribute('placeholder', 'Inactive')
			->set_classes('squidge squidge-disabled squidge-health squidge-health-inactive')
			->set_help_text($tpl);

		if ($valid) {
			$field->set_attribute('placeholder', 'Active')
				->set_classes('squidge squidge-disabled squidge-health squidge-health-active');
		}

		return $field;
	}

	/**
	 * Renders the health template.
	 *
	 * @param $templateName
	 * @param $valid
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private function get_health_text($templateName, $valid)
	{
		global $health_valid;
		$health_valid = $valid;
		return $this->render_template($templateName);
	}

	/**
	 * Renders a Squidge template in the /templates
	 * folder.
	 *
	 * @param $name
	 * @return false|string
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	private function render_template($name)
	{
		ob_start();
		include SQUIDGE_TEMPLATE_PATH . DIRECTORY_SEPARATOR . $name;
		return ob_get_clean();
	}
}
