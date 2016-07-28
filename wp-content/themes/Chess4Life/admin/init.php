<?php

function stylish_admin_scripts( $page_hook ) {
	if( 'post.php' == $page_hook || 'post-new.php' == $page_hook ) {
		wp_enqueue_style( 'stylish-admin', get_template_directory_uri() . '/css/settings.css', false, null );
		
		wp_enqueue_script( 'stylish-admin', get_template_directory_uri() . '/js/settings.js', array( 'jquery' ), null, true );
		
		/*wp_localize_script( 'stylish-admin', 'stylish_admin_args', array(
			
		) );*/
	}
}
add_action( 'admin_enqueue_scripts', 'stylish_admin_scripts' );

/**
 * Custom admin AJAX actions.
 */
require_once get_template_directory() . '/admin/ajax-actions.php';

/**
 * TGM require plugins init.
 */
require_once get_template_directory() . '/inc/tgm/tgm-init.php';

