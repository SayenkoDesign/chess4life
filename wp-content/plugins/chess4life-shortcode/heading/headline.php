<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Headline')) {
    class Kidix_Headline {
        function __construct() {
            add_shortcode('kidix_headline', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = '';

	        extract( shortcode_atts( array(
                'title'  => '',
                'description' => '',
                'el_class'       => '',
            ), $atts ) );

			$output .= '<header class="section-header '.esc_attr($el_class).'">';
			if( ! empty( $title ) ) {
		        $output .= '<h2 class="section-title">'.esc_html($title).'</h3>';
		    }
		    if( ! empty( $description ) ) {
		        $output .= '<div class="section-description">'.esc_html($description).'</h2>';
	        }
			$output .= '</header>';

            return $output;
        }
    }
    new Kidix_Headline;
}