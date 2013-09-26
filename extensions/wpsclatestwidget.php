<?php
/**
 * Latest Product widget class
 *
 * Takes the settings, works out if there is anything to display, if so, displays it.
 *
 * @since 3.8
 */
 
class MZ_Widget_Latest_Products extends WP_Widget {

	/**
	 * Widget Constuctor
	 */
	function MZ_Widget_Latest_Products() {
		$widget_ops = array( 'classname' => 'widget_mz_wpsc_latest_products','description' => __( 'Mazine Latest Products Widget', 'wpsc' ) );
		$this->WP_Widget( 'wpsc_latest_products', __( 'Mazine Latest Products', 'wpsc' ), $widget_ops );
	}

	/**
	 * Widget Output
	 *
	 * @param $args (array)
	 * @param $instance (array) Widget values.
	 */
	function widget( $args, $instance ) {

		global $wpdb, $table_prefix;

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Latest Products', 'wpsc' ) : $instance['title'] );

		echo $before_widget;
		
		echo ' <div class="title border">
					<h2 class="category-title">'.$title.'</h2>
			</div>';

		if ( $title )
			echo $before_title . $title . $after_title;
		wpsc_mazine_latest_product( $args, $instance );
		echo $after_widget;
	}

	/**
	 * Update Widget
	 *
	 * @param $new_instance (array) New widget values.
	 * @param $old_instance (array) Old widget values.
	 *
	 * @return (array) New values.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['number']     = (int)$new_instance['number'];
		$instance['image']      = (bool)$new_instance['image'];
		$instance['height']     = (int)$new_instance['height'];
		$instance['width']      = (int)$new_instance['width'];

		return $instance;

	}

	/**
	 * Widget Options Form
	 *
	 * @param $instance (array) Widget values.
	 */
	function form( $instance ) {

		global $wpdb;

		// Defaults
		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
			'number' => 4,
			'width' => 173,
			'height' => 151
		) );

		// Values
		$title    = esc_attr( $instance['title'] );
		$number   = (int)$instance['number'];
		$image    = (bool)$instance['image'];
		$width    = (int) $instance['width'];
		$height   = (int) $instance['height']; ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wpsc' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of products to show:', 'wpsc' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>"<?php checked($image); ?> onclick="jQuery('.wpsc_latest_image').toggle()">
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Show Thumbnails', 'wpsc' ); ?></label>
		</p>

		<div class="wpsc_latest_image"<?php if( !checked( $image ) ) { echo ' style="display:none;"'; } ?>>
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

add_action( 'widgets_init', create_function( '', 'return register_widget("MZ_Widget_Latest_Products");' ) );

function wpsc_mazine_latest_product( $args = null, $instance ) {
	global $wpdb;
	$args = wp_parse_args( (array)$args, array( 'number' => 4 ) );
	$siteurl = get_option( 'siteurl' );
	$options = get_option( 'wpsc-widget_latest_products' );
	$number  = isset($instance['number']) ? (int)$instance['number'] : 4;
	$image  = isset($instance['image']) ? (bool)$instance['image'] : FALSE;

	if ( isset($instance['width'] ) )
		$width = $instance['width'];

	if ( isset( $instance['height'] ) )
		$height = $instance['height'];

	$latest_products = get_posts( array(
		'post_type'   => 'wpsc-product',
		'numberposts' => $number, 
		'orderby'     => 'post_date',
		'post_parent' => 0,
		'post_status' => 'publish',
		'wpsc_product_category' => 'lancamentos-home',
		'order'       => 'DESC'
	) );
	$output = '';

	//post_type=wpsc-product&wpsc_product_category=lancamentos-home
	
	//$loop2 = new WP_Query( array('post_type' => 'wpsc-product', 'posts_per_page' => 8, 'wpsc_product_category' => 'lancamentos-home' ) );
	
	
	$total = count( $latest_products );
	$i = 0;	
	if ( count( $latest_products ) > 0 ) {
		
		
		$output .= '<div class="grid no-border" id="products" ><ul>';		
		foreach ( $latest_products as $latest_product ) {
			$i++;
			if ( !($i%4)) $class = 'last'; else $class = '';
			$output .= '<li class="item '.$class.' ">';
			// Thumbnails, if required
			if ($image) {					
				$output .= '<a class="product-image" href="' . wpsc_product_url( $latest_product->ID, null ) . '">';
				$attached_images = (array)get_posts( array(
					'post_type'   => 'attachment',
					'numberposts' => 1,
					'post_status' => null,
					'post_parent' => $latest_product->ID,
					'orderby'     => 'menu_order',
					'order'       => 'ASC'
				) );
				$attached_image = $attached_images[0]; 
				if ( $attached_image->ID > 0 )
						$output .= '<img class="product_image" src="' . wpsc_product_image( $attached_image->ID, $width, $height ) . '" title="' . $latest_product->post_title . '" alt="' . $latest_product->post_title . '" />';
				else
					$output .='<img class="no-image product_image" id="product_image_'.wpsc_the_product_id().'" alt="No Image" title="'.wpsc_the_product_title().'" src="'.WPSC_URL.'/wpsc-theme/images/noimage.png" width="' . $width . '" height="' . $height . '" />';
				
				$output .= '</a>';
				
			}
			// Link
			$output .= '<h3 class="product-name"><a href="' . wpsc_product_url( $latest_product->ID, null ) . '" class="wpsc-product-title">'.stripslashes( $latest_product->post_title ).'</a></h3>';
			
		
			
			//$output .= '<p class="product-desc">'. $latest_product->post_content.'</p>';
			$output .= '<p class="product-desc"></p>';
			$output .=  '<div class="action2">';
			
			/*$output .= '<div class="price-box"><span class="pricedisplay"></span>';
				
			$output.= '</div>';*/
			
			$output .= '<a class="button right" href="' . wpsc_product_url( $latest_product->ID, null ) . '"><span><span>'.__( 'Mais detalhes', 'wpsc' ).'</span></span></a>';
			
			$output .= '</div>';
			
			$output .= '</li>';
		}
		$output .= "</ul></div>";
	}
	echo $output;
}