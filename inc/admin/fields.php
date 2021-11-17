<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function wp_squidge_add_settings_page()
{
    Container::make('theme_options', __('WP Squidge'))
        ->set_page_parent('options-general.php')
        ->add_fields(array(
            Field::make('text', 'crb_text', 'Text Field'),
        ));
//        ->add_fields([
//            Field::make('text', 'dbi_api_key', 'API Key')
//                ->set_attribute("maxLength", 32),
//            Field::make('text', 'wp_squidge_webp_quality', 'WebP Quality')
//                ->set_attribute('min', 1)
//                ->set_attribute('max', 100)
//                ->set_default_value(80),
//            Field::make('date', 'dbi_start_date', 'Start Date'),
//        ]);
}


add_action('carbon_fields_register_fields', 'wp_squidge_add_settings_page');

function wp_squidge_boot_carbon()
{
    // TODO: This needs to be dynamic
    define( 'Carbon_Fields\URL', '/wp-content/plugins/wp-squidge/vendor/htmlburger/carbon-fields/' );
    \Carbon_Fields\Carbon_Fields::boot();
}

add_action('after_setup_theme', 'wp_squidge_boot_carbon');


// Define the url where Carbon Fields assets will be enqueued from
//
