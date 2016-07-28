<?php



global $stylish_post_counter;

if( ! isset( $stylish_post_counter ) ) {

	$stylish_post_counter = 0;

}

$stylish_post_counter++;



?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="row">

		<?php if( has_post_thumbnail() ) : ?>

		<figure class="entry-media col-md-7<?php echo 0 === $stylish_post_counter % 2 ? ' col-md-push-5' : ''; ?>">

			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'stylish-blog-thumb' ); ?></a>

		</figure>

		

		<div class="col-md-5<?php echo 0 === $stylish_post_counter % 2 ? ' col-md-pull-7' : ''; ?>">

		<?php else : ?>

		<div class="col-md-8 col-md-push-2">

		<?php endif; ?>

			<header class="entry-header">

				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				

				<div class="entry-meta">

				</div><!-- .entry-meta -->

			</header><!-- .entry-header -->

			

			<div class="entry-summary">

				<?php the_excerpt(); ?>

			</div><!-- .entry-summary -->

			

			<footer class="entry-footer">

				<a class="btn btn-lg btn-warning" href="<?php the_permalink(); ?>"><?php _e( 'Discover', 'stylish' ); ?></a>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->