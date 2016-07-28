<?php
/**
 * Chess4Life functions and definitions
 *
 */

if ( ! function_exists( 'stylish_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function stylish_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change 'stylish' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'stylish', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'stylish-blog-thumb', 634, 423, true );
	add_image_size( 'stylish-single-thumb', 1192, 628, true );
	add_image_size( 'stylish-teacher-thumb', 350, 350, true );
	add_image_size( 'stylish-album-thumb', 350, 234, true );
	add_image_size( 'stylish-class-thumb', 350, 234, true );
	add_image_size( 'stylish-preview-cover', 266, 266, true );
	add_image_size( 'stylish-carousel-thumb', 480, 480, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'stylish' ),
		'secondary' => esc_html__( 'Footer Menu', 'stylish' ),
		'social'    => esc_html__( 'Social Menu', 'stylish' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'stylish_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // stylish_setup
add_action( 'after_setup_theme', 'stylish_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function stylish_content_width() {
	global $content_width;
	$content_width = apply_filters( 'stylish_content_width', 920 );
}
add_action( 'after_setup_theme', 'stylish_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function stylish_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'stylish' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar', 'stylish' ),
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'stylish_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function stylish_scripts() {
	$deps = array( 'bootstrap', 'fontawesome', 'flexslider', 'fluidbox' );
	$web_fonts_style = stylish_web_fonts_style();
	if( false !== $web_fonts_style ) {
		$deps[] = 'google-fonts';
	}
	if( function_exists( 'vc_map' ) ) {
		$deps[] = 'js_composer_front';
	}
	wp_enqueue_style( 'google-fonts', $web_fonts_style, false, null );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, null );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, null );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', false, null );
	wp_enqueue_style( 'fluidbox', get_template_directory_uri() . '/css/fluidbox.css', false, null );
	wp_enqueue_style( 'stylish', get_stylesheet_uri(), $deps, null );
	
	$custom_css = apply_filters( 'stylish_custom_css', '' );
	if( ! empty( $custom_css ) ) {
		/* Sanitize Custom CSS */
		$custom_css = strip_tags( $custom_css );
		$custom_css = str_replace( 'behavior',   '', $custom_css );
		$custom_css = str_replace( 'expression', '', $custom_css );
		$custom_css = str_replace( 'binding',    '', $custom_css );
		$custom_css = str_replace( '@import',    '', $custom_css );
		
		/* Print Custom CSS after default Stylesheet */
		wp_add_inline_style( 'stylish', $custom_css );
	}
	
	wp_enqueue_script( 'google-maps-api', 'http://maps.googleapis.com/maps/api/js', array( 'jquery' ), null );
	wp_enqueue_script( 'waitforimages', get_template_directory_uri() . '/js/jquery.waitforimages.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'stylishparallax', get_template_directory_uri() . '/js/jquery.stylishparallax.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'fluidbox', get_template_directory_uri() . '/js/jquery.fluidbox.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'wpb_composer_front_js' );
	if( function_exists( 'vc_asset_url' ) ) {
		wp_enqueue_script( 'vc_jquery_skrollr_js', vc_asset_url( 'lib/bower/skrollr/dist/skrollr.min.js' ), array( 'jquery' ), null, true );
	}
	wp_enqueue_script( 'stylish', get_template_directory_uri() . '/js/main.js', array( 'waitforimages', 'bootstrap', 'stylishparallax', 'flexslider', 'fluidbox' ), null, true );
	
	wp_localize_script( 'stylish', 'stylish_main_js', array(
		'home_url'  => home_url( '/' ),
		'ajax_load' => get_theme_mod( 'ajax_load' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'stylish_scripts' );

/**
 * Admin functions and hooks.
 */
if( is_admin() ) {
	require_once( get_template_directory() . '/admin/init.php' );
}

/**
 * Load Theme Customizer options.
 */
require_once get_template_directory() . '/admin/customizer.php';

/**
 * Custom fields meta boxes.
 */
if( is_admin() ) {
	require_once( get_template_directory() . '/inc/meta-boxes.php' );
}

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';

/**
 * Custom fonts functions.
 */
require_once get_template_directory() . '/inc/custom-fonts.php';

/**
 * Setup visual composer plugin.
 */
require_once( get_template_directory() . '/inc/visual-composer.php');



/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'example_dashboard_widget',         // Widget slug.
                 'RECEIVE $500 in CASH FOR A WEBSITE REFERRAL!!',         // Title.
                 'example_dashboard_widget_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );


/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function example_dashboard_widget_function() {

	// Display whatever it is you want to show.
	echo "<span style='width:100%'><a href='http://www.sayenkodesign.com'><img alt='Seattle Web Design' src='http://www.sayenkodesign.com/wp-content/uploads/2014/08/Sayenko-Design-WP-Referral-Bonus-460.jpg'></a></span>
</br>
</br>

Simply introduce us via email along with the prospects phone number. Email introductions can be sent to <a href='mailto:mike@sayenkodesign.com'>mike@sayenkodesign.com</a>";
} 


?>