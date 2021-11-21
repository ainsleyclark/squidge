<?php

/**
 * Fields
 *
 * Register Carbon Field options for the
 * admin part of the section.
 *
 * @package     WP Squidge
 * @version     1.0.0
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace WPSquidge\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Register carbon fields.
 */
function wp_squidge_add_settings_page()
{
    Container::make('theme_options', 'wp-squidge')
        ->set_page_menu_title('WP Squidge Options')
        ->set_page_parent('options-general.php')
        ->add_fields([
            Field::make('html', 'wp_squidge_info')
                ->set_html('<h1>Welcome to WP Squidge</h1><p>Quisque mattis ligula.</p>'),
            Field::make( 'text', 'wp_squidge_webp_status', 'WebP Status')
                ->set_attribute('readOnly')
                ->set_default_value('Disabled')
                ->set_help_text("TODO")
        ])
        ->add_tab(__('WebP'), [
            Field::make('checkbox', 'wp_squidge_webp_enable', 'Enable WebP Conversion')
                ->set_default_value(true)
                ->set_option_value(true)
                ->set_help_text('Select this box to enable webp conversion.'),
            Field::make('number', 'wp_squidge_webp_quality', 'WebP Quality')
                ->set_min(0)
                ->set_max(100)
                ->set_step(1)
                ->set_default_value(80)
                ->set_help_text('Enter the quality of the webp image conversion, this can be a number from 0 to 100, with the default being 80.'),
        ])
        ->add_tab(__('JPEG'), [
            Field::make('checkbox', 'wp_squidge_jpeg_enable', 'Enable JPEG Compression')
                ->set_default_value(true)
                ->set_option_value(true)
                ->set_help_text('Select this box to enable JPEG compression.'),
            Field::make('number', 'wp_squidge_jpeg_quality', 'JPEG Optim Quality')
                ->set_min(0)
                ->set_max(100)
                ->set_step(1)
                ->set_default_value(80)
                ->set_help_text('Enter the quality of the JPEG image compression, this can be a number from 0 to 100, with the default being 80.'),
        ])
        ->add_tab(__('PNG'), [
            Field::make('select', 'wp_squidge_optipng_quality', 'Opti PNG Level')
                ->add_options([
                    'left'   => 'Left',
                    'center' => 'Center',
                    'right'  => 'Right',
                ])
                ->set_width(100)
                ->set_help_text('Pick a color')
        ])
        ->add_tab(__('SVG'), [
            Field::make('select', 'wp', 'Opti PNG Level')
                ->add_options([
                    'left'   => 'Left',
                    'center' => 'Center',
                    'right'  => 'Right',
                ])
                ->set_width(100)
                ->set_help_text('Pick a color')
        ]);
}

add_action('carbon_fields_register_fields', __NAMESPACE__ . '\wp_squidge_add_settings_page');

/**
 * Define carbon fields URL for assets
 * and boot Carbon.
 */
function wp_squidge_boot_carbon()
{
    define('\Carbon_Fields\URL', WP_SQUIDGE_URL . 'vendor/htmlburger/carbon-fields/');
    \Carbon_Fields\Carbon_Fields::boot();
}

add_action('after_setup_theme', __NAMESPACE__ . '\wp_squidge_boot_carbon', 10);


