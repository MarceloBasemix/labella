<?php echo "<br/>wpsc-grid_view"; ?>
<?php

global $wp_query;	

/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
 
 
 if (!function_exists('mazine_wpsc_pagination')){
function mazine_wpsc_pagination($totalpages = '', $per_page = '', $current_page = '', $page_link = '') {
	global $wp_query;
	$num_paged_links = 4; //amount of links to show on either side of current page
	
	$additional_links = '';
	
	//additional links, items per page and products order
	if( get_option('permalink_structure') != '' ){
		$additional_links_separator = '?';
	}else{
		$additional_links_separator = '&';
	}
	if( !empty( $_GET['items_per_page'] ) ){
			$additional_links = $additional_links_separator . 'items_per_page=' . $_GET['items_per_page'];
			$additional_links_separator = '&';
	}
	if( !empty( $_GET['product_order'] ) )
		$additional_links .= $additional_links_separator . 'product_order=' . $_GET['product_order'];
		
	$additional_links = apply_filters('wpsc_pagination_additional_links', $additional_links);
	//end of additional links
	
	if(empty($totalpages)){
			$totalpages = $wp_query->max_num_pages;	
	}
	if(empty($per_page))	
		$per_page = (int)get_option('wpsc_products_per_page');

	$current_page = absint( get_query_var('paged') );	
	if($current_page == 0)
		$current_page = 1;

	if(empty($page_link))
		$page_link = wpsc_a_page_url();
		
	//if there is no pagination	
	if(!get_option('permalink_structure')) {
		$category = '?';
		if(isset($wp_query->query_vars['wpsc_product_category']))
			$category = '?wpsc_product_category='.$wp_query->query_vars['wpsc_product_category'];
		if(isset($wp_query->query_vars['wpsc_product_category']) && is_string($wp_query->query_vars['wpsc_product_category'])){

			$page_link = get_option('blogurl').$category.'&amp;paged';
		}else{
			$page_link = get_option('product_list_url').$category.'&amp;paged';
		}

		$separator = '=';
	}else{
		// This will need changing when we get product categories sorted
		if(isset($wp_query->query_vars['wpsc_product_category']))
			$page_link = trailingslashit(get_option('product_list_url')).$wp_query->query_vars['wpsc_product_category'].'/';
		else
			$page_link = trailingslashit(get_option('product_list_url'));
		
		$separator = 'page/';
	}

	// If there's only one page, return now and don't bother
	if($totalpages == 1) 
		return;
	// Pagination Prefix
	//$output = __('Pages: ','wpsc');
	
	if(get_option('permalink_structure')){
		// Should we show the FIRST PAGE link?
		if($current_page > 1)
			$output .= "<li><a href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . __('First Page', 'wpsc') . "\">" . __('&laquo; First', 'wpsc') . "</a></li>";
	
		// Should we show the PREVIOUS PAGE link?
		if($current_page > 1) {
			$previous_page = $current_page - 1;
			if( $previous_page == 1 )
				$output .= "<li> <a href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('&lt; Previous', 'wpsc') . "</a></li>";
			else
				$output .= "<li><a href=\"". esc_url( $page_link .$separator. $previous_page . $additional_links ) . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('&lt; Previous', 'wpsc') . "</a></li>";
		}
		$i =$current_page - $num_paged_links;
		$count = 1;
		if($i <= 0) $i =1;
		while($i < $current_page){
			if($count <= $num_paged_links){
				if($count == 1)
					$output .= "<li> <a href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a></li>";
				else
					$output .= "<li><a href=\"". esc_url( $page_link .$separator. $i . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a></li>";
			}
			$i++;
			$count++;
		}
		// Current Page Number	
		if($current_page > 0)
			$output .= "<li><a class='selected'>$current_page</a></li>";
	
		//Links after Current Page
		$i = $current_page + $num_paged_links;
		$count = 1;
	
		if($current_page < $totalpages){
			while(($i) > $current_page){
		
				if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
						$output .= "<li><a href=\"". esc_url( $page_link .$separator. ($count+$current_page) .$additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), ($count+$current_page) ) . "\">".($count+$current_page)."</a></li>";		
				$i++;
				}else{
				break;
				}
				$count ++;
			}
		}
		
		if($current_page < $totalpages) {
			$next_page = $current_page + 1;
			$output .= "<li><a href=\"". esc_url( $page_link  .$separator. $next_page . $additional_links ) . "\" title=\"" . __('Next Page', 'wpsc') . "\">" . __('Next &gt;', 'wpsc') . "</a></li>";
		}
		// Should we show the LAST PAGE link?
		if($current_page < $totalpages) {
			$output .= "<li><a href=\"". esc_url( $page_link  .$separator. $totalpages . $additional_links ) . "\" title=\"" . __('Last Page', 'wpsc') . "\">" . __('Last &raquo;', 'wpsc') . "</a></li>";
		}
	} else {
		// Should we show the FIRST PAGE link?
		if($current_page > 1)
			$output .= "<li><a href=\"". remove_query_arg('paged' ) . "\" title=\"" . __('First Page', 'wpsc') . "\">" . __('&laquo; First', 'wpsc') . "</a></li>";

		// Should we show the PREVIOUS PAGE link?
		if($current_page > 1) {
			$previous_page = $current_page - 1;	
			if( $previous_page == 1 )
				$output .= "<li><a href=\"". remove_query_arg( 'paged' ) . $additional_links . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('&lt; Previous', 'wpsc') . "</a></li>";
			else
				$output .= "<li><a href=\"". add_query_arg( 'paged', ($current_page - 1) ) . $additional_links . "\" title=\"" . __('Previous Page', 'wpsc') . "\">" . __('&lt; Previous', 'wpsc') . "</a></li>";
		}
		$i =$current_page - $num_paged_links;
		$count = 1;
		if($i <= 0) $i =1;
		while($i < $current_page){
			if($count <= $num_paged_links){
				if($i == 1)
					$output .= "<li><a href=\"". remove_query_arg('paged' ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a></li>";
				else
					$output .= "<li><a href=\"". add_query_arg('paged', $i ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), $i ) . " \">".$i."</a></li>";
			}
			$i++;
			$count++;
		}
		// Current Page Number	
		if($current_page > 0)
			$output .= "<li><a class='selected'>$current_page</a></li>";
	
		//Links after Current Page
		$i = $current_page + $num_paged_links;
		$count = 1;
	
		if($current_page < $totalpages){
			while(($i) > $current_page){
		
				if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
						$output .= "<li><a href=\"". add_query_arg( 'paged', ($count+$current_page) ) . "\" title=\"" . sprintf( __('Page %s', 'wpsc'), ($count+$current_page) ) . "\">".($count+$current_page)."</a></li>";		
				$i++;
				}else{
				break;
				}
				$count ++;
			}
		}
		
		if($current_page < $totalpages) {
			$next_page = $current_page + 1;
			$output .= "<li><a href=\"". add_query_arg( 'paged', $next_page ) . "\" title=\"" . __('Next Page', 'wpsc') . "\">" . __('Next &gt;', 'wpsc') . "</a></li>";
		}
		// Should we show the LAST PAGE link?
		if($current_page < $totalpages) {
			$output .= "<li><a href=\"". add_query_arg( 'paged', $totalpages ) . "\" title=\"" . __('Last Page', 'wpsc') . "\">" . __('Last &raquo;', 'wpsc') . "</a></li>";
		}
	}
	// Return the output.
	echo $output;
}
}
?>

<div id="default_products_page_container" class="wrap wpsc_container">
<?php if(wpsc_has_breadcrumbs()): ?>
<div class="space"><?php wpsc_output_breadcrumbs(); ?></div>
<?php endif; ?>
<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>

	<?php if(wpsc_display_categories()): ?>
	  <?php if(wpsc_category_grid_view()) :?>
			<div class="wpsc_categories wpsc_category_grid group">
				<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
					
				
				<div class="single_cat_view" style="float:left; margin-left:0; margin-bottom:10px;">

			
					
					<h5><a href="<?php wpsc_print_category_url();?>" class="  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a></h5>
					
					<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
						<?php wpsc_print_category_image(get_option('category_image_width'),get_option('category_image_height')); ?>
					</a>
					
				</div>
	
					<?php wpsc_print_subcategory("", ""); ?>
				
				
				<?php wpsc_end_category_query(); ?>
				
			</div><!--close wpsc_categories-->
	  <?php else:?>
			
			<ul class="wpsc_cats_list">
				<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
						<li>
						
						<?php if (get_option('show_category_thumbnails') == 1) : ?>
						<div class="single_cat_view">
						<?php endif; ?>
							<h5><a href="<?php wpsc_print_category_url();?>" class="<?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a></h5>
							
							<a href="<?php wpsc_print_category_url();?>" class="<?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_image(get_option('category_image_width'), get_option('category_image_height')); ?>
							</a>
							
						<?php if (get_option('show_category_thumbnails') == 1) : ?></div><?php endif; ?>	
							<?php if(wpsc_show_category_description()) :?>
								<?php wpsc_print_category_description("<div class='single_cat_description'>", "</div>"); ?>				
							<?php endif;?>
	<div class="clear"></div>
						
						
						<?php // wpsc_print_subcategory("<ul>", "</ul>"); ?>
						</li>
				<?php wpsc_end_category_query(); ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
<?php // */ ?>
	
	<?php if(wpsc_display_products()): ?>
		
		
		<?php if(wpsc_is_in_category()) : ?>
			<div class="wpsc_category_details">
				<?php if(wpsc_show_category_thumbnails()) : ?>
					<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
				<?php endif; ?>
				
				<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
					<?php echo wpsc_category_description(); ?>
				<?php endif; ?>
			</div><!--close wpsc_category_details-->
		<?php endif; ?>
		
		
		<?php if(wpsc_is_in_category()) : ?>		
		
		
		<div class="title border">
					<h2 class="category-title"><?php echo wpsc_current_category_name(); ?></h2>
					<div class="pager">
						<div id="view_switcher" class="list_view">
							
							list view</div>
						<a href="#" id="mostrar_grid">Grade</a>|<a href="#" id="mostrar_lista">Lista</a>


						<script>
							
								 $('#mostrar_lista').click(function(event){
									 event.preventDefault();
									 $('.grid').removeClass('grid').addClass('list');
								 });
							 
							
							
								 $('#mostrar_grid').click(function(event){
									 event.preventDefault();
									 $('.list').removeClass('list').addClass('grid');
								 });
						</script>

							

						
					</div>
				</div>
		
	<?php else: ?>
	
		<div class="title border">
					<h2 class="category-title"><?php echo _('All products'); ?></h2>
					<div class="pager">
						<div id="view_switcher" class="list_view">list view</div>
					</div>
				</div>
	
	<?php endif; ?>
		
		
		<?php if(wpsc_has_pages_top()) : ?>
			<div class="pages"><ol>
				<?php mazine_wpsc_pagination(); ?>
				
			</ol></div><!--close wpsc_page_numbers_?-->
		<?php endif; ?>		
		
	
	
		<?php /** start the product loop here */?>
		<div id="products" class="grid">
					<ul>
		
	<?php while (wpsc_have_products()) :  wpsc_the_product(); $i++; ?>
				<li class="item <?php if(!($i%3)) echo 'last'; ?> productcol" >
				<form class='product_form'  enctype="multipart/form-data" action="<?php if ($action != "" ) echo $action; else echo "#" ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
				<?php if(get_option('show_thumbnails')) :?>
						<?php echo wpsc_edit_the_product_link(); ?>
						<?php if(wpsc_the_product_thumbnail()) :?>
							<a rel="<?php echo str_replace(array(" ", '"',"'", '&quot;','&#039;'), array("_", "", "", "",''), wpsc_the_product_title()); ?>" class="product-image" href="<?php echo wpsc_the_product_permalink(); ?>">
								<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>"/>
							</a>
						<?php else: ?>
							<div class="item_no_image">
								<a href="<?php echo wpsc_the_product_permalink(); ?>">
								<span><?php _e('No Image Available'); ?></span>
								</a>
							</div>
						<?php endif; ?>
					
				<?php endif; ?>
				
				
					<h3 class="product-name">
					  <?php if(get_option('hide_name_link') == 1) : ?>
							<span><?php echo wpsc_the_product_title(); ?></span>
						<?php else: ?> 
							<a href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
						<?php endif; ?> 				

						
					</h3>
						<?php							
							do_action('wpsc_product_before_description', wpsc_the_product_id(), $wpsc_query->product);
							do_action('wpsc_product_addons', wpsc_the_product_id());
						?>
						
					
					
					<div class="product-desc">
					<?php echo wpsc_the_product_description(); ?>
					
					<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
					<?php	$action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
					<?php else: ?>
					<?php	$action =  htmlentities(wpsc_this_page_url(),ENT_QUOTES); ?>				
					<?php endif; ?>
					
						<?php do_action('wpsc_product_addon_after_descr', wpsc_the_product_id()); ?>
						
						<?php /** the custom meta HTML and loop */?>
						<div class="custom_meta">
							<?php while (wpsc_have_custom_meta()) : wpsc_the_custom_meta(); 	
									if (stripos(wpsc_custom_meta_name(),'g:') !== FALSE){
										continue;
									}
									?>
								<strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?><br />
							<?php endwhile; ?>
						</div>
						<?php /** the custom meta HTML and loop ends here */?>
						
						<?php /** add the comment link here */?>
						<?php echo wpsc_product_comment_link();	?>
						
						
						<?php /** the variation group HTML and loop */?>
						<div class="wpsc_variation_forms">
							<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
								<p>
									<label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label>
									<select class='wpsc_select_variation' name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
									<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
										<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?> ><?php echo wpsc_the_variation_name(); ?></option>
									<?php endwhile; ?>
									</select> 
								</p>
							<?php endwhile; ?>
						</div>
						
						<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
					<?php if(wpsc_has_multi_adding()): ?>
						<label class='wpsc_quantity_update' for='wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]'><?php echo __('Quantity', 'wpsc'); ?>:</label>						
						<input type="text" id='wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]' name="wpsc_quantity_update" size="2" value="1"/>
						<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
						<input type="hidden" name="wpsc_update_quantity" value="true"/>
					<?php endif ;?>
					</div>
					
					
					<?php /*?><?php if(wpsc_the_product_additional_description()) : ?>
					<div class='additional_description_span'>
						<a href='<?php echo wpsc_the_product_permalink(); ?>' class='additional_description_link'>
							<img class='additional_description_button'  src='<?php echo WPSC_URL; ?>/images/icon_window_expand.gif' title='Additional Description' alt='Additional Description' /><?php echo __('More Details', 'wpsc'); ?>
						</a>
						<div class='additional_description'><br />
							<?php
								$value = '';
								$the_addl_desc = wpsc_the_product_additional_description();
								if( is_serialized($the_addl_desc) ) {
									$addl_descriptions = @unserialize($the_addl_desc);
								} else {
									$addl_descriptions = array('addl_desc'=> $the_addl_desc);
								}
								
								if( isset($addl_descriptions['addl_desc']) ) {
									$value = $addl_descriptions['addl_desc'];
								}
							
								if( function_exists('wpsc_addl_desc_show') ) {
									echo wpsc_addl_desc_show( $addl_descriptions );
								} else {
									echo stripslashes( wpautop($the_addl_desc, $br=1));
								}
							?>
						</div>
						<br />
					</div>
					<?php endif; ?>
					<?php */ ?>
					
					
						<?php /** the variation group HTML and loop ends here */?>
						<div class="action">
								
							
						
							<?php if(wpsc_product_is_donation()) : ?>
								<br/>
								<label for='donation_price_<?php echo wpsc_the_product_id(); ?>'><?php echo __('Donation', 'wpsc'); ?>:</label>
								<input type='text' id='donation_price_<?php echo wpsc_the_product_id(); ?>' name='donation_price' value='<?php echo $wpsc_query->product['price']; ?>' size='6' />
								<br />
							
							
							<?php else : ?>
								<div class="price-box">
								<?php if(wpsc_product_on_special()) : ?>
									<del class='oldprice'><?php echo wpsc_product_normal_price(get_option('wpsc_hide_decimals')); ?></del>
								<?php endif; ?>
								 <?php echo wpsc_the_product_price(get_option('wpsc_hide_decimals')); ?>
								
								</div>					
							<?php endif; ?>
						
						
						<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
				
						<!-- END OF QUANTITY OPTION -->
						<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
							<?php if(wpsc_product_has_stock()) : ?>
								<div class='wpsc_buy_button_container'>
																			<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
										<?php	$action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
										<button class="wpsc_buy_button reverse" onclick='gotoexternallink("<?php echo $action; ?>")'><span><span><?php echo __('Buy Now', 'wpsc'); ?></span></span></button>
										<?php else: ?>
										
										<button id='product_<?php echo wpsc_the_product_id(); ?>_submit_button' class="reverse wpsc_buy_button"><span><span><?php echo __('Add To Cart', 'wpsc'); ?></span></span></button>
										<?php endif; ?>
										<div class='wpsc_loading_animation'>
										<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" class="loadingimage"/>
										<?php echo __('Updating cart...', 'wpsc'); ?>
									</div>
								</div>
							<?php else : ?>
								<br class="clear"/>
								<p class='soldout'><?php echo __('This product has sold out.', 'wpsc'); ?></p>
							<?php endif ; ?>
						<?php endif ; ?>
					</div>
					</form>
				
				
					
				  <?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
						<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
					<?php endif ; ?>
					
					<?php echo wpsc_product_rater(); ?>
					<?php
						if(function_exists('gold_shpcrt_display_gallery')) :					
							echo gold_shpcrt_display_gallery(wpsc_the_product_id(), true);
						endif;
						?>
				
		</li>
	<?php endwhile; ?>
	</ul>
	</div>
		<?php /** end the product loop here */?>
		<?php if(wpsc_product_count() == 0):?>
		<div class="title">
			<h3><?php  _e('There are no products in this group.', 'wpsc'); ?></h3>
		</div>
		<?php endif ; ?>
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="pages"><ol>
				<?php mazine_wpsc_pagination(); ?>
				
			</ol></div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close default_products_page_container-->
