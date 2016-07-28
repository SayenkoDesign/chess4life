<?php


global $stylish_grid_columns;

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

$class_price = get_post_meta( get_the_ID(), '_stylish_class_price', true );
$class_age   = get_post_meta( get_the_ID(), '_stylish_class_age', true );
$class_size  = get_post_meta( get_the_ID(), '_stylish_class_size', true );

?>

<article class="custom-entry custom-post-type-class custom-entry-lead col-sm-<?php echo intval( $stylish_grid_columns ); ?>">
	<div class="entry">
		<?php if( has_post_thumbnail() ) : ?>
		<figure class="entry-media">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'stylish-class-thumb' ); ?>
			</a>
		</figure>
		<?php endif; ?>
		
		<header class="entry-header">
			<?php if( ! empty( $class_price ) ) : ?>
				<span class="class-price"><?php echo esc_html( $class_price ); ?> <small><?php _e( 'p/day', 'stylish' ); ?></small></span>
			<?php endif; ?>
			
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			
			<div class="entry-meta">
				<span class="entry-date">
					<?php echo $time_string; ?>
				</span>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->
		
		<footer class="entry-footer row">
			<?php if( ! empty( $class_age ) ) : ?>
				<span class="class-age col-xs-6 col-md-3"><strong><?php echo esc_html( $class_age ); ?></strong><br> <small><?php _e( 'Years old', 'stylish' ); ?></small></span>
			<?php endif; ?>
			
			<?php if( ! empty( $class_size ) ) : ?>
				<span class="class-size col-xs-6 col-md-4"><strong><?php echo esc_html( $class_size ); ?></strong><br> <small><?php _e( 'Class size', 'stylish' ); ?></small></span>
			<?php endif; ?>
			
			<?php the_terms( get_the_ID(), 'class-type', '<span class="class-tags col-xs-12 col-md-5">', ', ', '</span>' ); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->