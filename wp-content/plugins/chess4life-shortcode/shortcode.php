<?php
/**
 * Plugin Name: Chess4Life Shortcode
 * Plugin URI: http://sayenkodesign.com
 * Description: This is a plugin that creates the shortcodes for Chess4Life.
 * Version: 1.0
 * Author: Sayenko Design
 * Author URI: http://sayenkodesign.com
 * License: GPLv2 or later
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// include all the shortcodes
$dir = plugin_dir_path( __FILE__ );
include_once($dir . 'heading/headline.php');
include_once($dir . 'heading/header-group.php');
include_once($dir . 'heading/header-intro.php');
include_once($dir . 'heading/classes.php');
include_once($dir . 'heading/teachers.php');
include_once($dir . 'heading/google-map.php');
include_once($dir . 'heading/fullwidth-gallery.php');

// add a class that will handle Visual Composer integration & other stuff related to shortcodes for the theme
if(!class_exists('Kidix_Shortcode')) {
    class Kidix_Shortcode {

        function __construct() {
            // do things on class init
        }

    }
    new Kidix_Shortcode;
}