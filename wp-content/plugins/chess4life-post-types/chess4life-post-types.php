<?php

/*
 * Plugin Name: Chess4Life Custom Post Types
 * Author: Sayenko Design
 * Version: 1.0

 * Plugin URI: http://sayenkodesign.com
 * Description: This is a plugin for custom post types

 * Author URI: http://sayenkodesign.com

 * Author URI: http://sayenkodesign.com/
 * License: GPL v2
**/

add_action( 'init', 'chess4life_register_post_types', 0 );

function chess4life_register_post_types() {
	register_post_type( 'staff',
		array(
			'label' => __( 'Staff', 'chess4life' ),
			'labels' => array(
				'name' => __( 'Staff', 'chess4life' ),
				'singular_name' => __( 'Staff', 'chess4life' ),
				'all_items' => __( 'All Staff', 'chess4life' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'rewrite' => array(
				'slug' => 'staff',
				'with_front' => false
			),
		)
	);
	
	/*register_post_type( 'album',
		array(
			'label' => __( 'Album', 'chess4life' ),
			'labels' => array(
				'name' => __( 'Albums', 'chess4life' ),
				'singular_name' => __( 'Album', 'chess4life' ),
				'all_items' => __( 'All Albums', 'chess4life' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'rewrite' => array(
				'slug' => 'album',
				'with_front' => false
			),
		)
	); */
	
	/* register_post_type( 'class',
		array(
			'label' => __( 'Class', 'chess4life' ),
			'labels' => array(
				'name' => __( 'Classes', 'chess4life' ),
				'singular_name' => __( 'Class', 'chess4life' ),
				'all_items' => __( 'All Classes', 'chess4life' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
			'rewrite' => array(
				'slug' => 'class',
				'with_front' => false
			),
		)
	); */
}


add_action( 'init', 'chess4life_register_taxonomies', 0 );

function chess4life_register_taxonomies() {
	register_taxonomy( 'staff-type', 'staff', array(
		'label'             => 'Staff Type',
		'labels'            => array(
			'name'              => __( 'Staff Types', 'chess4life' ),
			'singular_name'     => __( 'Staff Type', 'chess4life' ),
			'search_items'      => __( 'Search Staff Types', 'chess4life' ),
			'all_items'         => __( 'All Staff Types', 'chess4life' ),
			'edit_item'         => __( 'Edit Staff Type', 'chess4life' ),
			'update_item'       => __( 'Update Staff Type', 'chess4life' ),
			'add_new_item'      => __( 'Add New Staff Type', 'chess4life' ),
			'new_item_name'     => __( 'New Staff Type Name', 'chess4life' ),
			'menu_name'         => __( 'Staff Types', 'chess4life' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
	) );
	
	register_taxonomy( 'class-type', 'class', array(
		'label'             => 'Class Type',
		'labels'            => array(
			'name'              => __( 'Class Types', 'chess4life' ),
			'singular_name'     => __( 'Class Type', 'chess4life' ),
			'search_items'      => __( 'Search Class Types', 'chess4life' ),
			'all_items'         => __( 'All Class Types', 'chess4life' ),
			'edit_item'         => __( 'Edit Class Type', 'chess4life' ),
			'update_item'       => __( 'Update Class Type', 'chess4life' ),
			'add_new_item'      => __( 'Add New Class Type', 'chess4life' ),
			'new_item_name'     => __( 'New Class Type Name', 'chess4life' ),
			'menu_name'         => __( 'Class Types', 'chess4life' ),
		),
		'hierarchical'      => false,
		'show_ui'           => true,
	) );
}

/* register_taxonomy( 'teacher-type', 'teacher', array(
		'label'             => 'Teacher Type',
		'labels'            => array(
			'name'              => __( 'Teacher Types', 'chess4life' ),
			'singular_name'     => __( 'Teacher Type', 'chess4life' ),
			'search_items'      => __( 'Search Teacher Types', 'chess4life' ),
			'all_items'         => __( 'All Teacher Types', 'chess4life' ),
			'edit_item'         => __( 'Edit Teacher Type', 'chess4life' ),
			'update_item'       => __( 'Update Teacher Type', 'chess4life' ),
			'add_new_item'      => __( 'Add New Teacher Type', 'chess4life' ),
			'new_item_name'     => __( 'New Teacher Type Name', 'chess4life' ),
			'menu_name'         => __( 'Staff Types', 'chess4life' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
	) ); */