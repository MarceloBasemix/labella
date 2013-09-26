<?php
/**
 * Mazine Product Categories widget class
 *
 * @since 3.7.1
 */
 
 if (class_exists('WP_Widget_Product_Categories')) {
 
class WP_Mazine_Widget_Product_Categories extends WP_Widget {

	function WP_Mazine_Widget_Product_Categories() {

		$widget_ops = array('classname' => 'widget_wpsc_categorisation', 'description' => __('Mazine Categories Slider'));
		$this->WP_Widget('', __('Categories Slider'), $widget_ops);
	}

	function widget( $args, $instance ) {
	  global $wpdb, $wpsc_theme_path;
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Product Categories','mazine' ) : $instance['title']);
		echo $before_widget;
		
		$show_thumbnails = $instance['image'];

		if ( isset($instance['grid'] ) )
			$grid = (bool)$instance['grid'];

		if ( isset($instance['width'] ) )
			$width = $instance['width'];

		if ( isset( $instance['height'] ) )
			$height = $instance['height'];

		if ( !isset( $instance['categories'] ) ){
			$instance_categories = get_terms( 'wpsc_product_category', 'hide_empty=0&parent=0');
			if(!empty($instance_categories)){
				foreach($instance_categories as $categories){

					$instance['categories'][$categories->term_id] = 'on';
				}
			}
		
		}
		
		
		?>
		
		<div class="infiniteSlider" id="categories_box">
				<div class="wrapper">
					<ul>
		
		<?php
		foreach ( array_keys( (array)$instance['categories'] ) as $category_id ) {

			if (!get_term($category_id, "wpsc_product_category")) 
				continue;

			$curr_cat = get_term( $category_id, 'wpsc_product_category', ARRAY_A );
			$category_list  = get_terms( 'wpsc_product_category', 'hide_empty=0&parent=' . $category_id );
			
		
			$link = get_term_link((int)$category_id , 'wpsc_product_category');
			$category_image = wpsc_get_categorymeta( $curr_cat['term_id'], 'image' );
			$category_image = WPSC_CATEGORY_URL . $category_image;
	
			?>	



		
							<li class="wpsc_category_<?php echo $category_id?>">
								
								<div class="cat_container">
								<h5><a href="<?php echo $link; ?>"><?php //echo $curr_cat['name']; ?></a></h5>
								<a href="<?php echo $link; ?>" >
							<?php wpsc_parent_category_image( $show_thumbnails, $category_image , $width, $height, true ,$show_name); ?>
						</a>
							</div>
								
							</li>

						
						
	<?php	
		
} ?>

</ul>
				</div>
			</div>

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['image']      = $new_instance['image'] ? 1 : 0;
		$instance['categories'] = $new_instance['categories'];
		$instance['grid']       = $new_instance['grid'] ? 1 : 0;
		$instance['height']     = (int)$new_instance['height'];
		$instance['width']      = (int)$new_instance['width'];
		$instance['show_name']	= (bool)$new_instance['show_name'];	
		return $instance;


		return $instance;
	}

	function form( $instance ) {

		global $wpdb;

		// Defaults
		$instance = wp_parse_args((array) $instance, array(
			'title' => '',
			'width' => 114,
			'height' => 87,
			'image' => false,
			'grid' => false,
			'show_name' => false,
		));

		// Values
		$title    = esc_attr( $instance['title'] );
		$image    = (bool) $instance['image'];
		$width    = (int) $instance['width'];
		$height   = (int) $instance['height'];
		$grid     = (bool) $instance['grid'];
		$show_name= (bool) $instance['show_name'];	
		 ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wpsc' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<?php _e('Show Categories','wpsc'); ?>:<br />
			<?php wpsc_list_categories('wpsc_category_widget_admin_category_list', array("id"=>$this->get_field_id('categories'),"name"=>$this->get_field_name('categories'),"instance"=>$instance), 0); ?>
			<?php _e('(leave all unchecked if you want to display all)','wpsc'); ?>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>"<?php checked( $image ); ?> onclick="jQuery('.wpsc_category_image').toggle()" />
			<label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Show Thumbnails', 'wpsc'); ?></label>
		</p>

		<div class="wpsc_category_image"<?php if( !checked( $image ) ) { echo ' style="display:none;"'; } ?>>
			<p>
				
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_name'); ?>" name="<?php echo $this->get_field_name('show_name'); ?>"<?php checked( $show_name ); ?> /><label for="<?php echo $this->get_field_id('show_name'); ?>"><?php _e(' Show N/A when No Image Available', 'wpsc'); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'wpsc'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $width ; ?>" size="3" />
				<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'wpsc'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $height ; ?>" size="3" />
			</p>
		</div>
<?php
	}

}

	register_widget('WP_Mazine_Widget_Product_Categories');

}
?>