<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Header_Intro')) {
    class Kidix_Header_Intro {
        function __construct() {
            add_shortcode('kidix_header_intro', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = $h3 = $h2 = $el_class = '';

	        extract( shortcode_atts( array(
                'first_heading'  => '',
                'second_heading' => '',
                'third_heading'  => '',
                'el_class'       => '',
            ), $atts ) );

			$output .= '<header class="header-intro '.esc_attr($el_class).'">';
	        $output .= '<h4>'.esc_html( $first_heading ).'</h4>';
	        $output .= '<h3 class="text-tilt">'.esc_html( $second_heading ).'</h2>';
	        $output .= '<h5><span><span>'.esc_html( $third_heading ).'</span></span></h5>';
			$output .= '</header>';

            return $output;
        }
    }
    new Kidix_Header_Intro;
}