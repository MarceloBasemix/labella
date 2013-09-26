<?php

/*  	
* Google Maps with address widget
* Allows to show contact information including address and shows the location specified in address on the map 
*/	
	
	class Googaddress_Widget extends WP_Widget {  
	    function Googaddress_Widget() {  
	        parent::WP_Widget(false, 'Address with Google Maps');  
	    }  
		
		function form($instance) {  
	        $defaults = array( 'title' => 'Location' );
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

			<?php
	    }  
		
		function update($new_instance, $old_instance) {  
	       
	        return $new_instance;  
	    }  
		
		function widget($args, $instance) {  
	    
	        extract( $args );

			$title = apply_filters('widget_title', $instance['title'] );
			echo $before_widget;
			
			
			if ( $title )
				echo $before_title . $title . $after_title;
				
				?>
				<dl class="address">
						<?php $add = get_option('caddress'); if($add != '' ) : ?> <dt><?php _e('Address:')?> </dt><dd><?php echo $add; ?></dd><?php endif; ?>
						<?php $ph = get_option('cphone'); if($ph != '' ) : ?> <dt><?php _e('Phone:')?> </dt><dd><?php echo $ph; ?></dd><?php endif; ?>
						<?php $fx = get_option('cfax'); if($fx != '' ) : ?> <dt><?php _e('Fax:')?> </dt><dd><?php echo $fx; ?></dd><?php endif; ?>
						<?php $email = get_option('cgemail'); if($email != '' ) : ?> <dt><?php _e('E-mail:')?> </dt><dd><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></dd><?php endif; ?>
					</dl>
				
				<div id="map">
					<div id="map_canvas">
						
					</div>
				</div>
				<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    	<script>
    		try { mazineTheme.googleMapsContacts('<?php echo get_option('caddress'); ?>', 'map_canvas'); } catch(error){}
		</script>
				
				<?php
			
			echo $after_widget;

	    }  
	} 


register_widget('Googaddress_Widget');  
?>