<?php

function stylish_meta_boxes() {
	add_meta_box(
		'stylish_blog_options',
		__( 'Blog Options', 'stylish' ),
		'stylish_blog_options',
		'page',
		'advanced',
		'high'
	);
	
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$choices = array();
	foreach( $menus as $menu ) {
		$choices[ $menu->term_id ] = $menu->name;
	}
	
	foreach( array( 'page', 'teacher' )  as $screen ) {
		add_meta_box(
			'stylish_cover_image',
			__( 'Cover Image', 'stylish' ),
			'stylish_cover_image',
			$screen,
			'side',
			'core',
			array(
				'name' => 'stylish_cover_image',
				'choices' => $choices,
			)
		);
	}
	
	foreach( array( 'post', 'page' ) as $screen ) {
		add_meta_box(
			'stylish_post_layout',
			__( 'Post Layout', 'stylish' ),
			'stylish_radio_buttons',
			$screen,
			'side',
			'core',
			array(
				'name' => 'stylish_post_layout',
				'choices' => array(
					'full-width'      => __( 'Full Width', 'stylish' ),
					'content-sidebar' => __( 'Content / Sidebar', 'stylish' ),
				),
			)
		);
	}
	
	add_meta_box(
		'stylish_social_profiles',
		__( 'Social Profiles', 'stylish' ),
		'stylish_select_box',
		'teacher',
		'advanced',
		'high',
		array(
			'name' => 'stylish_social_profiles',
			'choices' => $choices,
		)
	);
	
	add_meta_box(
		'stylish_teacher_schedule',
		__( 'Schedule', 'stylish' ),
		'stylish_teacher_schedule',
		'teacher',
		'advanced',
		'high',
		array(
			'name' => 'stylish_teacher_schedule',
		)
	);
	
	$teachers = new WP_Query( array( 'post_type' => 'teacher', 'posts_per_page' => -1 ) );
	$choices = array();
	foreach( $teachers->posts as $teacher ) {
		$choices[ $teacher->ID ] = $teacher->post_title;
	}
	
	add_meta_box(
		'stylish_class_teacher',
		__( 'Class Teacher', 'stylish' ),
		'stylish_select_box',
		'class',
		'side',
		'core',
		array(
			'name' => 'stylish_class_teacher',
			'choices' => $choices,
		)
	);
	
	add_meta_box(
		'stylish_class_price',
		__( 'Class Price', 'stylish' ),
		'stylish_text_input',
		'class',
		'side',
		'core',
		array(
			'name'  => 'stylish_class_price',
			'label' => __( 'Price / Day', 'stylish' ),
		)
	);
	
	add_meta_box(
		'stylish_class_age',
		__( 'Class Age', 'stylish' ),
		'stylish_text_input',
		'class',
		'side',
		'core',
		array(
			'name'  => 'stylish_class_age',
			'label' => __( 'Years old', 'stylish' ),
		)
	);
	
	add_meta_box(
		'stylish_class_size',
		__( 'Class Size', 'stylish' ),
		'stylish_text_input',
		'class',
		'side',
		'core',
		array(
			'name'  => 'stylish_class_size',
			'label' => __( 'Number of Seats', 'stylish' ),
		)
	);
	
	add_meta_box(
		'stylish_class_duration',
		__( 'Class Duration', 'stylish' ),
		'stylish_text_input',
		'class',
		'side',
		'core',
		array(
			'name'  => 'stylish_class_duration',
			'label' => __( 'Time of Day', 'stylish' ),
		)
	);
	
	add_meta_box(
		'stylish_class_cta',
		__( 'Call to Action', 'stylish' ),
		'stylish_class_cta',
		'class',
		'side',
		'core',
		array()
	);
}
add_action( 'add_meta_boxes', 'stylish_meta_boxes' );

function stylish_blog_options( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$posts_per_page = get_post_meta( $post->ID, '_stylish_posts_per_page', true );
	$posts_per_page = empty( $posts_per_page ) ? get_option( 'posts_per_page' ) : intval( $posts_per_page );
	
	$category__in = get_post_meta( $post->ID, '_stylish_category__in', true );
	$category__in = empty( $category__in ) ? null : $category__in;
	
	$order = get_post_meta( $post->ID, '_stylish_order', true );
	$order = 'ASC' == $order ? $order : 'DESC';
	
	$orderby = get_post_meta( $post->ID, '_stylish_orderby', true );
	$orderby = empty( $orderby ) ? 'date' : $orderby;
	
	$categories = get_categories( array( 'hide_empty' => false ) );
	$orderby_choices = array(
		'date'   => __( 'Date', 'stylish' ),
		'name'   => __( 'Name', 'stylish' ),
		'author' => __( 'Author', 'stylish' ),
		'ID'     => __( 'ID', 'stylish' ),
		'title'  => __( 'Post Title', 'stylish' ),
		'rand'   => __( 'Random', 'stylish' ),
	);
	$order_choices = array(
		'DESC'   => __( 'Descending', 'stylish' ),
		'ASC'    => __( 'Ascending', 'stylish' ),
	);
	
	?>
	<div class="input-group">
		<div class="label">
			<label for="stylish_posts_per_page"><?php _e( 'Posts per Page:', 'stylish' ); ?></label>
		</div>
		
		<div class="input">
			<input type="number" name="stylish_posts_per_page" id="stylish_posts_per_page" value="<?php echo esc_attr( $posts_per_page ); ?>" step="1" min="0" />
			
			<p class="description"><?php _e( 'How many posts you want to display on a single page?', 'stylish' ); ?></p>
		</div>
	</div>
	
	<div class="input-group">
		<div class="label">
			<label for="stylish_category__in"><?php _e( 'Categories:', 'stylish' ); ?></label>
		</div>
		
		<div class="input">
			<?php foreach( $categories as $category ) : ?>
				<label>
					<input type="checkbox" name="stylish_category__in[]" value="<?php echo esc_attr( $category->cat_ID ); ?>" step="1" min="0" />
				
					<?php echo esc_html( $category->cat_name ); ?>
				</label>
				
				<br />
			<?php endforeach; ?>
		</div>
	</div>
	
	<div class="input-group">
		<div class="label">
			<label for="stylish_orderby"><?php _e( 'Order by', 'stylish' ); ?></label>
		</div>
		
		<div class="input">
			<select name="stylish_orderby" id="stylish_orderby">
				<?php foreach( $orderby_choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $orderby ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	
	<div class="input-group">
		<div class="label">
			<label for="stylish_order"><?php _e( 'Order', 'stylish' ); ?></label>
		</div>
		
		<div class="input">
			<select name="stylish_order" id="stylish_order">
				<?php foreach( $order_choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $order ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php
}

function stylish_cover_image( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_' . $args['id'], true );
	
	echo '<p class="hide-if-no-js preview-cover-image">';
	if( ! empty( $value ) ) {
		echo wp_get_attachment_image( intval( $value ), 'stylish-preview-cover' );
	}
	echo '</p>';
	
	echo '<p class="hide-if-no-js">';
	
	echo '<a ';
	echo 'href="#" ';
	echo 'class="select-cover-image" ';
	echo 'data-uploader-title="' . __( 'Select Cover Image', 'stylish' ) . '" ';
	echo 'data-uploader-button-text="' . __( 'Set cover image', 'stylish' ) . '" ';
	echo 'data-mime-type="image" ';
	echo 'data-multiple="false" ';
	echo 'data-thumbnail="stylish-preview-cover" ';
	if( ! empty( $value ) ) {
		echo 'style="display: none;" ';
	}
	echo '>' . __( 'Set cover image', 'stylish' ) . '</a>';
	
	echo '<a ';
	echo 'href="#" ';
	echo 'class="remove-cover-image" ';
	if( empty( $value ) ) {
		echo 'style="display: none;" ';
	}
	echo '>' . __( 'Remove cover image', 'stylish' ) . '</a>';
	
	echo '<input ';
	echo 'class="cover-image-id" ';
	echo 'name="' . esc_attr( $args['id'] ) . '"';
	echo 'value="' . esc_attr( $value ) . '" ';
	echo 'type="hidden" ';
	echo '/>';
	
	echo '</p>';
}

function stylish_select_box( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_' . $args['id'], true );
	
	echo '<select name="' . esc_attr( $args['id'] ) . '">';
	echo '<option value="">&mdash;</option>';
	foreach( $args['args']['choices'] as $id => $name ) {
		echo '<option value="';
		echo esc_attr( $id );
		echo '" ';
		selected( $value, $id );
		echo '>';
		echo strip_tags( $name );
		echo '</option>';
	}
	echo '</select>';
}

function stylish_radio_buttons( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_' . $args['id'], true );
	
	if( empty( $value ) ) {
		$value = 'full-width';
	}
	
	foreach( $args['args']['choices'] as $id => $name ) {
		echo '<p>';
		echo '<label>';
		echo '<input ';
		echo 'type="radio" ';
		echo 'name="' . esc_attr( $args['id'] ) . '"';
		echo 'value="';
		echo esc_attr( $id );
		echo '" ';
		checked( $value, $id );
		echo ' /> ';
		echo strip_tags( $name );
		echo '</label>';
		echo '</p>';
	}
}

function stylish_text_input( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_' . $args['id'], true );
	
	echo '<input type="text" name="' . esc_attr( $args['id'] ) . '" value="' . esc_attr( $value ) . '" size="25" placeholder="' . esc_attr( $args['args']['label'] ) . '" />';
}

function stylish_teacher_schedule( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_' . $args['id'], true );
	if( ! is_array( $value ) ) {
		$value = array();
	}
	
	$days = array(
		'monday'    => __( 'Monday', 'stylish' ),
		'tuesday'   => __( 'Tuesday', 'stylish' ),
		'wednesday' => __( 'Wednesday', 'stylish' ),
		'thursday'  => __( 'Thursday', 'stylish' ),
		'friday'    => __( 'Friday', 'stylish' ),
		'saturday'  => __( 'Saturday', 'stylish' ),
		'sunday'    => __( 'Sunday', 'stylish' ),
	);
	
	echo '<table>';
	
	foreach( $days as $day => $label ) {
		echo '<tr>';
		echo '<td>';
		echo esc_html( $label );
		echo '</td><td>';
		echo '<input type="text" name="' . esc_attr( $args['id'] ) . '[' . esc_attr( $day ) . ']" value="' . ( isset( $value[ $day ] ) ? esc_attr( $value[ $day ] ) : '' ) . '" size="25" />';
		echo '</td>';
		echo '</tr>';
	}
	
	echo '</table>';
}

function stylish_class_cta( $post, $args ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( $args['id'], $args['id'] . '_nonce' );
	
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$cta_btn_link = get_post_meta( $post->ID, '_stylish_cta_btn_link', true );
	$cta_btn_text = get_post_meta( $post->ID, '_stylish_cta_btn_text', true );
	
	if( empty( $cta_btn_link ) ) {
		$cta_btn_link = get_permalink( get_page_by_title( 'Contact Us' )->ID );
	}
	
	if( empty( $cta_btn_text ) ) {
		$cta_btn_text = __( 'Enroll', 'stylish' );
	}
	
	printf( '<p><input type="text" name="%1$s" value="%2$s" size="25" placeholder="%3$s" /></p>', 'stylish_cta_btn_link', esc_attr( $cta_btn_link ), esc_attr( __( 'Link URL', 'stylish' ) ) );
	printf( '<p><input type="text" name="%1$s" value="%2$s" size="25" placeholder="%3$s" /></p>', 'stylish_cta_btn_text', esc_attr( $cta_btn_text ), esc_attr( __( 'Button Label', 'stylish' ) ) );
}

function stylish_save_meta_box_data( $post_id ) {
	// Make sure that it is set.
	$fields = array();
	
	if ( isset( $_POST['stylish_posts_per_page'] ) ) {
		$fields['stylish_posts_per_page'] = $_POST['stylish_posts_per_page'];
		$fields['stylish_category__in']   = isset( $_POST['stylish_category__in'] ) ? $_POST['stylish_category__in'] : null;
		$fields['stylish_orderby']        = $_POST['stylish_orderby'];
		$fields['stylish_order']          = $_POST['stylish_order'];
	}
	
	if ( isset( $_POST['stylish_cover_image'] ) ) {
		$fields['stylish_cover_image'] = $_POST['stylish_cover_image'];
	}
	
	if ( isset( $_POST['stylish_post_layout'] ) ) {
		$fields['stylish_post_layout'] = $_POST['stylish_post_layout'];
	}
	
	if ( isset( $_POST['stylish_social_profiles'] ) ) {
		$fields['stylish_social_profiles'] = $_POST['stylish_social_profiles'];
	}
	
	if ( isset( $_POST['stylish_teacher_schedule'] ) ) {
		$fields['stylish_teacher_schedule'] = $_POST['stylish_teacher_schedule'];
	}
	
	if ( isset( $_POST['stylish_class_teacher'] ) ) {
		$fields['stylish_class_teacher'] = $_POST['stylish_class_teacher'];
	}
	
	if ( isset( $_POST['stylish_class_price'] ) ) {
		$fields['stylish_class_price'] = $_POST['stylish_class_price'];
	}
	
	if ( isset( $_POST['stylish_class_age'] ) ) {
		$fields['stylish_class_age'] = $_POST['stylish_class_age'];
	}
	
	if ( isset( $_POST['stylish_class_size'] ) ) {
		$fields['stylish_class_size'] = $_POST['stylish_class_size'];
	}
	
	if ( isset( $_POST['stylish_class_duration'] ) ) {
		$fields['stylish_class_duration'] = $_POST['stylish_class_duration'];
	}
	
	if ( isset( $_POST['stylish_cta_btn_link'] ) ) {
		$fields['stylish_cta_btn_link'] = $_POST['stylish_cta_btn_link'];
		$fields['stylish_cta_btn_text'] = $_POST['stylish_cta_btn_text'];
	}
	
	if ( empty( $fields ) ) {
		return;
	}
	
	foreach ( $fields as $field => $data ) {
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
		
		// Retrieve Meta Box ID for multiform data boxes
		if( 'stylish_posts_per_page' == $field || 'stylish_category__in' == $field || 'stylish_orderby' == $field || 'stylish_order' == $field ) {
			$meta_box_id = 'stylish_blog_options';
		} elseif( 'stylish_cta_btn_link' == $field || 'stylish_cta_btn_text' == $field ) {
			$meta_box_id = 'stylish_class_cta';
		} else {
			$meta_box_id = $field;
		}
	
		// Check if our nonce is set.
		if ( ! isset( $_POST[$meta_box_id . '_nonce'] ) ) {
			continue;
		}
		
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[$meta_box_id . '_nonce'], $meta_box_id ) ) {
			continue;
		}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			continue;
		}
		
		// Check the user's permissions.
		$post = get_post( $post_id );
		if( ! current_user_can( get_post_type_object( $post->post_type )->cap->edit_post, $post_id ) ) {
			continue;
		}
		
		/* OK, it's safe for us to save the data now. */
		
		// Sanitize user input.
		if( 'stylish_posts_per_page' == $field ) {
			$data = intval( $data );
		} elseif( 'stylish_category__in' == $field ) {
			$categories = get_categories( array( 'hide_empty' => false ) );
			$cat_IDs = array();
			foreach ( $categories as $category ) {
				$cat_IDs[] = $category->cat_ID;
			}
			
			if( ! is_array( $data ) ) {
				$data = array();
			}
			
			foreach( $data as $key => $cat_ID ) {
				if( ! in_array( $cat_ID, $cat_IDs ) ) {
					unset( $data[ $key ] );
				}
			}
			
			$data = array_values( $data );
		} elseif( 'stylish_orderby' == $field ) {
			$orderby = array( 'date', 'name', 'author', 'ID', 'title', 'rand' );
			if( ! in_array( $data, $orderby ) ) {
				$data = 'date';
			}
		} elseif( 'stylish_order' == $field ) {
			$order = array( 'DESC', 'ASC' );
			if( ! in_array( $data, $order ) ) {
				$data = 'DESC';
			}
		} elseif( 'stylish_cover_image' == $field ) {
			if( 'attachment' != get_post( intval( $data ) )->post_type ) {
				$data = '';
			}
		} elseif( 'stylish_post_layout' == $field ) {
			if( 'content-sidebar' != $data ) {
				$data = 'full-width';
			}
		} elseif( 'stylish_social_profiles' == $field ) {
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
			$choices = array();
			foreach( $menus as $menu ) {
				$choices[] = $menu->term_id;
			}
			
			if( ! in_array( $data, $choices ) ) {
				$data = '';
			}
		} elseif( 'stylish_teacher_schedule' == $field ) {
			$days = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );
			
			foreach( $data as $day => $value) {
				if( ! in_array( $day, $days ) || empty( $value ) ) {
					unset( $data[ $day ] );
					continue;
				}
				
				$data[ $day ] = sanitize_text_field( $data[ $day ] );
			}
		} elseif( 'stylish_class_teacher' == $field ) {
			$teachers = new WP_Query( array( 'post_type' => 'teacher', 'posts_per_page' => -1 ) );
			$choices = array();
			foreach( $teachers->posts as $teacher ) {
				$choices[] = $teacher->ID;
			}
			
			if( ! in_array( $data, $choices ) ) {
				$data = '';
			}
		} elseif( 'stylish_cta_btn_link' == $field ) {
			$data = esc_url_raw( $data );
		} else {
			$data = sanitize_text_field( $data );
		}
			
		$field = '_' . $field;
	
		// Update the meta field in the database.
		update_post_meta( $post_id, $field, $data );
	}
}
add_action( 'save_post', 'stylish_save_meta_box_data' );