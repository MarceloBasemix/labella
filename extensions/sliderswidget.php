<?php 
/*
* Slider widget - allows you to set up and show themed sliders (based on NextGen Gallery)
*
*/

add_action( 'widgets_init', 'slider_widget' );

function slider_widget() {
	register_widget( 'Slider_Widget' );
}


class Slider_Widget extends WP_Widget {

	function Slider_Widget() {
	
		 parent::WP_Widget(false, 'Mazine Theme sliders');
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'slider-widget', 'description' => 'Slider widget - allows you to set up and show themed sliders (based on NextGen Gallery)' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'slider-widget', 'slider_type' => 'mazine', 'gallery_id' => '1' );

		/* Create the widget. */
		$this->WP_Widget( 'slider-widget', 'Slider Widget', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		
		$atts = array('id'=>$instance['gallery_id']);
		
		
		
		switch ($instance['slider_type']){
		
			case 'coin': TiAdminPanel::CoinSlider($atts); break;
			case 'flashmo': TiAdminPanel::Flashmo($atts); break;
			case 'piecemaker': if (class_exists('PiecemakerMain')) {
			
			
			
				$pm = new PiecemakerMain(); 
				
				if(isset($pm)) {
					register_activation_hook(__FILE__, array($pm, 'PiecemakerMain'));
					register_deactivation_hook(__FILE__, array($pm, 'PiecemakerMainDeactivation'));
					global $wpdb;
					
					$pm->menu_title = 'Piecemaker Plugin';
					$pm->add_page_to = 1;
					$pm->table_name = $wpdb->prefix."piecemakers"; // database table name for books 
					$pm->table_img_name = $wpdb->prefix."piecemaker_img"; // database table name for files
					$pm->books_dir = "piecemakers"; // define where piecemaker (xml) will be placed 
					$pm->images_dir = "piecemaker-images"; // define where images, swf-s, and flv files will be stored
					$pm->path_to_img = get_bloginfo('wpurl')."/wp-includes/piecemaker-images/";
					$pm->path_to_plugin = get_bloginfo('wpurl')."/wp-content/plugins/piecemaker/";
					$pm->path_to_assets = get_bloginfo('wpurl')."/wp-includes/";
					$pm->piecemakerSWF = get_bloginfo('wpurl')."/wp-content/plugins/piecemaker/swf/piecemaker.swf"; 
					$pm->piecemakerJS = get_bloginfo('wpurl')."/wp-content/plugins/piecemaker/js/JavaScriptFlashGateway.js";
					$pm->piecemakerGateway = get_bloginfo('wpurl')."/wp-content/plugins/piecemaker/swf/JavaScriptFlashGateway.swf";
					$pm->width = "940";
					$pm->height = "360";
				}
				echo $pm->replaceBooks($atts);

			}break;

			default: TiAdminPanel::Flashmo($atts); break;
		}
		 
		 
		
		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $new_instance;

		/* Strip tags (if needed) and update the widget settings. */
		
		
		return $instance;
	}
	
	function form( $instance ) {

		$defaults = array( 'slider_type' => 'mazine', 'gallery_id' => 1);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'gallery_id' ); ?>">Gallery id (Either NextGen or Piecemaker):</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'gallery_id' ); ?>" name="<?php echo $this->get_field_name( 'gallery_id' ); ?>" value="<?php echo $instance['gallery_id']; ?>" style="width:50px" />
		</p>
		
		<p> 
			<label for="<?php echo $this->get_field_id( 'slider_type' ); ?>">Which slider:</label>
			<select id="<?php echo $this->get_field_id( 'slider_type' ); ?>" name="<?php echo $this->get_field_name( 'slider_type' ); ?>" >
				<option value="flashmo" <?php if ($instance['slider_type']  == 'flashmo') echo 'selected'; ?> >Flashmo slider</option>
				<option value="piecemaker" <?php if ($instance['slider_type'] == 'piecemaker') echo 'selected'; ?> >Piecemaker 2 slider</option>
				<option value="coin" <?php if ($instance['slider_type']  == 'coin') echo 'selected'; ?> >Coin slider</option>
				
			</select>
		</p>
				
			<?php
	}
	
	
	
}




?>