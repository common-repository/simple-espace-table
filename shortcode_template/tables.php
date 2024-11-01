<?php

if ( empty( $table_id ) ) {
	return;
}

$tables_query = new WP_Query( array(
	'post_type' => 'crb_table',
	'posts_per_page' => -1,
	'post__in' => array( $table_id ),
) );

if ( ! $tables_query->have_posts() ) {
	return;
}

// Get Table json Data
$table_data = \Espace\SetTable::set_get_table_json_data( $table_id );

$image_url = wp_get_attachment_url( carbon_get_post_meta( $table_id, 'crb_table_image' ) );

if ( empty( $image_url ) ) {
	$image_url = SIMPLE_ESPACE_TABLE_PLUGIN_URL . '/images/logo.png';
}

$column_options = carbon_get_post_meta( $table_id, 'crb_columns' );


$table_image_hide = carbon_get_post_meta( $table_id, 'crb_table_image_hide' );
$hide_header = carbon_get_post_meta( $table_id, 'crb_hide_header' );

?>

<div class="section section-table" id="table_id-<?php echo $table_id; ?>" v-cloak>
	<div class="table table-events">
		<?php if ( ! $hide_header ) : ?>
			<div class="table__head">
				<?php if ( ! $table_image_hide ) : ?>
					<a href="<?php echo esc_url( home_url() ); ?>">
						<h2>
							<img src="<?php echo esc_url( $image_url ); ?>" alt="">
						</h2>
					</a>
				<?php endif; ?>

				<div class="clock"></div><!-- /.clock -->
			</div><!-- /.table__head -->
		<?php endif; ?>

		<div class="table__body">
			<div class="table__wrapper">
				<div class="table__wrapper-head">
					<table>
						<thead>
							<tr>
								<?php foreach ( $column_options as $column_option ) : ?>
									<th style="width: <?php echo $column_option['column_width']; ?>%; font-size: <?php echo $column_option['title_font_size'];  ?>px;">
										<?php echo esc_html( $column_option['column_title'] ); ?>
									</th>
								<?php endforeach; ?>
							</tr>
						</thead>
					</table>
				</div><!-- /.table__wrapper-head -->
				
				<?php 
				\Espace\FragmentsLoader::loadFragment('table-component.php', true, [
					'table_id' => $table_id,
					'column_options' => $column_options,
					'table_data' => $table_data,
				]); 
				?>
			</div><!-- /.table__wrapper -->
		</div><!-- /.table__body -->
	</div><!-- /.table -->
</div><!-- /.section -->

<?php include( SIMPLE_ESPACE_TABLE_PLUGIN_DIR . '/fragments/custom_styles.php' );