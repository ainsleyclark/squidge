<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function dbi_add_plugin_settings_page() {
    Container::make( 'theme_options', __( 'Example Plugin Page' ) )
        ->set_page_parent( 'options-general.php' )
        ->add_fields( array(
            Field::make( 'text', 'dbi_api_key', 'API Key' )
                ->set_attribute( maxLength, 32 ),
            Field::make( 'text', 'dbi_results_limit', 'Results Limit' )
                ->set_attribute( 'min', 1 )
                ->set_attribute( 'max', 100 )
                ->set_default_value( 10 ),
            Field::make( 'date', 'dbi_start_date', 'Start Date' ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'dbi_add_plugin_settings_page' );