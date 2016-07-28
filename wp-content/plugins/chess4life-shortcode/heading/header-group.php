<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Header_Group')) {
    class Kidix_Header_Group {
        function __construct() {
            add_shortcode('kidix_header_group', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = $h3 = $h2 = $el_class = '';

	        extract( shortcode_atts( array(
                'first_heading'  => '',
                'second_heading' => '',
                'el_class'       => '',
            ), $atts ) );

			$output .= '<header class="header-group '.esc_attr($el_class).'">';
	        $output .= '<h3>'.esc_html($first_heading).'</h3>';
	        $output .= '<h2>'.esc_html($second_heading).'</h2>';
			$output .= '</header>';

            return $output;
        }
    }
    new Kidix_Header_Group;
}