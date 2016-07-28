<?php

/**

 * The template used for displaying page content in page.php

 *

 */



$cover_image = get_post_meta( get_the_ID(), '_stylish_cover_image', true );



?>



<article id="post-<?php the_ID(); ?>" <?php post_class( empty( $cover_image ) ? '' : 'has-cover-image' ); ?>>

	<?php if( ! is_page_template( 'templates/landing-page.php' ) ) : ?>

		<header class="entry-header">

			<?php if( ! empty( $cover_image ) ) : ?>

				<div class="background-wrap"><div class="background-parallax" style="background-image: url(<?php echo wp_get_attachment_url( intval( $cover_image ) ); ?>);"></div></div>

			<?php endif; ?>

			

			<div class="container">

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			</div>

		</header><!-- .entry-header -->

	<?php endif; ?>

	

	<div class="entry">

		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<div class="entry-content">

						<?php the_content(); ?>

						

						<?php

							wp_link_pages( array(

								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'stylish' ),

								'after'  => '</div>',

							) );

						?>

					</div><!-- .entry-content -->

				</div>

			</div>

		</div>

	</div>

	

	<?php

		// If comments are open or we have at least one comment, load up the comment template

		if ( comments_open() || get_comments_number() ) :

			comments_template();

		endif;

	?>

</article><!-- #post-## -->