<?php //echo "<br/>wpsc-products_page"; ?>
<style>
	#execphp-5 {
		margin-left: -1.5px;
	}
	
#execphp-4 .widget-2 {
	margin-left: -1.5px !important;
	background: none;	
}	
</style>



<?php

global $wp_query;	

$url_atual = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
 
 ?>

 <?php
 
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
<?php /*if(wpsc_has_breadcrumbs()): ?>
<div class="space"><?php wpsc_output_breadcrumbs(); ?></div>
<?php endif; */?>
<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>

	<?php if(wpsc_display_categories()): ?>

	<?php endif; ?>
	
	<?php if(wpsc_display_products() ): ?>
		
		
		<?php if(wpsc_is_in_category() ) : ?>
		
		<?php if(wpsc_show_category_thumbnails() || wpsc_show_category_description()): ?>
		<div class="box border"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
			<div class="wpsc_category_details">
				<?php if(wpsc_show_category_thumbnails()) : ?>
					<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
				<?php endif; ?>
				
				<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
					<?php echo wpsc_category_description(); ?>
				<?php endif; ?>
		</div></div></div></div></div></div></div></div>
			</div><!--close wpsc_category_details-->
			<?php endif; ?>
		<?php endif; ?>
		
		<div class="clear"></div>
		
		<?php if (wpsc_product_count() != 0) :?>
		<?php if(wpsc_is_in_category() ) : ?>
		
		<div class="title border">
					<h2 class="category-title"><?php echo wpsc_current_category_name(); ?></h2>


					<div class="pager">

					<form id="variacoes" action="<?php echo $url_atual; ?>" method="GET" class="product_search">


						<div id="combo_ordenacao">


								<div class="wpsc-products-per-page">
		
									<?php 
					
										if (empty($_REQUEST['items_per_page'])){$select10 = "selected";}
										if ($_REQUEST['items_per_page']== 10){$select10 = "selected";}
										if ($_REQUEST['items_per_page']== 20){$select20 = "selected";}
										if ($_REQUEST['items_per_page']== 50){$select50 = "selected";}
										if ($_REQUEST['items_per_page']== 'all'){$select_all = "selected";}
									
									?>
										<span>Mostrar:</span>
										
										<select id="items_per_page" name="items_per_page">
											<option value="10" <?php echo $select10; ?>>10 por pagina</option>
											<option value="20" <?php echo $select20; ?>>20 por pagina</option>
											<option value="50" <?php echo $select50; ?>>50 por pagina</option>
											<option value="all" <?php echo $select_all; ?>>Todos</option>
										</select>
									</div>
									
						</div>




						<div id="combo_ordenacao">


							<?php 
			
								if (empty($_REQUEST['product_order'])){$select_order_asc = "selected";}
								if ($_REQUEST['product_order']== 'ASC'){$select_order_asc = "selected";}
								if ($_REQUEST['product_order']== 'DESC'){$select_order_desc = "selected";}
							
							?>

						
							<div class="wpsc-products-per-page">
								<span>Ordenar:</span>
								<select id="product_order" name="product_order">
									<option value="ASC" <?php echo $select_order_asc; ?>>Ascendente</option>
									<option value="DESC" <?php echo $select_order_desc; ?>>Descendente</option>
								</select>
							</div>


						</div>
						
						<div id="combo_ordenacao">Visualizar por:
							<select id="view_type" name="view_type">
								<?php
								
									if ($_REQUEST['view_type']== 'grid'){$grid_select = "selected";}
									if ($_REQUEST['view_type']== 'list'){$list_select = "selected";}
								
								?>
								<option value="grid" <?php echo $grid_select; ?>>Coluna</option>
								<option value="list" <?php echo $list_select; ?>>Lista</option>
							</select>
						</div>

				</form>
						
						<script type="text/javascript">
						
							$(function() {
							    $('#product_order').change(function() {
							        this.form.submit();
							    });
							});
							
																		
							$(function() {
							    $('#items_per_page').change(function() {
							        this.form.submit();
							    });
							});						

	
							$('#view_type').change(function() {
							    //alert($(this).val());
							 
								if($(this).val()== 'list'){
									$('.grid').removeClass('grid').addClass('list');
						        }else{
									 $('.list').removeClass('list').addClass('grid');
								}
							 });
						
						</script>


							

						
					</div>
					
					
					
					
					
					
					
					
					
					
				</div>
		
	<?php else: ?>
	
		<div class="title border">
					<h2 class="category-title"><?php echo __('All products', 'mazine'); ?></h2>
					<div class="pager">
						<div id="view_switcher" class="list_view"><?php echo __('list view', 'mazine') ?></div>
						
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
					<?php /*echo wpsc_the_product_description(); ?>
					
					<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
					<?php	$action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
					<?php else: ?>
					<?php	$action =  htmlentities(wpsc_this_page_url(),ENT_QUOTES); ?>				
					<?php endif; ?>
					
						<?php  do_action('wpsc_product_addon_after_descr', wpsc_the_product_id()); ?>
						
						<?php /** the custom meta HTML and loop */ /*?>
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
						<?php //echo wpsc_product_comment_link();	?>
						
						
						<?php /** the variation group HTML and loop */ /*?>
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
						</div> */ ?>	
						
						<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
					<?php /*if(wpsc_has_multi_adding()): ?>
						<label class='wpsc_quantity_update' for='wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]'><?php echo __('Quantity', 'wpsc'); ?>:</label>						
						<input type="text" id='wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]' name="wpsc_quantity_update" size="2" value="1"/>
						<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
						<input type="hidden" name="wpsc_update_quantity" value="true"/>
					<?php endif; */?>
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
						<div class="action" style="position:relative !important;">
								
							
						
							
                                                    <div class="wpsc_product_price" <?php if(!wpsc_product_has_stock()){echo 'style="height:20px !important;"';} ?>>
								<?php if( wpsc_show_stock_availability() ): ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'wpsc'); ?></div>
									<?php else: ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'wpsc'); ?></div>
									<?php endif; ?>
								<?php endif; ?>
								<?php if(wpsc_product_is_donation()) : ?>
									<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'wpsc'); ?>: </label>
									<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />

								<?php else : ?>
									<?php if(wpsc_product_on_special()) : ?>
										<?php echo '<style>
											p.pricedisplay{
												display:block;
												margin:0px 20px 0 0 !important;
											}
											
										</style>';
									?>
																		
	                                                                      <?php if(wpsc_product_has_stock()) : ?>
																		<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('', 'wpsc'); ?>
																			<span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span></p>
                                                                         <?php endif; ?>
                                                                                    
                                                                        <?php endif; ?>
                                                                                <?php if(wpsc_product_has_stock()) : ?>
                                                                                    <p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('','wpsc'); ?>
                                                                                    	<span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><?php echo wpsc_the_product_price(); ?></span></p>
                                                                                <?php endif; ?>
                                                                         <?php /*if(wpsc_product_on_special()) : ?>
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('You save', 'wpsc'); ?>: <span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span></p>
									<?php endif;*/ ?>
									
									<!-- multi currency code -->
									<?php if(wpsc_product_has_multicurrency()) : ?>
	                                	<?php echo wpsc_display_product_multicurrency(); ?>
                                    <?php endif; ?>
									
									<?php if(wpsc_show_pnp()) : ?>
                                                                        
                                                                              
                                                                                   <p class="pricedisplay"><?php _e('Shipping', 'wpsc'); ?>:<span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
                                                                              
                                                                          <?php endif; ?>							
								<?php endif; ?>
							</div><!--close wpsc_product_price-->
                                                      
						
						
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
                                                            <div id="soldoutNovo" align="center">
                                                              <p class='soldout'><?php echo __('This product has sold out.', 'wpsc'); ?></p>
                                                                <br/><br/>
                                                                
                                                                <?php nostock_add_button_simples(); ?>
                                                                
                                                            </div>
							<?php endif ; ?>
						<?php endif ; ?>
					</div>
					</form>
				
				
					
				  <?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
						<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
					<?php endif ; ?>
					
					<?php echo wpsc_product_rater(); ?>
									
		</li>
	<?php endwhile; ?>
	</ul>
	</div>
	<?php endif; ?>
		<?php /** end the product loop here */?>
		<?php if(wpsc_product_count() == 0):?>
		<div class="title">	
			<h3><?php  _e('There are no products in this group.', 'wpsc'); ?></h3>
		</div>
		<?php endif ; ?>
	    <?php do_action( 'wpsc_theme_footer' ); ?> 	

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="pages"> <ol>
				<?php mazine_wpsc_pagination(); ?>
				
			</ol></div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close default_products_page_container-->
