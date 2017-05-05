<?php

/**

 * Template Name: Team Page

 *

 * This page template displays the content without the page header.

 * Can be used for landing pages or custom front pages

 *

 */



get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <article class="has-cover-image post-719 page type-page status-publish hentry" id="post-719">
            <header class="entry-header">
                <div class="container">
                    <h1 class="entry-title" style="opacity: 1; transform: translate3d(0px, 0px, 0px);">Our Team</h1>            
                </div>
            </header><!-- .entry-header -->
        
            <div class="entry">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="entry-content">
                                <div class="vc_row_wrapper container-fluid">
                                    <div class="vc_row wpb_row vc_row-fluid">
                                        <div class="container">
                                            <div class="row flex_wrap">
                                                <?php
                                                $args = array(
                                                    'post_type'      => 'staff',
                                                    'order'    => 'ASC',
                                                    'posts_per_page'=>-1,
                                                );
                                                query_posts($args);
                                                if( have_posts() ) :
                                                while ( have_posts() ) : the_post();
                                                $post_id= get_the_ID();

                                                ?>
                                                <div class="vc_col-sm-4 wpb_column vc_column_container ">
                                                    <div class="wpb_wrapper">
                                                        <div class="wpb_single_image wpb_content_element vc_align_center">
                                                            <div class="wpb_wrapper">
                                                                <div class="vc_single_image-wrapper vc_box_rounded  vc_box_border_grey">
                                                                <a href="<?php echo get_permalink(); ?>"><img width="345" height="346" alt="ElliottNeff300-Samlple-Background" class="vc_single_image-img attachment-full" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>"></a></div>
                                                            </div> 
                                                        </div> 
                                                        <div class="wpb_text_column wpb_content_element ">
                                                            <div class="wpb_wrapper">
                                                                <h2 style="text-align: center;"><?php the_title(); ?></h2>
                                                                <p style="text-align: center;">

                                                                <?php

                                                                $taxonomy = 'staff-type';
                                                                $categories = get_the_terms($post_id, $taxonomy);
                                                                //echo "<pre>";print_r($categories);
                                                                //echo $categories[0]->name;
                                                                $cnt=0;
                                                                foreach($categories as $cat)
                                                                {
                                                                    if($cnt==0)
                                                                        echo $cat->name;
                                                                    else
                                                                        echo ' & '.$cat->name;
                                                                                
                                                                    $cnt++;
                                                                }
                                                                ?>


                                                                </p>
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                </div>
                    
                                         
                                               <?php
                                                endwhile;
                                                endif;
                                                wp_reset_query();
                                                ?> 

                                            </div><!-- .row -->
                                        </div><!-- .container -->
                                    </div><!-- .vc_row -->
                                </div>
                            </div><!-- .entry-content -->
                        </div>
                    </div>
                </div>
            </div>
    
    </article>
    </main><!-- #main -->
</div><!-- #primary -->

    

<?php get_footer(); ?>