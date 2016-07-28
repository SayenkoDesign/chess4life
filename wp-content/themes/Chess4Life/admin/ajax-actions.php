<?php

function stylish_preview_cover_image() {
	$id = intval( $_POST['id'] );
	$size = esc_attr( $_POST['size'] );
	$mime_type = esc_attr( $_POST['mime_type'] );
	
	if( 'image' == $mime_type ) {
		echo wp_get_attachment_image( $id, $size );
	} else {
		echo '<a href="' . wp_get_attachment_url( $id ) . '">' . get_the_title( $id ) . '</a>';
	}
	
	die();
}
add_action( 'wp_ajax_stylish_preview_cover_image', 'stylish_preview_cover_image' );