<?php
if (empty($table_id)) {
	return;
}

$column_datas = [];
$table_speed_multiplicator = carbon_get_post_meta( $table_id, 'crb_table_speed_multiplicator' );
$table_seconds_pause = carbon_get_post_meta( $table_id, 'crb_table_seconds_pause' );

if ( empty( $table_speed_multiplicator ) || ! is_numeric( $table_speed_multiplicator ) ) {
	$table_speed_multiplicator = 17;
}

if ( empty( $table_seconds_pause ) || ! is_numeric( $table_seconds_pause ) ) {
	$table_seconds_pause = 1;
}

$table_seconds_pause *= 1000;

// loop through all data and get data that is only needed
foreach ( $table_data as $table_dat ) {
	$column_data = array();
	foreach ( $column_options as $column_option ) {
		$column_data[ $column_option['column_title'] ] = array(
			'column_value' => $table_dat[ $column_option['column_type'] ],
			'column_width' => $column_option['column_width'],
			'max_words_on_line' => $column_option['max_words_on_line'],
			'wrap_text' => $column_option['wrap_text'],
			'forward_days_to_hide_date' => $column_option['forward_days_to_hide_date'],
			'hide_past_events' => $column_option['hide_past_events'],
			'title_font_size' => $column_option['title_font_size'],
			'column_font_size' => $column_option['column_font_size'],
			'column_type' => $column_option['column_type'],
		);

		$column_data['table_data_id'] = $table_dat['table_data_id'];
	}

	if ( ! empty( $column_data ) ) {
		$column_datas[] = $column_data;
	}
}

$column_datas = array_filter( $column_datas );


if ( empty( $column_datas ) ) {
	return;
}

$JSON_ESCAPE_TAGS = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;
?>

<espace-table-component table_data='<?php echo json_encode($table_data, $JSON_ESCAPE_TAGS); ?>' inline-template>
	<div class="table__wrapper-body" data-table_speed_multiplicator="<?php echo $table_speed_multiplicator; ?>" data-seconds_pause="<?php echo $table_seconds_pause; ?>">
		<table>
			<tbody>
				<?php foreach ( $column_datas as $column_data ) : ?>
					<?php
						if ( \Espace\SetTable::set_has_past_event( $column_data ) ) {
							continue;
						}

					?>
					<tr @click="openTableDataPopup('<?php echo $column_data['table_data_id']; ?>')">
						<?php foreach ( $column_data as $column_title => $column_single_data ) : ?>
							<?php
							if ($column_title === 'table_data_id') {
								continue;
							}

							$column_value = $column_single_data['column_value'];
							?>
							<td data-title="<?php echo esc_html( $column_title ); ?>" style="width: <?php echo $column_single_data['column_width']; ?>%; font-size: <?php echo $column_single_data['column_font_size'] ?>px;">
								<?php
								$max_words_on_line = $column_single_data['max_words_on_line'];

								if ( empty( $max_words_on_line ) || ! is_numeric( $max_words_on_line ) ) {
									$max_words_on_line = 2;
								}

								if ( ! empty( $column_single_data['forward_days_to_hide_date'] ) ) {
									$column_value = \Espace\SetTable::set_format_time( $column_value, $column_single_data['column_type'], $column_single_data['forward_days_to_hide_date'] );
								}

								if ( $column_single_data['wrap_text'] ) {
									echo esc_html( wp_trim_words( $column_value, $max_words_on_line, '' ) );
								} else {
									echo esc_html( $column_value );
								}
								?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div><!-- /.table__wrapper-body -->
</espace-table-component>

<?php
\Espace\FragmentsLoader::loadFragment('table-popup.php');
?>

