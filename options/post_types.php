<?php
register_post_type( 'crb_table', array(
	'labels' => array(
		'name' => __( 'Tables', 'crb' ),
		'singular_name' => __( 'Table', 'crb' ),
		'add_new' => __( 'Add New', 'crb' ),
		'add_new_item' => __( 'Add new Table', 'crb' ),
		'view_item' => __( 'View Table', 'crb' ),
		'edit_item' => __( 'Edit Table', 'crb' ),
		'new_item' => __( 'New Table', 'crb' ),
		'view_item' => __( 'View Table', 'crb' ),
		'search_items' => __( 'Search Tables', 'crb' ),
		'not_found' =>  __( 'No Tables found', 'crb' ),
		'not_found_in_trash' => __( 'No Tables found in trash', 'crb' ),
	),
	'public' => false,
	'exclude_from_search' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'_edit_link' => 'post.php?post=%d',
	'rewrite' => array(
		'slug' => 'the_tables',
		'with_front' => false,
	),
	'query_var' => true,
	'menu_icon' => 'dashicons-editor-insertmore',
	'supports' => array( 'title' ),
));

