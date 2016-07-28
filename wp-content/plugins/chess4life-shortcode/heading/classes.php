<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Classes_Grid')) {
    class Kidix_Classes_Grid {
        function __construct() {
            add_shortcode('kidix_classes_grid', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = '';

	        extract( shortcode_atts( array(
                'classes'  => '',
                'grid_columns' => 4,
            ), $atts ) );
            
            if( empty( $classes ) ) {
            	return;
            }
            
            $classes = explode( ',', $classes );
            
            $query = new WP_Query( array( 'ignore_sticky_posts' => true, 'post_type' => 'class', 'post__in' => $classes, 'posts_per_page' => -1 ) );
            
            if( $query->have_posts() ) {
            	global $kidix_grid_columns;
            	$kidix_grid_columns = $grid_columns;
	            ob_start();
	            while( $query->have_posts() ) {
	            	$query->the_post();
	            	get_template_part( 'vc_templates/vc_classes_grid' );
	            }
	            wp_reset_postdata();
				$output = ob_get_clean();
			}

            return $output;
        }
    }
    new Kidix_Classes_Grid;
}