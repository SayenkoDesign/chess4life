<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'stylish' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'stylish' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'stylish' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'stylish' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'stylish_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function stylish_posted_on() {
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

	$posted_on = sprintf(
		'<span class="posted-on">' .
		esc_html_x( 'Posted on %s', 'post date', 'stylish' ) .
		'</span>',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		'<span class="byline">' .
		esc_html_x( 'by %s', 'post author', 'stylish' ) .
		'</span>',
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo $posted_on . ' ' . $byline; // WPCS: XSS OK

}
endif;

if ( ! function_exists( 'stylish_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function stylish_entry_footer() {
	?>
	<footer class="entry-footer">
	
		<?php
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php if( function_exists('zilla_likes') ) : ?>
					<div class="like pull-left">
						<?php zilla_likes(); ?>
					</div>
				<?php endif; ?>
				
				<?php /* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'stylish' ) );
				if ( $tags_list ) {
					printf( '<span class="entry-tags pull-right"><strong>' . esc_html__( 'Tags:', 'stylish' ) . '</strong> %1$s</span>', $tags_list ); // WPCS: XSS OK
				} ?>
			</div>
			
			<div class="entry-author media">
				<span class="media-left">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ); ?>
				</span>
				
				<div class="media-body">
					<h4 class="author vcard"><?php the_author_posts_link(); ?></h4>
					
					<div class="author-description">
						<?php the_author_meta( 'description' ); ?>
					</div>
					
					<div class="author-meta">
						<?php if( '' != get_the_author_meta( 'url' ) ) : ?>
							<span class="author-url"><a href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>"><i class="fa fa-home"></i> <?php _e( 'Website', 'stylish' ); ?></a></span>
						<?php endif; ?>
						
						<?php if( '' != get_the_author_meta( 'facebook' ) ) : ?>
							<span class="author-facebook"><a href="<?php echo esc_url( get_the_author_meta( 'facebook' ) ); ?>"><i class="fa fa-facebook"></i> <?php _e( 'Facebook', 'stylish' ); ?></a></span>
						<?php endif; ?>
						
						<?php if( '' != get_the_author_meta( 'twitter' ) ) : ?>
							<span class="author-twitter"><a href="<?php echo esc_url( get_the_author_meta( 'twitter' ) ); ?>"><i class="fa fa-twitter"></i> <?php _e( 'Twitter', 'stylish' ); ?></a></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif;
	
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'stylish' ), esc_html__( '1 Comment', 'stylish' ), esc_html__( '% Comments', 'stylish' ) );
			echo '</span>';
		}
	
//		edit_post_link( esc_html__( 'Edit', 'stylish' ), '<span class="edit-link">', '</span>' );
		?>
		
	</footer><!-- .entry-footer -->
	
<?php
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'stylish' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'stylish' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'stylish' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'stylish' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'stylish' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'stylish' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'stylish' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'stylish' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'stylish' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'stylish' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'stylish' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'stylish' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'stylish' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'stylish' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function stylish_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'stylish_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'stylish_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so stylish_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so stylish_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in stylish_categorized_blog.
 */
function stylish_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'stylish_categories' );
}
add_action( 'edit_category', 'stylish_category_transient_flusher' );
add_action( 'save_post',     'stylish_category_transient_flusher' );

function stylish_category_filter() {
	if( ! stylish_categorized_blog() ) {
		return;
	}
	
	$categories = get_categories();
	
	if( ! empty( $categories ) ) :
	?>
	<div class="category-filter dropdown pull-right">
		<button class="btn btn-default dropdown-toggle" type="button" id="toggle-category-filter" data-toggle="dropdown" aria-expanded="true">
			<?php _e( 'Categories', 'stylish' ); ?>
			<span class="caret"></span>
		</button>
		
		<ul class="dropdown-menu" role="menu" aria-labelledby="toggle-category-filter">
			<?php foreach( $categories as $category ) : ?>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo esc_url( get_category_link( $category->cat_ID ) ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif;
}

function stylish_class_type_filter() {
	$types = get_terms( 'class-type' );
	
	if( ! empty( $types )/* && count( $types ) > 1*/ ) :
	?>
	<div class="category-filter dropdown pull-right">
		<button class="btn btn-default dropdown-toggle" type="button" id="toggle-category-filter" data-toggle="dropdown" aria-expanded="true">
			<?php _e( 'Class Types', 'stylish' ); ?>
			<span class="caret"></span>
		</button>
		
		<ul class="dropdown-menu" role="menu" aria-labelledby="toggle-category-filter">
			<?php foreach( $types as $type ) : ?>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo esc_url( get_term_link( intval( $type->term_id ), 'class-type' ) ); ?>"><?php echo esc_html( $type->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif;
}

function stylish_teacher_type_filter() {
	$types = get_terms( 'teacher-type' );
	
	if( ! empty( $types )/* && count( $types ) > 1*/ ) :
	?>
	<div class="category-filter dropdown pull-right">
		<button class="btn btn-default dropdown-toggle" type="button" id="toggle-category-filter" data-toggle="dropdown" aria-expanded="true">
			<?php _e( 'Teacher Types', 'stylish' ); ?>
			<span class="caret"></span>
		</button>
		
		<ul class="dropdown-menu" role="menu" aria-labelledby="toggle-category-filter">
			<?php foreach( $types as $type ) : ?>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo esc_url( get_term_link( intval( $type->term_id ), 'teacher-type' ) ); ?>"><?php echo esc_html( $type->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif;
}