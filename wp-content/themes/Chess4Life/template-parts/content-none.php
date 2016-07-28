<?php

/**

 * The template part for displaying a message that posts cannot be found.

 *

 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 *



 */



?>



<article id="post-0" class="hentry">

	<div class="row">

		<div class="col-md-8 col-md-push-2">

			<header class="entry-header">

				<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'kidix' ); ?></h1>

			</header><!-- .entry-header -->

			

			<div class="entry-content">

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				

					<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kidix' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		

				<?php elseif ( is_search() ) : ?>

		

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kidix' ); ?></p>

					<?php get_search_form(); ?>

		

				<?php else : ?>

		

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kidix' ); ?></p>

					<?php get_search_form(); ?>

		

				<?php endif; ?>

			</div><!-- .entry-content -->

		</div>

	</div>

</article><!-- #post-## -->