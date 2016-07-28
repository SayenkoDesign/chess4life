<?php





global $stylish_grid_columns;

$social_profiles = get_post_meta( get_the_ID(), '_stylish_social_profiles', true );

?>



<article class="custom-entry  custom-post-type-teacher custom-entry-lead col-sm-<?php echo intval( $stylish_grid_columns ); ?>">

	<div class="entry">

		<header class="entry-header">

			<?php if( has_post_thumbnail() ) : ?>

				<figure class="entry-media">

					<?php the_post_thumbnail( 'stylish-teacher-thumb' ); ?>

					

					<?php

						if( ! empty( $social_profiles ) ) {

							$content = wp_nav_menu( array(

								'menu'        => $social_profiles,

								'container'   => '',

								'menu_class'  => 'social-profiles',

								'fallback_cb' => '',

								'echo'        => false,

							) );

							

							$document = new DOMDocument();

							libxml_use_internal_errors( true );

							$document->loadHTML( $content );

							libxml_clear_errors();

							$list = $document->getElementsByTagName( 'ul' );

							if( $list->length ) {

								$items = $document->getElementsByTagName( 'li' );

								$item = $document->createElement( 'li' );

								$link = $document->createElement( 'a' );

								$link->setAttribute( 'href', esc_url( get_permalink() ) );

								$item->appendChild( $link );

								$list->item(0)->insertBefore( $item, $items->item( intval( $list->length / 2 ) + 2 ) );

							}

							$content = $document->saveHTML();

							$content = str_replace( '</li><li' , "</li>\n<li", $content );

							$content = str_replace( '"></a>' , sprintf( '">%s</a>', get_the_title() ), $content );

							echo $content;

						}

					?>

				</figure>

			<?php endif; ?>

			

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			

			<?php the_terms( get_the_ID(), 'staff-type', '<div class="entry-meta">', ', ', '</div><!-- .entry-meta -->' ); ?>

		</header><!-- .entry-header -->

	</div>

</article><!-- #post-## -->