<?php

/*
 * Plugin Name: SIMPLE eSPACE TABLE
 * Description: SIMPLE eSPACE TABLE (SeT) is designed to take the power of eSPACE, a product from CoolSolution Group, and output the event in a simple html table format to easily be shown on digital signage or a simple web view. The setup is easy and the configuration is a breeze. Just input your API key in settings and then customize one or more table views to output your event data.
 * Author: fbchville
 * Version: 1.3
 * License: GPL2+
 * Text Domain: crb
 * Domain Path: /languages/
 */

define( 'SIMPLE_ESPACE_TABLE_MINIMUM_WP_VERSION', '4.4' );
define( 'SIMPLE_ESPACE_TABLE_VERSION', '1.3' );
define( 'SIMPLE_ESPACE_TABLE_INIT', true );
define( 'SIMPLE_ESPACE_TABLE_LICENSE', true );
define( 'SIMPLE_ESPACE_TABLE_PLUGIN_DIR', __DIR__ );
define( 'SIMPLE_ESPACE_TABLE_PLUGIN_URL', plugins_url('simple-espace-table') );


add_action( 'after_setup_theme', function() {
	// Include composer
	require_once( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/vendor/autoload.php' );

	// Init carbon Fields
	\Carbon_Fields\Carbon_Fields::boot();

	\Espace\SetTable::init_table();
	\Espace\AjaxMethods::initMethods();

	add_action( 'carbon_fields_register_fields', 'crb_register_theme_and_post_meta_options' );
} );

function crb_register_theme_and_post_meta_options() {
	// Theme options init
	include_once( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/options/theme-options.php' );

	//Init post meta
	include_once( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/options/post-meta.php' );
}

function crb_init_post_types() {
	include_once( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/options/post_types.php' );
}
add_action( 'init', 'crb_init_post_types' );

function crb_init_table_styles() {
	wp_enqueue_script( 'carbon-table-js-functions', SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/dist/bundle.js', array('jquery'), '1.2', true );

	// add admin url
	wp_localize_script( 'carbon-table-js-functions', 'wp_espace_admin_data', [
		'admin_url' => admin_url('admin-ajax.php'),
	]);

	// Style loader
	wp_enqueue_style( 'style-flipclock', SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/styles/flipclock.css' );
	wp_enqueue_style( 'carbon-event-table-style', SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/styles/style-table.css', array(), '1.5.9' );
}
add_action( 'wp_enqueue_scripts', 'crb_init_table_styles' );

function crb_init_admin_scripts() {
	wp_enqueue_script( 'moment-js', SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/js/external/moment.min.js', array(), '1.1', true );

	wp_enqueue_script( 'carbon-field-logic-js', SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/js/carbon_fields_logic.js', array( 'jquery', 'moment-js' ), '1.1', true );
}
add_action( 'admin_enqueue_scripts', 'crb_init_admin_scripts' );

function crb_table_shortcode( $args ) {
	if ( empty( $args['id'] ) || ! is_numeric( $args['id'] ) ) {
		return;
	}

	$table_id = $args['id'];
	ob_start();
	include( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/shortcode_template/tables.php' );
	$html = ob_get_clean();

	return $html;
}
add_shortcode( 'simple-espace-table', 'crb_table_shortcode' );