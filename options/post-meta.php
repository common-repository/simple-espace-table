<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! empty( $_GET['post'] ) ) {
	$current_post_id = $_GET['post'];
}

Container::make( 'post_meta', __( 'Table Settings', 'crb' ) )
	->show_on_post_type( 'crb_table' )
	->add_tab( __( 'General', 'crb' ), array(
		Field::make( 'html', 'crb_table_shortcode', '' )
			->set_html( '<h1>' . __( 'Table Shortcode:', 'crb' ) . '</h1><code>[simple-espace-table id="' . $current_post_id . '"]</code>' ),
		Field::make( 'checkbox', 'crb_hide_non_public_events', __( 'Hide Non Public Events', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_hide_header', __( 'Hide Header', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'number', 'crb_table_speed_multiplicator', __( 'Speed Multiplicator', 'crb' ) )
			->set_help_text( __( 'Set the speed of the table.The higher the number is the slower the table scroll speed.', 'crb' ) )
			->set_default_value( 17 )
			->set_min( 1 )
			->set_max( 100 ),
		Field::make( 'number', 'crb_table_seconds_pause', __( 'Pause Seconds', 'crb' ) )
			->set_help_text( __( 'Set how much seconds to pause before scrolling back from top.', 'crb' ) )
			->set_default_value( 1 )
			->set_min( 1 )
			->set_max( 100 ),
		Field::make( 'image', 'crb_table_image', __( 'Table Image', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_table_image_hide', __( 'Hide Table Image', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_set_table_full_height', __( 'Set Table Screen Height', 'crb' ) )
			->set_help_text( __( 'Set Table Height To Screen Height', 'crb' ) )
			->set_width( 50 )
			->set_default_value( true ),
		Field::make( 'number', 'crb_table_height', __( 'Table Height', 'crb' ) )
			->set_width( 50 )
			->set_default_value( 1000 )
			->set_min( 200 )
			->set_help_text( __( 'Units in pixels', 'crb' ) )
			->set_conditional_logic( array(
				array(
					'field' => 'crb_set_table_full_height',
					'value' => '',
				),
			) ),
		Field::make( 'checkbox', 'crb_set_table_full_width', __( 'Set Table Screen Width', 'crb' ) )
			->set_help_text( __( 'Set Table Width To Screen Width', 'crb' ) )
			->set_width( 50 )
			->set_default_value( true ),
		Field::make( 'number', 'crb_table_width', __( 'Table Width', 'crb' ) )
			->set_width( 50 )
			->set_default_value( 1000 )
			->set_min( 200 )
			->set_help_text( __( 'Units in pixels', 'crb' ) )
			->set_conditional_logic( array(
				array(
					'field' => 'crb_set_table_full_width',
					'value' => '',
				),
			) ),
		Field::make( 'number', 'crb_table_max_days_to_show', __( 'Max Forward Days To Show data', 'crb' ) )
			->set_min( 1 )
			->set_default_value( 6 ),
		Field::make( 'complex', 'crb_columns', __( 'Columns', 'crb' ) )
			->setup_labels( array(
				'singular_name' => __( 'Column', 'crb' ),
				'plural_name' => __( 'Columns', 'crb' ),
			) )
			->set_layout( 'tabbed-vertical' )
			->add_fields( array(
				Field::make( 'number', 'title_font_size', __( 'Title Font Size', 'crb' ) )
					->set_width( 50 )
					->set_min( 8 )
					->set_default_value( 14 ),
				Field::make( 'number', 'column_font_size', __( 'Column Font Size', 'crb' ) )
					->set_width( 50 )
					->set_min( 8 )
					->set_default_value( 14 ),
				Field::make( 'checkbox', 'wrap_text', __( 'Wrap Text', 'crb' ) ),
				Field::make( 'number', 'max_words_on_line', __( 'Max Words Permitted', 'crb' ) )
					->set_default_value( 5 )
					->set_conditional_logic( array(
						array(
							'field' => 'wrap_text',
							'value' => true, 
						),
					) )
					->set_help_text( __( 'Set max words on one line before wrapping to a new line' ) )
					->set_min( 1 )
					->set_max( 200 ),
				Field::make( 'number', 'forward_days_to_hide_date', __( 'Forward Days To Hide Date', 'crb' ) )
					->set_help_text( __( 'How Many Days forward to hide date.0 vlaue is off and 1 value is the current day', 'crb' ) )
					->set_width( 50 )
					->set_default_value( 0 )
					->set_min( 0 ),
				Field::make( 'checkbox', 'hide_past_events', __( 'Hide Past Events', 'crb' ) )
					->set_help_text( __( 'Hide Events that have already finished', 'crb' ) )
					->set_width( 50 ),
				Field::make( 'select', 'column_type', __( 'Choose A Column Option', 'crb' ) )
					->set_options( \Espace\SetTable::set_get_column_options_test() ),
				Field::make( 'text', 'column_title', __( 'Title', 'crb' ) )
					->set_required( true ),
				Field::make( 'html', 'crb_help_html_column', '' )
					->set_html( __( '<strong>You have to make all columns combined to 100% exceeding may cause problems to the table </strong>', 'crb' ) ),
				Field::make( 'number', 'column_width', __( 'Width', 'crb' ) )
					->set_default_value( 50 )
					->set_min( 5 )
					->set_max( 100 )
					->set_help_text( __( 'Units in percents', 'crb' ) ),
			) )
			->set_header_template( '<%- column_title %>' )
			->set_max( 5 )
			->set_required( true ),
	) )
	->add_tab( __( 'Style Settings', 'crb' ), array(
		Field::make( 'color', 'crb_table_head_background_color', __( 'Table Head Background Color', 'crb' ) )
			->set_default_value( '#40B9A1' ),
		Field::make( 'color', 'crb_table_first_title_color', __( 'First Title Color', 'crb' ) )
			->set_default_value( '#fff' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_title_color', __( 'Title Color', 'crb' ) )
			->set_default_value( '#40B9A1' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_first_column_background_color', __( 'First Column Background Color', 'crb' ) )
			->set_default_value( '#000' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_column_background_color', __( 'Column Background Color', 'crb' ) )
			->set_default_value( '#272726' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_first_column_text_color', __( 'First Column Text Color', 'crb' ) )
			->set_default_value( '#40B9A1' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_column_text_color', __( 'Column Text Color', 'crb' ) )
			->set_default_value( '#ccc' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_first_column_line_color', __( 'First Column Line Color', 'crb' ) )
			->set_default_value( '#000' )
			->set_width( 50 ),
		Field::make( 'color', 'crb_table_column_line_color', __( 'Column Line Color', 'crb' ) )
			->set_default_value( '#000' )
			->set_width( 50 ),
		Field::make( 'number', 'crb_table_first_column_line_size', __( 'First Column Line Size', 'crb' ) )
			->set_width( 50 )
			->set_default_value( 1 )
			->set_min( 1 )
			->set_help_text( __( 'Units in pixels', 'crb' ) ),
		Field::make( 'number', 'crb_table_column_line_size', __( 'Column Line Size', 'crb' ) )
			->set_width( 50 )
			->set_default_value( 1 )
			->set_min( 1 )
			->set_help_text( __( 'Units in pixels', 'crb' ) ),
	) )
	->add_tab( __( 'Font Size Settings', 'crb' ), array(
		Field::make( 'number', 'crb_table_title_font_size', __( 'Title Font Size', 'crb' ) )
			->set_min( 1 )
			->set_default_value( 14 ),
		Field::make( 'number', 'crb_table_body_font_size', __( 'Body Font Size', 'crb' ) )
			->set_min( 1 )
			->set_default_value( 14 ),
	) );