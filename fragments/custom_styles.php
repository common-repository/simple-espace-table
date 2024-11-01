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

$data = array(
	'table_head_background_color' => carbon_get_post_meta( $table_id, 'crb_table_head_background_color' ),
	'table_first_title_color' => carbon_get_post_meta( $table_id, 'crb_table_first_title_color' ),
	'table_title_color' => carbon_get_post_meta( $table_id, 'crb_table_title_color' ),
	'table_first_column_background_color' => carbon_get_post_meta( $table_id, 'crb_table_first_column_background_color' ),
	'table_column_background_color' => carbon_get_post_meta( $table_id, 'crb_table_column_background_color' ),
	'table_first_column_text_color' => carbon_get_post_meta( $table_id, 'crb_table_first_column_text_color' ),
	'table_column_text_color' => carbon_get_post_meta( $table_id, 'crb_table_column_text_color' ),
	'table_first_column_line_color' => carbon_get_post_meta( $table_id, 'crb_table_first_column_line_color' ),
	'table_column_line_color' => carbon_get_post_meta( $table_id, 'crb_table_column_line_color' ),
	'table_title_font_size' => carbon_get_post_meta( $table_id, 'crb_table_title_font_size' ),
	'table_body_font_size' => carbon_get_post_meta( $table_id, 'crb_table_body_font_size' ),
);

$table_full_height = carbon_get_post_meta( $table_id, 'crb_set_table_full_height' );
$table_height = '100vh';

if ( ! $table_full_height ) {
	$table_height_theme = carbon_get_post_meta( $table_id, 'crb_table_height' );

	if ( ! empty( $table_height_theme ) && is_numeric( $table_height_theme ) ) {
		$table_height = $table_height_theme . 'px';
	}	
}

$table_full_width = carbon_get_post_meta( $table_id, 'crb_set_table_full_width' );
$table_width = '100vw';

if ( ! $table_full_width ) {
	$table_width_theme = carbon_get_post_meta( $table_id, 'crb_table_width' );

	if ( ! empty( $table_width_theme ) && is_numeric( $table_width_theme ) ) {
		$table_width = $table_width_theme . 'px';
	}	
}

$table_first_column_line_size_px = carbon_get_post_meta( $table_id, 'crb_table_first_column_line_size' );
$table_column_line_size_px = carbon_get_post_meta( $table_id, 'crb_table_column_line_size' );

if ( empty( $table_first_column_line_size_px ) ) {
	$table_first_column_line_size_px = 1;
}

if ( empty( $table_column_line_size_px ) ) {
	$table_column_line_size_px = 1;
}

?>

<style type="text/css" media="screen">

	#table_id-<?php echo $table_id; ?> .table.table-events { width: <?php echo $table_width; ?> !important; height: <?php echo $table_height; ?> !important; }

	#table_id-<?php echo $table_id; ?> .table.table-events .table__head { background-color: <?php echo $data['table_head_background_color']; ?> !important; }

	#table_id-<?php echo $table_id; ?> .table-events table th:first-child { background-color: <?php echo $data['table_first_column_background_color']; ?> !important; color: <?php echo $data['table_first_title_color'] ?> !important; }

	#table_id-<?php echo $table_id; ?> .table-events table th { background-color: <?php echo $data['table_column_background_color']; ?> !important; color: <?php echo $data['table_title_color'] ?> !important; font-size: <?php echo $data['table_title_font_size']; ?>px; }

	#table_id-<?php echo $table_id; ?> .table-events table td:first-child { background-color: <?php echo $data['table_first_column_background_color']; ?> !important; color: <?php echo $data['table_first_column_text_color'] ?> !important; border-bottom: <?php echo $table_first_column_line_size_px; ?>px solid <?php echo $data['table_first_column_line_color']; ?> !important; }

	#table_id-<?php echo $table_id; ?> .table-events table td { background-color: <?php echo $data['table_column_background_color']; ?> !important; color: <?php echo $data['table_column_text_color'] ?> !important; border-bottom: <?php echo $table_column_line_size_px; ?>px solid <?php echo $data['table_column_line_color']; ?> !important; font-size: <?php echo $data['table_body_font_size']; ?>px; }
	
</style>