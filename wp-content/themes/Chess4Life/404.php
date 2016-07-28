<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="page-header">
				<div class="container">
                <div style="clear:both; height:50px; width:100%;"></div>
					<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_s' ); ?></h1>
				</div>
			</header>
			
			<div class="container">
			
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
				
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>