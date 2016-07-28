<?php
/**
 * The sidebar containing the main widget area.
 *
 */

if ( ! is_active_sidebar( 1 ) ) {
	return;
}

?>

<div class="sidebar widget-area sidebar-primary col-md-3 col-md-push-1">
	<h2 class="sidebar-title screen-reader-text sr-only">Primary Sidebar</h2>
	
	<?php dynamic_sidebar( 1 ); ?>
</div>