<?php

/**
 * Setup Visual Composer plugin.
 */
function stylish_setup_visual_composer() {
	vc_set_shortcodes_templates_dir( get_template_directory() . '/vc_templates/' );
	vc_set_as_theme( true );
	
	vc_add_param( 'vc_row', array(
		'type'       => 'checkbox',
		'heading'    => __( 'Contain Elements', 'stylish' ),
		'param_name' => 'container',
		'value'      => array( __( 'Wrap elements inside a fixed-width container', 'stylish' ) => true ),
		'std'        => true,
	) );
	
	vc_map_update( 'vc_separator', array(
		'show_settings_on_create' => false,
		'params' => array(),
	) );
	
	vc_map( array(
		'name' => __( 'Headline', 'stylish' ),
		'base' => 'kidix_headline',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A headline with description for your page sections.', 'stylish' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'stylish' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Description', 'stylish' ),
				'param_name' => 'description',
			),
		)
	) );
	
	vc_map( array(
		'name' => __( 'Header Group', 'stylish' ),
		'base' => 'kidix_header_group',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A group of headings to style your headlines.', 'stylish' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'First Heading', 'stylish' ),
				'param_name' => 'first_heading',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Second Heading', 'stylish' ),
				'param_name' => 'second_heading',
			),
		)
	) );
	
	vc_map( array(
		'name' => __( 'Header Intro', 'stylish' ),
		'base' => 'kidix_header_intro',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A nice intro of headings with scroll animation.', 'stylish' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'First Heading', 'stylish' ),
				'param_name' => 'first_heading',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Second Heading', 'stylish' ),
				'param_name' => 'second_heading',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Third Heading', 'stylish' ),
				'param_name' => 'third_heading',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Animation', 'stylish' ),
				'param_name' => 'animate',
				'value'      => array( __( 'Animate on scroll', 'stylish' ) => false ),
				'std'        => false,
			),
		)
	) );
	
	$grid_cols_list = array(
		//__( '12 items per row') => 1,
		array( 'label' => "6", 'value' => 2 ),
		array( 'label' => "4", 'value' => 3 ),
		array( 'label' => "3", 'value' => 4 ),
		array( 'label' => "2", 'value' => 6 ),
		array( 'label' => "1", 'value' => 12 ),
	);
	
	$choices = array();
	$teachers = new WP_Query( array( 'post_type' => 'class', 'posts_per_page' => -1 ) );
	while( $teachers->have_posts() ) {
		$teachers->the_post();
		$choices[ get_the_title() ] = get_the_ID();
	}
	
	vc_map( array(
		'name' => __( 'Classes Grid', 'stylish' ),
		'base' => 'kidix_classes_grid',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A grid of class posts.', 'stylish' ),
		'params' => array(
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Classes', 'stylish' ),
				'param_name' => 'classes',
				'value'      => $choices,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Columns', 'stylish' ),
				'param_name' => 'grid_columns',
				'value'      => $grid_cols_list,
			),
		)
	) );
	
	$choices = array();
	$teachers = new WP_Query( array( 'post_type' => 'staff', 'posts_per_page' => -1 ) );
	while( $teachers->have_posts() ) {
		$teachers->the_post();
		$choices[ get_the_title() ] = get_the_ID();
	}
	
	vc_map( array(
		'name' => __( 'Staff Grid', 'stylish' ),
		'base' => 'kidix_teachers_grid',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A grid of staff posts.', 'stylish' ),
		'params' => array(
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Staff', 'stylish' ),
				'param_name' => 'staff',
				'value'      => $choices,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Columns', 'stylish' ),
				'param_name' => 'grid_columns',
				'value'      => $grid_cols_list,
			),
		)
	) );
	
	vc_map( array(
		'name' => __( 'Google Map', 'stylish' ),
		'base' => 'kidix_google_map',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A Google Map with set coordinates.', 'stylish' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'stylish' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Latitude', 'stylish' ),
				'param_name' => 'latitude',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Longitude', 'stylish' ),
				'param_name' => 'longitude',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Zoom', 'stylish' ),
				'param_name' => 'zoom',
				'value'      => array( 8, 10, 12, 14, 16 ),
			),
		)
	) );

	vc_map( array(
		'name' => __( 'Fullwidth Gallery', 'stylish' ),
		'base' => 'kidix_fullwidth_gallery',
		'icon' => 'icon-wpb-application-icon-large',
		'category' => __( 'Chess4Life Shortcodes', 'stylish' ),
		'description' => __( 'A fullwidth gallery with images.', 'stylish' ),
		'params' => array(
			array(
				'type' => 'attach_images',
				'heading' => __( 'Images', 'stylish' ),
				'param_name' => 'images',
				'value' => '',
				'description' => __( 'Select images from media library.', 'stylish' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Button Text', 'stylish' ),
				'param_name' => 'button_text',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Button URL', 'stylish' ),
				'param_name' => 'button_url',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom class', 'stylish' ),
				'param_name' => 'el_class',
			),
		)
	) );
}
add_action( 'vc_before_init', 'stylish_setup_visual_composer' );