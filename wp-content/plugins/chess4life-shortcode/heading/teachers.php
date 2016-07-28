<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Teachers_Grid')) {
    class Kidix_Teachers_Grid {
        function __construct() {
            add_shortcode('kidix_teachers_grid', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = '';

	        extract( shortcode_atts( array(
                'teachers'  => '',
                'grid_columns' => 4,
            ), $atts ) );
            
            if( empty( $teachers ) ) {
            	return;
            }
            
            $teachers = explode( ',', $teachers );
            
            $query = new WP_Query( array( 'ignore_sticky_posts' => true, 'post_type' => 'staff', 'post__in' => $teachers, 'posts_per_page' => -1 ) );
            
            if( $query->have_posts() ) {
            	global $kidix_grid_columns;
            	$kidix_grid_columns = $grid_columns;
	            ob_start();
	            while( $query->have_posts() ) {
	            	$query->the_post();
	            	get_template_part( 'vc_templates/vc_teachers_grid' );
	            }
	            wp_reset_postdata();
				$output = ob_get_clean();
			}

            return $output;
        }
    }
    new Kidix_Teachers_Grid;
}