<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Kidix
 */

/**
 * Backwards compatibility code for old post meta prefix.
 *
 * @param  string $meta     Default Metadata Value.
 * @param  int    $post_id  Post Object ID.
 * @param  string $meta_key Meta Key.
 * @param  bool   $single   Whether to return a single value.
 * @return mixed
 */
function stylish_post_meta_backcompat( $meta, $post_id, $meta_key, $single ) {
	if( 0 === strpos( $meta_key, '_stylish_' ) ) {
		remove_filter( 'get_post_metadata', 'stylish_post_meta_backcompat', 10, 4 );
		if( ! metadata_exists( 'post', $post_id, $meta_key ) ) {
			$meta_key = str_replace( '_stylish_', '_kidix_', $meta_key );
			$meta = get_post_meta( $post_id, $meta_key, $single );
		}
		add_filter( 'get_post_metadata', 'stylish_post_meta_backcompat', 10, 4 );
	}
	
	return $meta;
}
add_filter( 'get_post_metadata', 'stylish_post_meta_backcompat', 10, 4 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function stylish_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	if( is_post_type_archive( 'class' ) || is_post_type_archive( 'teacher' ) || is_post_type_archive( 'album' ) ) {
		$post_type = get_query_var( 'post_type' );
		$layout = get_theme_mod( "{$post_type}_layout" );
		
		if( 'content-sidebar' == $layout ) {
			$classes[] = 'layout-content-sidebar';
		} else {
			$classes[] = 'layout-full-width';
		}
	} elseif( is_singular( array( 'post', 'page' ) ) ) {
		$layout = get_post_meta( get_the_ID(), '_stylish_post_layout', true );
		
		if( 'content-sidebar' == $layout ) {
			$classes[] = 'layout-content-sidebar';
		} else {
			$classes[] = 'layout-full-width';
		}
	} elseif( is_singular( array( 'class' ) ) ) {
		$classes[] = 'layout-content-sidebar';
	} elseif( is_singular( array( 'teacher' ) ) ) {
		$classes[] = 'layout-sidebar-content';
	} else {
		$classes[] = 'layout-full-width';
	}
	
	if( get_theme_mod( 'border_wave' ) ) {
		$classes[] = 'border-wave-active';
	}
	
	if( get_theme_mod( 'ajax_load' ) ) {
		$classes[] = 'doing-ajax';
	}

	return $classes;
}
add_filter( 'body_class', 'stylish_body_classes' );

class stylish_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
	}
}

add_filter( 'wp_nav_menu_objects', 'stylish_bootstrap_menu_parent_class' );

function stylish_bootstrap_menu_parent_class( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			if( $item->menu_item_parent && $item->menu_item_parent > 0 )
				$item->classes[] = 'dropdown-submenu';
			else
				$item->classes[] = 'dropdown';
		}
	}
	
	return $items;
}

function stylish_get_the_archive_title( $title ) {
	if( is_home() ) {
		$title = esc_html__( 'Blog', 'stylish' );
	} elseif( is_404() ) {
		$title = esc_html__( 'Page Not Found', 'stylish' );
	}
	
	$title = explode( ': ', $title );
	if( 1 < count( $title ) ) {
		$title = $title[1];
	} else {
		$title = $title[0];
	}
	
	return $title;
}
add_filter( 'get_the_archive_title', 'stylish_get_the_archive_title' );

add_filter( 'the_author_description', 'wpautop' );
add_filter( 'the_author_description', 'wptexturize' );

function stylish_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<header class="comment-header">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'stylish' ), sprintf( '<h4 class="comment-author vcard"><cite class="fn">%s</cite></h4>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<aside class="comment-meta commentmetadata">
					<span class="comment-time"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'stylish' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a></span>
					<?php edit_comment_link( __( 'Edit', 'stylish' ), '<span class="edit-link">', '</span>' ); ?>
				</aside><!-- .comment-meta -->
				
				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>'
				) ) );
				?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'stylish' ); ?></em></p>
				<?php endif; ?>
			</header>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->
<?php
}

/**
 * Filter the default gallery shortcode output.
 *
 * If the filtered output isn't empty, it will be used instead of generating
 * the default gallery template.
 *
 * @since 2.5.0
 * @since 4.2.0 The `$instance` parameter was added.
 *
 * @see gallery_shortcode()
 *
 * @param string $output   The gallery output. Default empty.
 * @param array  $attr     Attributes of the gallery shortcode.
 * @param int    $instance Unique numeric ID of this gallery shortcode instance.
 */
function stylish_gallery_shortcode( $output, $attr, $instance = 1 ) {
	// Allow use of Jetpack Tiled Galleries Module
	if( class_exists( 'Jetpack' ) && in_array( 'tiled-gallery', Jetpack::get_active_modules() ) ) {
		return $output;
	}
	
	global $post;
	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	/**
	 * Filter whether to print default gallery styles.
	 *
	 * @since 3.1.0
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *                    Defaults to false if the theme supports HTML5 galleries.
	 *                    Otherwise, defaults to true.
	 */
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'><div class='row'>";

	/**
	 * Filter the default gallery shortcode CSS styles.
	 *
	 * @since 2.5.0
	 *
	 * @param string $gallery_style Default CSS styles and opening HTML div container
	 *                              for the gallery shortcode output.
	 */
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	$colspan = intval( 12 / $columns );
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
		$output .= "<{$itemtag} class='gallery-item col-md-{$colspan}'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div></div>\n";
	
	return $output;
}
add_filter( 'post_gallery', 'stylish_gallery_shortcode', 10, 3 );

function stylish_comment_form_default_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' );
	
	$fields['author'] = '<p class="comment-form-author col-md-4">' .
		'<label for="author" class="screen-reader-text sr-only">' . __( 'Name', 'stylish' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
		'<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . __( 'Name', 'stylish' ) . '"' . $aria_req . $html_req . ' />' . '</p>';
		
	$fields['email'] = '<p class="comment-form-email col-md-4">' .
		'<label for="email" class="screen-reader-text sr-only">' . __( 'Email', 'stylish' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
		'<input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="' . __( 'Email', 'stylish' ) . '"' . $aria_req . $html_req  . ' />' . '</p>';
	$fields['url'] = '<p class="comment-form-url col-md-4">' .
		'<label for="url" class="screen-reader-text sr-only">' . __( 'Website', 'stylish' ) . '</label>' .
		'<input id="url" class="form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . __( 'Website', 'stylish' ) . '" />' . '</p>';
	
	return $fields;
}
add_filter( 'comment_form_default_fields', 'stylish_comment_form_default_fields' );

function stylish_comment_form_before_fields() {
	echo '<div class="row">';
}
add_action( 'comment_form_before_fields', 'stylish_comment_form_before_fields' );

function stylish_comment_form_after_fields() {
	echo '</div>';
}
add_action( 'comment_form_after_fields', 'stylish_comment_form_after_fields' );

function stylish_comment_form_defaults( $args ) {
	$args['comment_field'] = '<p class="comment-form-comment">' .
		'<label for="comment" class="screen-reader-text sr-only">' . _x( 'Comment', 'noun', 'stylish' ) . '</label>' .
		'<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" placeholder="' . __( 'Your thoughts&#8230;', 'stylish' ) . '" aria-required="true" required="required"></textarea>' . '</p>';
	$args['comment_notes_before'] = '';
	$args['comment_notes_after'] = '';
	$args['class_submit'] = 'submit btn btn-lg btn-warning';
	$args['title_reply'] = __( 'Leave a comment', 'stylish' );
	$args['title_reply_to'] = __( 'Leave a comment for %s', 'stylish' );
	
	
	return $args;
}
add_filter( 'comment_form_defaults', 'stylish_comment_form_defaults' );

function stylish_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e( 'Extra profile information', 'stylish' ); ?></h3>
	
	<table class="form-table">
		<tr>
			<th><label for="twitter"><?php _e( 'Facebook', 'stylish' ); ?></label></th>
			
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e( 'Please enter your Facebook URL.', 'stylish' ); ?></span>
			</td>
		</tr>
		
		<tr>
			<th><label for="twitter"><?php _e( 'Twitter', 'stylish' ); ?></label></th>
			
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e( 'Please enter your Twitter username.', 'stylish' ); ?></span>
			</td>
		</tr>
	</table>
<?php
}
add_action( 'show_user_profile', 'stylish_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'stylish_show_extra_profile_fields' );

function stylish_save_extra_profile_fields( $user_id ) {
	if( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_user_meta( $user_id, 'facebook', esc_url_raw( $_POST['facebook'] ) );
	update_user_meta( $user_id, 'twitter', esc_url_raw( $_POST['twitter'] ) );
}
add_action( 'personal_options_update', 'stylish_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'stylish_save_extra_profile_fields' );


function stylish_custom_css( $input ) {
	$defaults       = stylish_default_theme_settings();
	$headings_color = get_theme_mod( 'headings_color' );
	$text_color     = get_theme_mod( 'text_color' );
	$link_color     = get_theme_mod( 'link_color' );
	$accent_color   = get_theme_mod( 'accent_color' );
	$headings_font = get_theme_mod( 'headings_font' );
	$text_font     = get_theme_mod( 'text_font' );
	$accent_font   = get_theme_mod( 'accent_font' );
	
	if( $headings_font != $defaults['headings_font'] || $text_font != $defaults['text_font'] || $accent_font != $defaults['accent_font'] ) {
		$fonts = stylish_custom_fonts();
	}
	
	if( $headings_color != $defaults['headings_color'] ) {
		$input .= ".main-navigation,
.navbar-default .navbar-toggle .icon-bar,
.navbar-default .navbar-toggle .icon-bar:before,
.navbar-default .navbar-toggle .icon-bar:after,
.navbar-nav .dropdown-menu > li:first-child:before,
.category-filter .btn-default:hover,
.category-filter .dropdown-menu {
	background-color: {$headings_color};
}
.btn-primary,
.navbar-default .navbar-toggle,
.category-filter .btn-default:hover,
.zilla-likes,
.comments-title a,
.comment-respond .form-submit input[type='submit']:hover {
	border-color: {$headings_color};
}
.btn-primary,
.navbar-default .navbar-brand,
.navbar-default .navbar-brand:hover,
.navbar-inverse .navbar-brand-inverse,
.navbar-default .navbar-toggle-text,
.post-type-archive-teacher .hentry .entry-title,
.custom-post-type-teacher .entry-title,
.tax-teacher-type .hentry .entry-title,
.entry-footer .entry-meta,
.entry-footer .entry-meta a,
.zilla-likes,
.entry-author .author a,
.header-group h2:last-child,
.comments-title a,
.comment-respond .form-submit input[type='submit']:hover,
.vc_col-sm-4 .wpb_text_column h1,
.vc_col-sm-4 .wpb_text_column h2,
.vc_col-sm-4 .wpb_text_column h3,
.vc_col-sm-4 .wpb_text_column h4,
.vc_col-sm-4 .wpb_text_column h5,
.vc_col-sm-4 .wpb_text_column h6,
.widget_categories li a,
.widget_tag_cloud .tagcloud a,
.widget_recent_entries li a,
.custom-query-post_type_archive .entry-title a,
.widgets-list-layout .widgets-list-layout-links a,
.recentcomments .comment-author-link,
.recentcomments > a,
.widget_class_meta li,
.widget_class_meta .class-type a {
	color: {$headings_color};
}
@media (min-width: 1200px) {
	.navbar-inverse.expanded .navbar-toggle-text,
	.navbar-nav .dropdown-menu > li > a,
	.navbar .navbar-nav > li > a {
		color: {$headings_color};
	}
}\n";
	}
	
	if( $text_color != $defaults['text_color'] ) {
		$input .= "body,
.author-meta,
.author-meta a,
.class-price small,
.album-photos-count,
.comment-meta a,
.recentcomments .comment-summary,
.panel-title > a {
	color: {$text_color};
}\n";
	}
	
	if( $link_color != $defaults['link_color'] ) {
		$input .= ".panel.active .panel-title > a,
.page-header,
.single.layout-full-width .has-post-thumbnail .entry-header,
.page-shortcodes .entry-header,
.background-parallax::after,
.vc_parallax-inner::after,
.site-footer,
.list-group-item.active,
.list-group-item.active:focus,
.list-group-item.active:hover {
	background-color: {$link_color};
}

.post-type-archive-class .hentry .entry-title a,
.post-type-archive-album .hentry .entry-title a,
.custom-post-type-class .hentry .entry-title a,
.tax-class-type .hentry .entry-title a,
.post-type-archive-teacher .hentry .entry-title a,
.custom-post-type-teacher .entry-title a,
.tax-class-type .entry-title a,
.tax-teacher-type .entry-title a,
.sidebar-primary .widget-title{
	color: {$link_color};
}\n";
	}
	
	if( $accent_color != $defaults['accent_color'] ) {
		$input .= ".single-class .has-post-thumbnail .entry-header,
.page .hentry > .entry-header,
.btn-danger,
.nav-tabs > li.active > a,
.nav-tabs > li.active > a:focus,
.nav-tabs > li.active > a:hover {
	background-color: {$accent_color};
}
.zilla-likes:hover,
.comments-title a:hover,
.comment-respond .form-submit input[type='submit'],
.vc_images_carousel .vc_item a::after,
.widget_categories li a:hover,
.widget_tag_cloud .tagcloud a:hover,
.btn-warning,
.btn-danger,
.nav-tabs > li.active > a,
.nav-tabs > li.active > a:focus,
.nav-tabs > li.active > a:hover {
	border-color: {$accent_color};
}
a,
.entry-title a:hover,
.post-type-archive-class .entry-title a:hover,
.post-type-archive-album .entry-title a:hover,
.post-type-archive-teacher .hentry .entry-title a:hover,
.custom-post-type-teacher .entry-title a:hover,
.tax-class-type .entry-title a:hover,
.tax-teacher-type .entry-title a:hover,
.entry-footer .entry-meta a:hover,
.entry-author .author a:hover,
.entry-header .class-price,
.class-tags a:hover,
.header-group h3:first-child,
.comments-title a:hover,
.comment-author a:hover,
.comment-respond .form-submit input[type='submit'],
.vc_images_carousel .vc_item a::after,
.widget_categories li a:hover,
.widget_tag_cloud .tagcloud a:hover,
.widget_recent_entries li a:hover,
.custom-query-post_type_archive .entry-title a:hover,
.widgets-list-layout .widgets-list-layout-links a:hover,
.custom-query-post_type_archive .entry-meta,
.widgets-list-layout .entry-meta,
.custom-post-type-class .entry-meta,
.recentcomments > a:hover,
.widget_class_meta .class-type a:hover,
.widget_class_meta .class-price,
.widget_class_meta .class-price small,
.btn-warning,
.btn-link {
	color: {$accent_color};
}
@media (min-width: 1200px) {
	.navbar-nav .dropdown-menu > li > a:hover,
	.navbar-nav .dropdown-menu > li > a:active,
	.navbar-nav .dropdown-menu > li > a:focus,
	.navbar .navbar-nav > li > a:hover,
	.navbar .navbar-nav > li > a:focus,
	.navbar .navbar-nav > li > a:active {
		color: {$accent_color};
	}
}\n";
	}
	
	if( $headings_font != $defaults['headings_font'] ) {
		$family = $fonts[ $headings_font ]['family'];
		$input .= "h1, h2, h3, h4, h5, h6 {
	font-family: {$family};
}\n";
	}
	
	if( $text_font != $defaults['text_font'] ) {
		$family = $fonts[ $text_font ]['family'];
		$input .= "body {
	font-family: {$family};
}\n";
	}
	
	if( $accent_font != $defaults['accent_font'] ) {
		$family = $fonts[ $accent_font ]['family'];
		$input .= ".post-type-archive-teacher .hentry .entry-title,
.custom-post-type-teacher .entry-title,
.tax-teacher-type .hentry .entry-title,
.header-group h3:first-child,
.header-intro h4:first-child {
	font-family: {$family};
}\n";
	}
	
	// Add user customized styles
	$input .= get_theme_mod( 'custom_css' );
	
	return $input;
}
add_filter( 'stylish_custom_css', 'stylish_custom_css' );