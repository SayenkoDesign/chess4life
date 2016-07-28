<?php
/**
 * Template Name: Landing Page
 *
 * This page template displays the content without the page header.
 * Can be used for landing pages or custom front pages
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			
			<?php endwhile; // end of the loop. ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>