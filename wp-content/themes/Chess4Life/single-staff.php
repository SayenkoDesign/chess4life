<?php

/**

 * The template for displaying teacher posts.

 *

 */



$social_profiles  = get_post_meta( get_the_ID(), '_stylish_social_profiles', true );

$teacher_schedule = get_post_meta( get_the_ID(), '_stylish_teacher_schedule', true );

$cover_image      = get_post_meta( get_the_ID(), '_stylish_cover_image', true );



$classes = new WP_Query( array(

	'post_type'      => 'class',

	'posts_per_page' => -1,

	'meta_query'     => array(

		array(

			'key'     => '_stylish_class_teacher',

			'value'   => get_the_ID(),

			'compare' => '=',

		),

		array(

			'key'     => '_kidix_class_teacher',

			'value'   => get_the_ID(),

			'compare' => '=',

		),

		'relation' => 'OR',

	),

) );



if( ! empty( $teacher_schedule ) ) {

	$days = array(

		'monday'    => __( 'Monday', 'stylish' ),

		'tuesday'   => __( 'Tuesday', 'stylish' ),

		'wednesday' => __( 'Wednesday', 'stylish' ),

		'thursday'  => __( 'Thursday', 'stylish' ),

		'friday'    => __( 'Friday', 'stylish' ),

		'saturday'  => __( 'Saturday', 'stylish' ),

		'sunday'    => __( 'Sunday', 'stylish' ),

	);

}



get_header(); ?>



	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			

			<?php while ( have_posts() ) : the_post(); ?>

			

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">

					<?php if( ! empty( $cover_image ) ) : ?>

						<div class="background-wrap"><div class="background-parallax" style="background-image: url(<?php echo wp_get_attachment_url( intval( $cover_image ) ); ?>);"></div></div>

					<?php endif; ?>

					

					<div class="container">

						<div class="row">

							<?php if( has_post_thumbnail() ) : ?>

								<figure class="entry-media col-md-4">

									<?php the_post_thumbnail( 'stylish-teacher-thumb' ); ?>

								</figure>

							<?php endif; ?>

							

							<div class="col-md-8">

								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<span class="staff_designation">
								<?php
								$taxonomy = 'staff-type';
								$post_ID = get_the_ID();
								$categories = get_the_terms($post_ID, $taxonomy);
								$cnt=0;
								foreach($categories as $cat){
									if($cnt==0)
										echo $cat->name;
									else
										echo ' & '.$cat->name;
												
									$cnt++;
								}
								?>
								</span>
								<?php

									if( ! empty( $social_profiles ) ) {

										wp_nav_menu( array(

											'menu'        => $social_profiles,

											'container'   => '',

											'menu_class'  => 'social-profiles',

											'fallback_cb' => '',

										) );

									}

								?>

								

								<?php

									the_terms(

										get_the_ID(),

										'teacher-type',

										'<div class="entry-meta">',

										', ',

										'</div><!-- .entry-meta -->'

									); 

								?>

							</div>

						</div>

					</div>

				</header><!-- .entry-header -->

				

				<div class="entry">

					<div class="container">

						<div class="row">

							<?php if( $classes->have_posts() || ! empty( $teacher_schedule ) ) : ?>

							<div class="schedule col-md-4">

								<?php if( $classes->have_posts() ) : ?>

									<ul class="list-group">

										<li class="list-group-item active">

											<strong><?php _e( 'Classes', 'stylish' ); ?></strong>

											<i class="pull-right fa fa-graduation-cap"></i>

										</li>

										

										<?php while( $classes->have_posts() ) : ?>

											<?php $classes->the_post(); ?>

											

											<li class="list-group-item">

												<strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>

												<span class="pull-right"><?php

													$class_age   = get_post_meta( get_the_ID(), '_stylish_class_age', true );

													printf( '%1$s %2$s', esc_html( $class_age ), __( 'years old', 'stylish' ) );

												?></span>

											</li>

										<?php endwhile; ?>

									</ul>

									

									<?php wp_reset_postdata(); ?>

								<?php endif; ?>

								

								<?php if( ! empty( $teacher_schedule ) ) : ?>

									<ul class="list-group">

										<li class="list-group-item active">

											<strong><?php _e( 'Schedule', 'stylish' ); ?></strong>

											<i class="pull-right fa fa-clock-o"></i>

										</li>

										

										<?php foreach( $teacher_schedule as $day => $schedule) :

											if( empty( $schedule ) ) {

												continue;

											}

											

											?>

											<li class="list-group-item">

												<strong><?php echo esc_html( $days[ $day ] ); ?></strong>

												<span class="pull-right"><?php echo esc_html( $schedule ); ?></span>

											</li>

										<?php endforeach; ?>

									</ul>

								<?php endif; ?>

							</div>

							

							<div class="col-md-8">

							<?php else : ?>

							<div class="col-md-8 col-md-push-4 neff-right">

							<?php endif; ?>

								<div class="entry-content">

									<?php the_content(); ?>

									

									<?php

										wp_link_pages( array(

											'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'stylish' ),

											'after'  => '</div>',

										) );

									?>

								</div><!-- .entry-content -->

							</div>

						</div>

					</div>

				</div>

			</article><!-- #post-## -->

			

			<?php endwhile; // end of the loop. ?>

			

		</main><!-- #main -->

	</div><!-- #primary -->

				

<?php get_footer(); ?>