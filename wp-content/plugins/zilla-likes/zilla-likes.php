<?php
/*
Plugin Name: ZillaLikes
Plugin URI: http://www.themezilla.com/plugins/zillalikes
Description: Add "like" functionality to your posts and pages
Version: 1.1.1
Author: ThemeZilla
Author URI: http://www.themezilla.com
*/

class ZillaLikes {

    function __construct() 
    {	
    	add_action('init', array(&$this, 'zilla_likes_textdomain'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'), 11);
        add_filter('the_content', array(&$this, 'the_content'));
        add_filter('the_excerpt', array(&$this, 'the_content'));
        add_filter('body_class', array(&$this, 'body_class'));
        add_action('publish_post', array(&$this, 'setup_likes'));
        add_action('wp_ajax_zilla-likes', array(&$this, 'ajax_callback'));
		add_action('wp_ajax_nopriv_zilla-likes', array(&$this, 'ajax_callback'));
        add_shortcode('zilla_likes', array(&$this, 'shortcode'));
        add_action('widgets_init', create_function('', 'register_widget("ZillaLikes_Widget");'));
	}

	function zilla_likes_textdomain() {
		// Set filter for plugin's languages directory
		$zilla_likes_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		$zilla_likes_lang_dir = apply_filters( 'zilla_likes_languages_directory', $zilla_likes_lang_dir );

		// Load the translations
		load_plugin_textdomain( 'zillalikes', false, $zilla_likes_lang_dir );
	}
	
	function enqueue_scripts()
	{
	    $options = get_option( 'zilla_likes_settings' );
		if( ! isset( $options['disable_css'] ) ) {
			$options['disable_css'] = '1';
		}
		
		if(!$options['disable_css']) wp_enqueue_style( 'zilla-likes', plugin_dir_url( __FILE__ ) . 'styles/zilla-likes.css' );
		
		wp_enqueue_script( 'zilla-likes', plugin_dir_url( __FILE__ ) . 'scripts/zilla-likes.js', array( 'jquery' ), null, true );
		
		wp_localize_script( 'zilla-likes', 'zilla_likes', array('ajaxurl' => admin_url('admin-ajax.php')) );
		wp_localize_script( 'main', 'zilla_likes', array('ajaxurl' => admin_url('admin-ajax.php')) );
	}
	
	function the_content( $content )
	{		
	    // Don't show on custom page templates
	    if(is_page_template()) return $content;
	    // Don't show on Stacked slides
	    if(get_post_type() == 'slide') return $content;
	    
		global $wp_current_filter;
		if ( in_array( 'get_the_excerpt', (array) $wp_current_filter ) ) {
			return $content;
		}
		
		$options = get_option( 'zilla_likes_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '0';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		if( !isset($options['exclude_from']) ) $options['exclude_from'] = '';
		
		$ids = explode(',', $options['exclude_from']);
		if(in_array(get_the_ID(), $ids)) return $content;
		
		if(is_singular('post') && $options['add_to_posts']) $content .= $this->do_likes();
		if(is_page() && !is_front_page() && $options['add_to_pages']) $content .= $this->do_likes();
		if((is_front_page() || is_home() || is_category() || is_tag() || is_author() || is_date() || is_search()) && $options['add_to_other'] ) $content .= $this->do_likes();
		
		return $content;
	}
	
	function setup_likes( $post_id ) 
	{
		if(!is_numeric($post_id)) return;
	
		add_post_meta($post_id, '_zilla_likes', '0', true);
	}
	
	function ajax_callback($post_id) 
	{

		$options = get_option( 'zilla_likes_settings' );
		if( !isset($options['add_to_posts']) ) $options['add_to_posts'] = '0';
		if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
		if( !isset($options['add_to_other']) ) $options['add_to_other'] = '0';
		if( ! isset( $options['zero_postfix'] ) ) {
			$options['zero_postfix'] = __( 'Likes', 'stylish' );
		}
		if( ! isset( $options['one_postfix'] ) ) {
			$options['one_postfix']  = __( 'Like', 'stylish' );
		}
		if( ! isset( $options['more_postfix'] ) ) {
			$options['more_postfix'] = __( 'Likes', 'stylish' );
		}

		if( isset($_POST['likes_id']) ) {
		    // Click event. Get and Update Count
			$post_id = str_replace('zilla-likes-', '', $_POST['likes_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update');
		} else {
		    // AJAXing data in. Get Count
			$post_id = str_replace('zilla-likes-', '', $_POST['post_id']);
			echo $this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get');
		}
		
		exit;
	}
	
	function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get') 
	{
		if(!is_numeric($post_id)) return;
		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);		
		
		switch($action) {
		
			case 'get':
				$likes = get_post_meta($post_id, '_zilla_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_id, '_zilla_likes', $likes, true);
				}
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="zilla-likes-count">'. $likes .'</span> <span class="zilla-likes-postfix">'. $postfix .'</span>';
				break;
				
			case 'update':
				$likes = get_post_meta($post_id, '_zilla_likes', true);
				if( isset($_COOKIE['zilla_likes_'. $post_id]) ) return $likes;
				
				$likes++;
				update_post_meta($post_id, '_zilla_likes', $likes);
				setcookie('zilla_likes_'. $post_id, $post_id, time()*20, '/');
				
				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }
				
				return '<span class="zilla-likes-count">'. $likes .'</span> <span class="zilla-likes-postfix">'. $postfix .'</span>';
				break;
		
		}
	}
	
	function shortcode( $atts )
	{
		extract( shortcode_atts( array(
		), $atts ) );
		
		return $this->do_likes();
	}
	
	function do_likes()
	{
		global $post;

        $options = get_option( 'zilla_likes_settings' );
		if( ! isset( $options['zero_postfix'] ) ) {
			$options['zero_postfix'] = __( 'Likes', 'stylish' );
		}
		if( ! isset( $options['one_postfix'] ) ) {
			$options['one_postfix']  = __( 'Like', 'stylish' );
		}
		if( ! isset( $options['more_postfix'] ) ) {
			$options['more_postfix'] = __( 'Likes', 'stylish' );
		}
		
		$output = $this->like_this( $post->ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'] );
  
  		$class = 'zilla-likes';
  		$title = __( 'Like this', 'zillalikes' );
		if( isset($_COOKIE['zilla_likes_'. $post->ID]) ){
			$class = 'zilla-likes active';
			$title = __('You already like this', 'zillalikes');
		}
		
		return '<a href="#" class="'. $class .'" id="zilla-likes-'. $post->ID .'" title="'. $title .'"> <i class="fa fa-heart-o"></i> '. $output .'</a>';
	}
	
    function body_class($classes) {
        $options = get_option( 'zilla_likes_settings' );
        
        if( !isset($options['ajax_likes']) ) $options['ajax_likes'] = true;
        
        if( $options['ajax_likes'] ) {
        	$classes[] = 'ajax-zilla-likes';
    	}
    	return $classes;
    }
	
}
global $zilla_likes;
$zilla_likes = new ZillaLikes();

/**
 * Template Tag
 */
function zilla_likes()
{
	global $zilla_likes;
    echo $zilla_likes->do_likes(); 
}

/**
 * Widget to display posts by likes popularity
 */

class ZillaLikes_Widget extends WP_Widget {

	function __construct() {
		parent::WP_Widget( 'zilla_likes_widget', 'ZillaLikes', array( 'description' => __('Displays your most popular posts sorted by most liked', 'zillalikes') ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$desc = $instance['description'];
		$posts = empty( $instance['posts'] ) ? 1 : $instance['posts'];
		$display_count = $instance['display_count'];

		// Output our widget
		echo $before_widget;
		if( !empty( $title ) ) echo $before_title . $title . $after_title;

		if( $desc ) echo '<p>' . $desc . '</p>';

		$likes_posts_args = array(
			'numberposts' => $posts,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_zilla_likes',
			'post_type' => 'post',
			'post_status' => 'publish'
		);
		$likes_posts = get_posts($likes_posts_args);

		echo '<ul class="zilla-likes-popular-posts">';
		foreach( $likes_posts as $likes_post ) {
			$count_output = '';
			if( $display_count ) {
				$count = get_post_meta( $likes_post->ID, '_zilla_likes', true);
				$count_output = " <span class='zilla-likes-count'>($count)</span>";
			}
			echo '<li><a href="' . get_permalink($likes_post->ID) . '">' . get_the_title($likes_post->ID) . '</a>' . $count_output . '</li>';
		}
		echo '</ul>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description'], '<a><b><strong><i><em><span>');
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['display_count'] = strip_tags($new_instance['display_count']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);

		$defaults = array(
			'title' => __('Popular Posts', 'zillalikes'),
			'description' => '',
			'posts' => 5,
			'display_count' => 1
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$description = $instance['description'];
		$posts = $instance['posts'];
		$display_count = $instance['display_count'];
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stylish'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'stylish'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo $description; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Posts:', 'stylish'); ?></label> 
			<input id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="text" value="<?php echo $posts; ?>" size="3" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('display_count'); ?>" name="<?php echo $this->get_field_name('display_count'); ?>" type="checkbox" value="1" <?php checked( $display_count ); ?>>
			<label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Display like counts', 'stylish'); ?></label>
		</p>

		<?php
	}
}