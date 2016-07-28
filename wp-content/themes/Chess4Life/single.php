<?php
/**
 * The template for displaying all single posts.
 *
 */

$layout = get_post_meta( get_the_ID(), '_stylish_post_layout', true );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'template-parts/content', 'single' ); ?>
				
				<?php //the_post_navigation(); ?>
			
			<?php endwhile; // end of the loop. ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>