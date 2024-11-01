<?php
namespace Espace;

class SetTable {
	public static function init_table() {
		add_action( 'init', array( static::class, 'init_columns' ) );
	}

	public static function init_columns() {
		add_filter( 'manage_crb_table_posts_columns', array( static::class, 'set_column_table_head' ), 999, 1 );
		add_action( 'manage_crb_table_posts_custom_column', array( static::class, 'set_column_table_html' ), 999, 2 );
	}

	public static function set_get_table_json_data( $table_id, $get_options = false, $parse_to_arr = true ) {
		if ( empty( $table_id ) && ! $get_options ) {
			return;
		}

		$table_api_key = carbon_get_theme_option( 'crb_table_api_key' );

		if ( empty( $table_api_key ) ) {
			return array();
		}

		if ( ! $get_options ) {
			$max_days = intval( carbon_get_post_meta( $table_id, 'crb_table_max_days_to_show' ) );

			if ( empty( $max_days ) || ! is_numeric( $max_days ) ) {
				$max_days = 6;
			}
		} else {
			$max_days = 2;
		}


		$table_data_url = 'https://app.espace.cool/api/v1/rest/events/occurrences?orgkey=' . $table_api_key . '&nextdays=' . $max_days .'&type=JSON';

		$data_response = wp_remote_get( $table_data_url );
		$status_code = wp_remote_retrieve_response_code( $data_response );

		if ( empty( $status_code ) || $status_code !== 200 ) {
			return array();
		}

		$body_response_json = json_decode( wp_remote_retrieve_body( $data_response ), true );

		if ( $max_days === 1 ) {
			$new_body_response_json = array();

			foreach ( $body_response_json as $data ) {
				$add_data = true;
				foreach ( $data as $column_name => $column_value ) {
					if ( preg_match( '~OccurrenceStartTime~i', $column_name ) ) {
						$time = explode( ' ', $column_value );
						if ( empty( $time[1] ) ) {
							return $column_value;
						}


						$date_timestamp = strtotime( $time[0] );
						$current_date_timestamp = time();

						if ( empty( $date_timestamp ) ) {
							return $column_value;
						}

						if ( $date_timestamp > time() ) {
							$add_data = false;
						}
					}
				}

				if ( $add_data ) {
					$new_body_response_json[] = $data;
				}
			}

			unset( $body_response_json );
			$body_response_json = $new_body_response_json;
		}

		$table_index = 1;
		$indexed_table_data = [];

		foreach ($body_response_json as $data) {
			$data['table_data_id'] = $table_index;

			$indexed_table_data[] = $data;
			$table_index++;
		}

		$hide_non_public = carbon_get_post_meta( $table_id, 'crb_hide_non_public_events' );

		if ( $hide_non_public ) {
			$indexed_table_data = static::set_filter_non_public_data( $indexed_table_data );
		}

		return $indexed_table_data;
	}

	public static function set_filter_non_public_data( $data ) {
		if ( empty( $data ) ) {
			return $data;
		}

		$new_data = array();

		foreach ( $data as $json_data ) {
			if ( empty( $json_data ) || empty( $json_data['IsPublic'] ) ) {
				continue;
			}

			if ( $json_data['IsPublic'] === false ) {
				continue;
			}

			$new_data[] = $json_data;
		}

		return $new_data;
	}

	public static function set_has_past_event( $column_data ) {
		if ( empty( $column_data ) ) {
			return false;
		}

		$has_past_events = false;

		foreach ( $column_data as $column_title => $column_single_data ) {
			if ( $column_single_data['hide_past_events'] ) {
				$has_past_events = static::set_check_data_for_past_events( $column_single_data['column_value'], $column_title );

				if ( $has_past_events ) {
					break;
				}
			}
		}

		return $has_past_events;
	}

	public static function set_check_data_for_past_events( $column_value, $column_title ) {
		if ( empty( $column_title ) || empty( $column_value ) ) {
			return false;
		}
		if ( ! preg_match( '~End\s?Time~i', $column_title ) ) {
			return false;
		}

		$date_timestamp = strtotime( $column_value );

		if ( empty( $date_timestamp ) ) {
			return false;
		}

		if ( time() > $date_timestamp ) {
			return true;
		}
	}

	public static function set_format_time( $column_value, $column_title, $days_forward ) {
		if ( empty( $column_title ) || empty( $column_value ) || empty( $days_forward ) ) {
			return $column_value;
		}

		if ( preg_match( '~Time~i', $column_title ) ) {
			$time = explode( ' ', $column_value );
			if ( empty( $time[1] ) ) {
				return $column_value;
			}


			$date_timestamp = strtotime( $time[0] );
			$current_date_timestamp = strtotime( date( 'm/d/Y', strtotime( '+' . $days_forward . ' day' ) ) );

			if ( empty( $date_timestamp ) ) {
				return $column_value;
			}

			if ( $date_timestamp < $current_date_timestamp ) {
				array_shift( $time );
				$column_value = implode( ' ', $time );
			}
		}

		return $column_value;
	}

	public static function set_get_column_options_test() {
		$first_json_data = static::set_get_table_json_data( null, true )[0];

		if ( empty( $first_json_data ) ) {
			return array(
				__( 'None', 'set' ),
			);
		}

		$data_fields = array();

		foreach ( $first_json_data as $first_json_data_name => $first_json_data_value ) {
			if ( is_array( $first_json_data_value ) ) {
				continue;
			}

			$data_fields[ $first_json_data_name ] = $first_json_data_name;
		}

		return $data_fields;
	}

	public static function set_column_table_head( $defaults ) {
		$defaults['table_shortcode'] = __( 'Table Shortcode', 'crb' );

		return $defaults;
	}

	public static function set_column_table_html( $column_name, $post_ID ) {
		if ( $column_name === 'table_shortcode' ) {
			echo '<code>[simple-espace-table id="' . $post_ID . '"]</code>';
		}
	}

	public static function set_trim_text( $text, $length, $sep = '<br />' ) {
		if ( empty( $text ) ) {
			return '';
		}

		if ( ! empty( $length ) && is_numeric( $length ) ) {
			$length = intval( $length );
		} else {
			$length = 10;
		}

		$text = preg_replace( '~<.*?>|[<>!@#$%^&*]*~', '', $text );

		$wrap_texts = preg_split( '~[\r\n\t ]+~', $text );
		$new_wrap_texts = array();
		$text_index = 0;
		$str_container = '';


		foreach ( $wrap_texts as $wrap_text ) {
			if ( $text_index === $length ) {
				$new_wrap_texts[] = $str_container;
				$text_index = 0;
				$str_container = '';
			}

			$str_container .= $wrap_text . ' ';
			$text_index++;
		}

		$new_wrap_texts[] = $str_container;

		return implode( $sep, $new_wrap_texts );
	}

	public static function get_popup_title_options() {
		return [
			'description_title' => carbon_get_theme_option('crb_espace_popup_description_title'),
			'date_and_time_title' => carbon_get_theme_option('crb_espace_popup_date_and_time_title'),
			'location_title' => carbon_get_theme_option('crb_espace_popup_location_title'),
			'event_contact_title' => carbon_get_theme_option('crb_espace_popup_event_contact_title'),
			'share_with_friends_title' => carbon_get_theme_option('crb_espace_popup_share_with_friends_title'),
		];
	}

	public static function get_popup_hide_sections_options() {
		return [
			'hide_title' => carbon_get_theme_option('crb_espace_popup_hide_title'),
			'hide_description' => carbon_get_theme_option('crb_espace_popup_hide_description'),
			'hide_date_and_time' => carbon_get_theme_option('crb_espace_popup_hide_date_and_time'),
			'hide_location' => carbon_get_theme_option('crb_espace_popup_hide_location'),
			'hide_event_contact' => carbon_get_theme_option('crb_espace_popup_hide_event_contact'),
			'hide_share_with_friends' => carbon_get_theme_option('crb_espace_popup_hide_share_with_friends'),
		];
	}
}

?>