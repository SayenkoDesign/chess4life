<?php
//single testimonial default template

/* scheme.org example
 <div itemprop="review" itemscope itemtype="http://schema.org/Review">
	<span itemprop="name">Not a happy camper</span> -
	by <span itemprop="author">Ellie</span>,
	<meta itemprop="datePublished" content="2011-04-01">April 1, 2011
	<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
	  <meta itemprop="worstRating" content = "1">
	  <span itemprop="ratingValue">1</span>/
	  <span itemprop="bestRating">5</span>stars
	</div>
	<span itemprop="description">The lamp burned out and now I have to replace
	it. </span>
  </div>
 */ 
 ?>
		<div class="<?php echo $output_theme; ?> <?php echo $attribute_classes; ?> easy_t_single_testimonial" <?php echo $width_style; ?>>
			<blockquote itemscope itemtype="http://schema.org/Review" class="easy_testimonial" style="<?php echo $testimonial_body_css; ?>">
				<?php if ($show_thumbs) {
					?><div class="easy_testimonial_image_wrapper"><?php
					echo $testimonial['image'];
					?></div><?php
				} ?>		
				<?php if ($show_title) {
					echo '<p itemprop="name" class="easy_testimonial_title">' . get_the_title($postid) . '</p>';
				} ?>	
				<?php if($meta_data_position == "above") {
					$this->easy_testimonials_build_metadata_html($testimonial, $author_class, $show_date, $show_rating, $show_other);	
				} ?>
				<div class="<?php echo $body_class; ?>" itemprop="description">
					<?php echo $testimonial['content']; ?>
					<?php if($show_view_more):?><a href="<?php echo $testimonials_link; ?>" class="easy_testimonials_read_more_link"><?php echo get_option('easy_t_view_more_link_text', 'Read More Testimonials'); ?></a><?php endif; ?>
				</div>	
				<?php if($meta_data_position == "below") {	
					$this->easy_testimonials_build_metadata_html($testimonial, $author_class, $show_date, $show_rating, $show_other);	
				} ?>
				<div class="easy_t_clear"></div>
			</blockquote>
		</div>