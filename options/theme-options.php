<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', __( 'Table Settings', 'crb' ) )
	->add_tab( __( 'General', 'crb' ), array(
		Field::make( 'text', 'crb_table_api_key', __( 'API Key', 'crb' ) )
			->set_help_text( __( 'Set the API key for the tables', 'crb' ) ),
	) )
	->add_tab( __( 'Espace Popup Settings', 'crb' ), array(
		Field::make( 'text', 'crb_espace_popup_address', __( 'Event Address', 'crb' ) )
			->set_width( 50 )
			->set_help_text( __( 'If left blank, we will try to get the api location name to create a link for google places' ) ),
		Field::make( 'text', 'crb_espace_popup_campus_address', __( 'Campus Address', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'text', 'crb_espace_popup_phone', __( 'Event Phone', 'crb' ) ),
		Field::make( 'select', 'crb_espace_popup_date_format', __( 'Choose Date Format', 'crb' ) )
			->set_options([
				'MMM, ddd D, HH:mm A' => '',
				'MMM, ddd D, HH:mm:ss A' => '',
				'MMM, ddd DD, HH:mm a' => '',
				'MMMM, dddd DD, HH:mm A' => '',
				'YYYY, MMM, ddd, D, HH:mm A' => '',
				'YYYY, MMM, ddd, D, HH:mm:ss A' => '',
			]),
	) )
	->add_tab( __( 'Espace Section Popup Settings', 'crb' ), array(
		Field::make( 'text', 'crb_espace_popup_description_title', __( 'Description Title', 'crb' ) )
			->set_default_value( __('Description', 'crb') )
			->set_width(50),
		Field::make( 'text', 'crb_espace_popup_date_and_time_title', __( 'Date And Time Title', 'crb' ) )
			->set_default_value( __('Date And Time', 'crb') )
			->set_width(50),
		Field::make( 'text', 'crb_espace_popup_location_title', __( 'Location Title', 'crb' ) )
			->set_default_value( __('Location', 'crb') )
			->set_width(50),
		Field::make( 'text', 'crb_espace_popup_event_contact_title', __( 'Event Contact Title', 'crb' ) )
			->set_default_value( __('Event Contact', 'crb') )
			->set_width(50),
		Field::make( 'text', 'crb_espace_popup_share_with_friends_title', __( 'Share With Friends Title', 'crb' ) )
			->set_default_value( __('Share With Friends', 'crb') ),
		Field::make( 'checkbox', 'crb_espace_popup_hide_title', __( 'Hide Title', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_espace_popup_hide_description', __( 'Hide Description', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_espace_popup_hide_date_and_time', __( 'Hide Date And time', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_espace_popup_hide_location', __( 'Hide Location', 'crb' ) )
			->set_width( 50 ),
			Field::make( 'checkbox', 'crb_espace_popup_hide_event_contact', __( 'Hide Contact', 'crb' ) )
			->set_width( 50 ),
		Field::make( 'checkbox', 'crb_espace_popup_hide_share_with_friends', __( 'Hide Share', 'crb' ) )
			->set_width( 50 ),
	) );