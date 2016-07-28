<?php

/**
 * Default customizer options for Kidix theme.
 *
 * @return array
 */
function stylish_default_theme_settings() {
	return array(
		'ajax_load'         => true,
		'border_wave'       => true,
		'custom_css'        => '',
		'site_logo_default' => get_template_directory_uri() . '/images/logo.png',
		'site_logo_inverse' => get_template_directory_uri() . '/images/logo-inverse.png',
		'class_layout'      => 'full-width',
		'teacher_layout'    => 'full-width',
		'album_layout'      => 'full-width',
		'phone_number'      => '',
		'contact_address'   => '',
		'headings_font'     => 'Gotham Rounded',
		'text_font'         => 'Gotham Rounded',
		'accent_font'       => 'Pacifico',
		'headings_color'    => '#2c3848',
		'text_color'        => '#5b5b5b',
		'link_color'        => '#0499db',
		'accent_color'      => '#f28705',
	);
}

/**
 * Filter theme mods with default valuw when they are not set in database.
 */
function stylish_set_default_theme_settings( $mod ) {
	global $stylish_mods;
	
	// Cache theme mods array
	if( ! isset( $stylish_mods ) ) {
		$stylish_mods = get_theme_mods();
	}
	
	$defaults = stylish_default_theme_settings();
	$name = str_replace( 'theme_mod_', '', current_filter() );
	
	// No value in database, retrieve from default array
	if( ! isset( $stylish_mods[$name] ) ) {
		$mod = $defaults[$name];
	}
	
	return $mod;
}

/**
 * Set default settings filter for each theme mod.
 */
function stylish_set_default_theme_settings_filter() {
	$mods = stylish_default_theme_settings();
	foreach( $mods as $mod => $value ) {
		add_filter( "theme_mod_{$mod}", 'stylish_set_default_theme_settings' );
	}
}
add_action( 'init', 'stylish_set_default_theme_settings_filter' );

function stylish_custom_controls() {
	class stylish_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		
		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
}
add_action( 'customize_register', 'stylish_custom_controls' );

/**
 * Customizer settings, sections and controls.
 */
function stylish_customize_register( $wp_customize ) {
	$defaults = stylish_default_theme_settings();
	$cap      = 'edit_theme_options';
	$type     = 'theme_mod';
	$fonts    = stylish_custom_fonts();
	$choices  = array();
	
	foreach( $fonts as $font => $args ) {
		$args['family'] = str_replace( '"', '', $args['family'] );
		$choices[ $font ] = sprintf( '%1$s, %2$s', $args['family'], $args['category'] );
	}
	
	$wp_customize->add_setting( 'ajax_load', array(
		'default'           => $defaults['ajax_load'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_checkbox',
	) );
	$wp_customize->add_setting( 'border_wave', array(
		'default'           => $defaults['border_wave'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_checkbox',
	) );
	$wp_customize->add_setting( 'custom_css', array(
		'default'           => $defaults['custom_css'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'site_logo_default', array(
		'default'           => $defaults['site_logo_default'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_setting( 'site_logo_inverse', array(
		'default'           => $defaults['site_logo_inverse'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_setting( 'class_layout', array(
		'default'           => $defaults['class_layout'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_layout',
	) );
	$wp_customize->add_setting( 'teacher_layout', array(
		'default'           => $defaults['teacher_layout'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_layout',
	) );
	$wp_customize->add_setting( 'album_layout', array(
		'default'           => $defaults['album_layout'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_layout',
	) );
	$wp_customize->add_setting( 'phone_number', array(
		'default'           => $defaults['phone_number'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'contact_address', array(
		'default'           => $defaults['contact_address'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'headings_font', array(
		'default'           => $defaults['headings_font'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_font',
	) );
	$wp_customize->add_setting( 'text_font', array(
		'default'           => $defaults['text_font'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_font',
	) );
	$wp_customize->add_setting( 'accent_font', array(
		'default'           => $defaults['accent_font'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'stylish_sanitize_font',
	) );
	$wp_customize->add_setting( 'headings_color', array(
		'default'           => $defaults['headings_color'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_setting( 'text_color', array(
		'default'           => $defaults['text_color'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_setting( 'link_color', array(
		'default'           => $defaults['link_color'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_setting( 'accent_color', array(
		'default'           => $defaults['accent_color'],
		'type'              => $type,
		'capability'        => $cap,
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_section( 'general_options', array(
		'title'          => __( 'General Options', 'stylish' ),
		'priority'       => 35,
	) );
	$wp_customize->add_section( 'header_options', array(
		'title'          => __( 'Header Options', 'stylish' ),
		'priority'       => 35,
	) );
	$wp_customize->add_section( 'layout_options', array(
		'title'          => __( 'Layout Options', 'stylish' ),
		'priority'       => 35,
	) );
	$wp_customize->add_section( 'footer_options', array(
		'title'          => __( 'Footer Options', 'stylish' ),
		'priority'       => 35,
	) );
	$wp_customize->add_section( 'font_options', array(
		'title'          => __( 'Fonts', 'stylish' ),
		'priority'       => 35,
	) );
	
	$wp_customize->add_control( 'ajax_load', array(
		'label'      => __( 'Load internal links with AJAX', 'stylish' ),
		'section'    => 'general_options',
		'type'       => 'checkbox',
		'settings'   => 'ajax_load',
	) );
	$wp_customize->add_control( 'border_wave', array(
		'label'      => __( 'Add a waved border around sections', 'stylish' ),
		'section'    => 'general_options',
		'type'       => 'checkbox',
		'settings'   => 'border_wave',
	) );
	$wp_customize->add_control( new stylish_Customize_Textarea_Control( $wp_customize, 'custom_css', array(
		'label'      => __( 'Custom CSS', 'stylish' ),
		'section'    => 'general_options',
		'settings'   => 'custom_css',
	) ) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'site_logo_default', array(
		'label'      => __( 'Light Site Logo', 'stylish' ),
		'section'    => 'header_options',
		'settings'   => 'site_logo_default',
	) ) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'site_logo_inverse', array(
		'label'      => __( 'Dark Site Logo', 'stylish' ),
		'section'    => 'header_options',
		'settings'   => 'site_logo_inverse',
	) ) );
	$wp_customize->add_control( 'class_layout', array(
		'label'      => __( 'Class Archive Layout', 'stylish' ),
		'section'    => 'layout_options',
		'type'       => 'radio',
		'choices'    => array(
							'full-width' => __( 'Full Width', 'stylish' ),
							'content-sidebar' => __( 'Content / Sidebar', 'stylish' ),
						),
		'settings'   => 'class_layout',
	) );
	$wp_customize->add_control( 'teacher_layout', array(
		'label'      => __( 'Teacher Archive Layout', 'stylish' ),
		'section'    => 'layout_options',
		'type'       => 'radio',
		'choices'    => array(
							'full-width' => __( 'Full Width', 'stylish' ),
							'content-sidebar' => __( 'Content / Sidebar', 'stylish' ),
						),
		'settings'   => 'teacher_layout',
	) );
	$wp_customize->add_control( 'album_layout', array(
		'label'      => __( 'Album Archive Layout', 'stylish' ),
		'section'    => 'layout_options',
		'type'       => 'radio',
		'choices'    => array(
							'full-width' => __( 'Full Width', 'stylish' ),
							'content-sidebar' => __( 'Content / Sidebar', 'stylish' ),
						),
		'settings'   => 'album_layout',
	) );
	$wp_customize->add_control( 'phone_number', array(
		'label'      => __( 'Phone Number', 'stylish' ),
		'section'    => 'footer_options',
		'settings'   => 'phone_number',
	) );
	$wp_customize->add_control( 'contact_address', array(
		'label'      => __( 'Contact Address', 'stylish' ),
		'section'    => 'footer_options',
		'settings'   => 'contact_address',
	) );
	$wp_customize->add_control( 'headings_font', array(
		'label'      => __( 'Headings Font', 'stylish' ),
		'section'    => 'font_options',
		'type'       => 'select',
		'choices'    => $choices,
		'settings'   => 'headings_font',
	) );
	$wp_customize->add_control( 'text_font', array(
		'label'      => __( 'Text Font', 'stylish' ),
		'section'    => 'font_options',
		'type'       => 'select',
		'choices'    => $choices,
		'settings'   => 'text_font',
	) );
	$wp_customize->add_control( 'accent_font', array(
		'label'      => __( 'Accent Font', 'stylish' ),
		'section'    => 'font_options',
		'type'       => 'select',
		'choices'    => $choices,
		'settings'   => 'accent_font',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headings_color', array(
		'label'      => __( 'Headings Color', 'stylish' ),
		'section'    => 'colors',
		'settings'   => 'headings_color',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'label'      => __( 'Text Color', 'stylish' ),
		'section'    => 'colors',
		'settings'   => 'text_color',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'      => __( 'Link Color', 'stylish' ),
		'section'    => 'colors',
		'settings'   => 'link_color',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
		'label'      => __( 'Accent Color', 'stylish' ),
		'section'    => 'colors',
		'settings'   => 'accent_color',
	) ) );
}
add_action( 'customize_register', 'stylish_customize_register' );

/**
 * Sanitize checkbox inputs.
 */
function stylish_sanitize_checkbox( $input ) {
	return (bool) $input;
}

/**
 * Sanitize layout inputs.
 */
function stylish_sanitize_layout( $input ) {
	if( 'content-sidebar' == $input ) {
		return $input;
	}
	
	return 'full-width';
}

/**
 * Sanitize font inputs.
 */
function stylish_sanitize_font( $input ) {
	if( ! array_key_exists( $input, stylish_custom_fonts() ) ) {
		return 'Gotham Rounded';
	}
	
	return $input;
}