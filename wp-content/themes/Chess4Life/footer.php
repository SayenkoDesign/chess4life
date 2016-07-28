<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 */

$contact_address = get_theme_mod( 'contact_address' );
$phone_number = get_theme_mod( 'phone_number' );
if( function_exists( 'icl_translate' ) ) {
	$contact_address = icl_translate( 'Theme Mod', 'contact_address', $contact_address );
	$phone_number    = icl_translate( 'Theme Mod', 'phone_number', $phone_number );
}

?>

	</div><!-- #content -->
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php get_sidebar( 'footer' ); ?>
		
		<div class="site-info">
			<div class="container">
				<span><?php printf( __( '&copy; Copyright %1$s %2$s', 'stylish' ), get_bloginfo( 'name' ), date( 'Y' ) ); ?></span>
				
				<?php if( '' != $contact_address ) : ?>
					<span><?php echo esc_html( $contact_address ); ?></span>
				<?php endif; ?>
				
				<?php if( '' != $phone_number ) : ?>
					<span><?php echo esc_html( $phone_number ); ?></span>
				<?php endif; ?>
				<span><a href="http://www.sayenkodesign.com/" title="Seattle Web Design">Seattle Web Design</a> by Sayenko Design

</span>


			</div>
		</div><!-- .site-info -->
		
		<?php if( has_nav_menu( 'secondary' ) ) : ?>
			<nav id="footer-navigation" class="secondary-navigation" role="navigation">
				<div class="container">
					<h2 class="screen-reader-text sr-only"><?php __( 'Footer Menu', 'stylish' ); ?></h2>
					
					<?php
						wp_nav_menu( array(
							'theme_location'  => 'secondary',
							'container'       => '',
							'menu_class'      => 'menu nav nav-pills',
							'menu_id'         => 'menu-navigation',
							'fallback_cb'     => '',
						) );
					?>
				</div>
			</nav><!-- #footer-navigation -->
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php if( get_theme_mod( 'ajax_load' ) ) : ?>
	<div class="ajax-mask overlaid"><div class="spinner"><div class="cube1"></div><div class="cube2"></div></div></div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>