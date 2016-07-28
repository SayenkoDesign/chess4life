<?php
/**
 * The sidebar containing the footer widget area.
 *
 */

if ( ! is_active_sidebar( 2 ) && ! has_nav_menu( 'social' ) ) {
	return;
}

?>

<div class="sidebar widget-area sidebar-footer">
	<div class="container">
		<h2 class="sidebar-title screen-reader-text sr-only">Footer Sidebar</h2>
		
		<?php dynamic_sidebar( 2 ); ?>
		
		<?php
			wp_nav_menu( array(
				'theme_location'  => 'social',
				'container'       => 'aside',
				'container_class' => 'widget',
				'menu_class'      => 'social-icons nav nav-pills',
				'menu_id'         => 'social-icons',
				'fallback_cb'     => '',
			) );
		?>
	</div>
</div>