<?php

/**
 * Register all post types
 */
add_action( 'init', 'register_post_types' );
function register_post_types() {
	/**
	 * Register hmd_lecture post
	 */
	register_post_type( 'hmd_lecture', array(
		'label'               => null,
		'labels'              => array(
			'name'               => 'Lectures',
			'singular_name'      => 'Lectures',
			'add_new'            => 'Add Lecture',
			'add_new_item'       => 'Add Lecture',
			'edit_item'          => 'Edit Lecture',
			'new_item'           => 'New Lecture',
			'view_item'          => 'View Lecture',
			'search_items'       => 'Search Lectures',
			'not_found'          => 'Not found',
			'not_found_in_trash' => 'Not found in trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Lectures',
		),
		'description'         => 'Lectures for your customers',
		'public'              => true,
		'has_archive'         => true,
		'publicaly_queryable' => true,
		'query_var'           => false,
		'show_in_rest'        => true,
		'rest_base'           => null,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'show_in_nav_menus'   => true,
		'rewrite'             => array( 'slug' => 'lectures' ),
	) );

}


add_action( 'init', 'register_post_taxonomies' );
function register_post_taxonomies() {
	/* Register hmd_lecturers taxonomy */
	register_taxonomy( 'hmd_lecturer', 'hmd_lecture', array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => 'Lecturers',
			'singular_name'     => 'Lecturers',
			'search_items'      => 'Search lecturers',
			'all_items'         => 'All lecturers',
			'parent_item'       => 'Parent lecturer',
			'parent_item_colon' => 'Parent lecturer:',
			'edit_item'         => 'Edit lecturer',
			'update_item'       => 'Update lecturer',
			'add_new_item'      => 'Add new lecturer',
			'new_item_name'     => 'New lecturer',
			'menu_name'         => 'Lecturers',
		),
		'show_ui'           => true,
		'show_in_menu'      => true,
		'show_in_rest'      => true,
		'rest_base'         => 'hmd_lecturers',
		'query_var'         => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'lecturers' ),
	) );
}






