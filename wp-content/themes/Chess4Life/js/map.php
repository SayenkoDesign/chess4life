<?php

/**

 * Template Name: Map Page

 *

 * This page template displays the content without the page header.

 * Can be used for landing pages or custom front pages

 *

 */



get_header(); ?>


<style>
      body {
        margin: 0;
        padding: 0;
        font-family: Arial;
        font-size: 14px;
      }

/** height was 550px  **/
      #panel {
        float: left;
        width: 300px;
        height: 750px;
      }
      #map-container {
        margin-left: 300px;
      }
      #map {
        width: 100%;
        height: 550px;
      }
      #markerlist {
        height: 400px;
        margin: 10px 5px 0 10px;
        overflow: auto;
      }
      .title {
        border-bottom: 1px solid #e0ecff;
        overflow: hidden;
        width: 256px;
        cursor: pointer;
        padding: 2px 0;
        display: block;
        color: #000;
        text-decoration: none;
      }
      .title:visited {
        color: #000;
      }
      .title:hover {
        background: #e0ecff;
      }
      #timetaken {
        color: #f00;
      }
      .info {
        width: 200px;
      }
      .info img {
        border: 0;
      }
      .info-body {
        width: 200px;
        height: 200px;
        line-height: 200px;
        margin: 2px 0;
        text-align: center;
        overflow: hidden;
      }
      .info-img {
        height: 220px;
        width: 200px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <?php $post_count = wp_count_posts('map')->publish; ?>
    <script>
    <?php
	$args = array(
		'post_type'      => 'map',
		'order'    => 'ASC',
		'posts_per_page'=>-1,
	);
	query_posts($args);
	if( have_posts() ) :
	?>
	var data = { "count": 10785236,
 "photos":[
	<?php
	$count = 1;
	while ( have_posts() ) : the_post();
	if($count == $post_count)
	{
	?>
		{"photo_title": "<?php the_title(); ?>", "address_content": "<?php the_field('map_address'); ?>", "photo_file_url": "<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>", "longitude": <?php the_field('longitude'); ?>, "latitude": <?php the_field('latitude'); ?>, "width": 500, "height": 375}
	<?php
	}
	else
	{
	?>
		{"photo_title": "<?php the_title(); ?>", "address_content": "<?php the_field('map_address'); ?>", "photo_file_url": "<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>", "longitude": <?php the_field('longitude'); ?>, "latitude": <?php the_field('latitude'); ?>, "width": 500, "height": 375},
	<?php	
	}
	$count++;
	endwhile;
	?>
	]}
	<?php
	endif;
	wp_reset_query();
	?>
    </script>
    <script src="<?php bloginfo('template_directory'); ?>/js/speed_test.js"></script>
	<script>
      var script = '<script type="text/javascript" src="../src/markerclusterer';
      if (document.location.search.indexOf('compiled') !== -1) {
        script += '_compiled';
      }
      script += '.js"><' + '/script>';
      document.write(script);
    </script>
    <script>
      google.maps.event.addDomListener(window, 'load', speedTest.init);
    </script>


<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article class="post-942 page type-page status-publish hentry" id="post-942">
			<header class="entry-header">
				<div class="container">
					<h1 class="entry-title" style="opacity: 1; transform: translate3d(0px, 0px, 0px);">Locations</h1>
                </div>
			</header><!-- .entry-header -->
			<div class="entry map">
				<div class="row">
						<div class="col-md-12">
							<div class="entry-content">
                            	<div id="panel">
                                	<h3>An example of MarkerClusterer v3</h3>
                                    <p>
                                    	<a href="?compiled">Compiled</a> |
                                        <a href="?">Standard</a> version of the script.
                                    </p>
                                
                                    <div>
                                    	<input type="checkbox" id="usegmm"/>
                                        <span>Use MarkerClusterer</span>
                                    </div>
                                
                                    <div>
                                    	Markers:
                                        <select id="nummarkers">
                                          <option value="10" selected="selected">10</option>
                                          <option value="50">50</option>
                                          <option value="100">100</option>
                                          <option value="500">500</option>
                                          <option value="1000">1000</option>
 <option value="5000">5000</option>
                                        </select>
                                
                                        <span>Time used: <span id="timetaken"></span> ms</span>
                                    </div>
                                
                                    <strong>Marker List</strong>
                                    <div id="markerlist"></div>
                                </div>
                                <div id="map-container">
                                  <div id="map"></div>
                                </div>
							</div><!-- .entry-content -->
						</div>
					</div>
			</div>
		</article>
	</main><!-- #main -->
</div><!-- #primary -->

	

<?php get_footer(); ?>