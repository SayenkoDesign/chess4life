<?php


$layout = get_post_meta( get_the_ID(), '_stylish_post_layout', true );

$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
}

$time_string = sprintf( $time_string,
	esc_attr( get_the_date( 'c' ) ),
	esc_html( get_the_date() ),
	esc_attr( get_the_modified_date( 'c' ) ),
	esc_html( get_the_modified_date() )
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-push-2 col-lg-push-0">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					
					<div class="entry-meta">
						<span class="entry-date">
							<?php echo $time_string; ?>
						</span>
					</div><!-- .entry-meta -->
				</div>
				
				<?php if( has_post_thumbnail() ) : ?>
					<div class="col-md-8 col-md-push-2 col-lg-push-0">
						<figure class="entry-media">
							<?php the_post_thumbnail( 'stylish-single-thumb' ); ?>
						</figure>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header><!-- .entry-header -->
	
	<div class="entry">
		<div class="container">
			<div class="row">
				<div class="col-md-8 <?php echo ( 'content-sidebar' == $layout ? '' : 'col-md-push-2' ); ?>">
					<div class="entry-content">
						<?php the_content(); ?>
						
						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'stylish' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
					
					<?php stylish_entry_footer(); ?>
				</div>
					
				<?php if( 'content-sidebar' == $layout ) : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
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