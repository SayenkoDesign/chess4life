<?php

/**

 * The template for displaying comments.

 *

 * The area of the page that contains both current comments

 * and the comment form.

 *

 */



/*

 * If the current post is protected by a password and

 * the visitor has not yet entered the password we will

 * return early without loading the comments.

 */

if ( post_password_required() ) {

	return;

}

?>



<section id="comments" class="comments-area">



	<?php // You can start editing here -- including this comment! ?>

	

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				

				<?php if ( have_comments() ) : ?>

				

					<h2 class="comments-title">

						<?php

							printf( // WPCS: XSS OK

								esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments', 'stylish' ) ),

								number_format_i18n( get_comments_number() )

							);

						?>

						

						<a href="#respond"><?php _e( 'Add yours', 'stylish' ); ?></a>

					</h2>

					

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>

					<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">

						<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'stylish' ); ?></h2>

						<div class="nav-links">

			

							<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'stylish' ) ); ?></div>

							<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'stylish' ) ); ?></div>

			

						</div><!-- .nav-links -->

					</nav><!-- #comment-nav-above -->

					<?php endif; // check for comment navigation ?>

					

					<ol class="comment-list">

						<?php

							wp_list_comments( array(

								'avatar_size' => 0,

								'style'       => 'ol',

								'short_ping'  => true,

								'callback'    => 'stylish_html5_comment',

							) );

						?>

					</ol>

					

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>

					<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">

						<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'stylish' ); ?></h2>

						<div class="nav-links">

			

							<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'stylish' ) ); ?></div>

							<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'stylish' ) ); ?></div>

			

						</div><!-- .nav-links -->

					</nav><!-- #comment-nav-below -->

					<?php endif; // check for comment navigation ?>

					

				<?php endif; // have_comments() ?>

				

				<?php

					// If comments are closed and there are comments, let's leave a little note, shall we?

					if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :

				?>

					<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'stylish' ); ?></p>

				<?php endif; ?>

				

				<?php comment_form(); ?>

				

			</div>

		</div>

	</div>

</section>