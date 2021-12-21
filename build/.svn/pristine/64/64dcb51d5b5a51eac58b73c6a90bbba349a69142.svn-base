<?php
use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Number\Number_Field;

define( 'Carbon_Field_Number\\DIR', __DIR__ );

Carbon_Fields::extend( Number_Field::class, function( $container ) {
	return new Number_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );