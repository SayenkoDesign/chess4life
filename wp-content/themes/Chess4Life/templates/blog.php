<?php
/**
 * Template Name: Blog
 *
 * This page template is used to display the main blog.
 * You can customize the number of posts per page
 * Select the categories to include or exclude from the blog
 * and order your posts by different criteria.
 *
 * 
 */

// Parse custom blog WP_Query.
global $wp_query, $paged;
$paged = get_query_var( 'page' );

$posts_per_page = get_post_meta( get_the_ID(), '_stylish_posts_per_page', true );
$posts_per_page = empty( $posts_per_page ) ? get_option( 'posts_per_page' ) : intval( $posts_per_page );

$category__in = get_post_meta( get_the_ID(), '_stylish_category__in', true );
$category__in = empty( $category__in ) ? null : $category__in;

$order = get_post_meta( get_the_ID(), '_stylish_order', true );
$order = 'ASC' == $orderby ? $orderby : 'DESC';

$orderby = get_post_meta( get_the_ID(), '_stylish_orderby', true );
$orderby = empty( $orderby ) ? 'date' : $orderby;

$wp_query = new WP_Query( array(
	'post_type'      => 'post',
	'paged'          => max( 1, $paged ),
	'posts_per_page' => $posts_per_page,
	'category__in'   => $category__in,
	'order'          => $order,
	'orderby'        => $orderby,
) );

// Simply include the primary archive template.
locate_template( 'index.php', true );