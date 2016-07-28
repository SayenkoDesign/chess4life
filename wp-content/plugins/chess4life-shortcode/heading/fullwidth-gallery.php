<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Fullwidth_Gallery')) {
	class Kidix_Fullwidth_Gallery {
		function __construct() {
			add_shortcode('kidix_fullwidth_gallery', array($this, 'shortcode'));
		}

		function shortcode($atts) {
			$output = $images = $button_text = $button_url = $el_class = '';

			extract( shortcode_atts( array(
				'images'        => '',
				'button_text'   => '',
				'button_url'    => '#',
				'el_class'      => '',
			), $atts ) );

			$images = explode(",", strval($images));

			$output .= '<aside class="widget widget_enlightenment-custom-query '.esc_attr($el_class).'">';
			$output .= '<div class="custom-query-carousel custom-query-gallery flexslider">';
			$output .= '<ul class="slides">';

			foreach($images as $image_id) {
				$image_big = wp_get_attachment_image_src( $image_id, 'full' );
				$image_small = wp_get_attachment_image_src( $image_id, 'kidix-carousel-thumb' );

				$output .= '<li class="custom-entry slide custom-entry-lead custom-post-type-attachment">';
//				$output .= '<a rel="attachment" href="'.esc_url($image_big[0]).'">';
				$output .= '<img src="'.esc_url($image_small[0]).'" />';
//				$output .= '</a>';
				$output .= '</li>';
			}

			$output .= '</ul>';
			$output .= '</div>';
			if(!empty($button_text)) {
				$output .= '<p class="text-center"><a class="btn btn-lg btn-default" href="'.esc_url($button_url).'">'.esc_html($button_text).'</a></p>';
			}
			$output .= '</aside>';

			return $output;
		}
	}
	new Kidix_Fullwidth_Gallery;
}