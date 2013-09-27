<?php

if(!wpsc_product_has_stock()){ ?>
<style>
    #soldoutNovo {
        margin-top: -30px !important;
		margin-left: 50px !important;        
    }
</style>

<?php
}


//-----Customized Function-------------------------------



function mazine_wpsc_output_breadcrumbs($options = Array()) {
	$products_page_id = wpec_get_the_post_id_by_shortcode('[productspage]');
	$products_page = get_post($products_page_id);
	if(!wpsc_has_breadcrumbs()){	
		return;
	}
	$filtered_products_page = array(
			'url' => get_option('product_list_url'),
			'name' => $products_page->post_title
		);
	$filtered_products_page = apply_filters('wpsc_change_pp_breadcrumb', $filtered_products_page);
	// If home if the same as products apge only show the products-page link and not the home link
	if(get_option('page_on_front') != $products_page_id){
		echo isset($options['before-breadcrumbs']) ? $options['before-breadcrumbs'] : '<div class="breadcrumb">';
		echo isset($options['before-crumb']) ? $options['before-crumb'] : '';
		echo '<strong>Você está em:</strong>  <a class="wpsc-crumb" id="wpsc-crumb-home" href="'.get_option('home').'">'.get_option('blogname').'</a>';
		echo isset($options['after-crumb']) ? $options['after-crumb'] : '';
	
		echo isset($options['crumb-separator']) ? $options['crumb-separator'] : ' &raquo; ';
	}	
	echo isset($options['before-crumb']) ? $options['before-crumb'] : '';
	echo '<a class="wpsc-crumb" id="wpsc-crumb-'.$products_page_id.'" href="'.$filtered_products_page['url'].'">'.$filtered_products_page['name'].'</a>';
	echo isset($options['after-crumb']) ? $options['after-crumb'] : '';


	while (wpsc_have_breadcrumbs()) {
		wpsc_the_breadcrumb(); 
		echo isset($options['crumb-separator']) ? $options['crumb-separator'] : ' &raquo; ';
		echo isset($options['before-crumb']) ? $options['before-crumb'] : '';
		if(wpsc_breadcrumb_url()) {
			echo '<a class="wpsc-crumb" id="wpsc-crumb-'.wpsc_breadcrumb_slug().'" href="'.wpsc_breadcrumb_url().'">'.wpsc_breadcrumb_name().'</a>';
		} else {
		 echo '<span class="wpsc-crumb" id="wpsc-crumb-'.wpsc_breadcrumb_slug().'">' . wpsc_breadcrumb_name() . '<span>';
		?>
			
		<?php
		}
		echo isset($options['after-crumb']) ? $options['after-crumb'] : '';
	}
	if (isset($options['after-breadcrumbs'])) {
		echo $options['after-breadcrumbs'];
	} else {
		echo '</div>';
	}
}


?>


<?php //echo "<br/>wpsc-single_product"; ?>
<?php
mazine_wpsc_output_breadcrumbs();
?>

<div class="fance">
<?php
global $wpsc_query, $wpdb;
$image_width = get_option('single_view_image_width');
$image_height = get_option('single_view_image_height');
?>



<?php
		// Breadcrumbs
		// Plugin hook for adding things to the top of the products page, like the live search
		do_action( 'wpsc_top_of_products_page' );
?>







<div id='products_page_container' class="wrap wpsc_container space">

	
	<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
	
	<div class="productdisplay">
	<?php /** start the product loop here, this is single products view, so there should be only one */?>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
			<div class="single_product_display product_view_<?php echo wpsc_the_product_id(); ?>">
				<div class="">
				<?php if(get_option('show_thumbnails')) :?>
					<div class="image_container imagecol">
						<?php if ( wpsc_the_product_thumbnail() ) : ?>
								<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
									<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(get_option('product_image_width'),get_option('product_image_height'),'','single'); ?>"/>
								</a>
								<?php 
								if ( function_exists( 'gold_shpcrt_display_gallery' ) )
									echo gold_shpcrt_display_gallery( wpsc_the_product_id() );
								?>
						<?php else: ?>
									<a href="<?php echo wpsc_the_product_permalink(); ?>">
									<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />
									</a>
						<?php endif; ?>
					</div>
				<?php endif; ?> 
		
					<div class="producttext">


							<div class="title border_prod">
								<h2 class="category-title"><?php echo wpsc_the_product_title(); ?></h2>
							</div>						
						
							<?php				
								do_action('wpsc_product_before_description', wpsc_the_product_id(), $wpsc_query->product);
							?>
						
						<h5><?php //echo _('Short Description');  ?></h5>
						
						
						
						
						<h5><?php //echo _('Additional Product Information'); ?></h5>
						<div class="wpsc_description">
            <?php
							$value = '';
							$the_addl_desc1 = wpsc_the_product_additional_description();
                                                        $the_addl_desc =  string_limit_words($the_addl_desc1,30);   
                                                        
							if( is_serialized($the_addl_desc) ) {
								$addl_descriptions = @unserialize($the_addl_desc);
							} else {
								$addl_descriptions = array('addl_desc', $the_addl_desc);
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
                                                
 <?php /*if (wpsc_product_has_stock()) : ?>                                               
 <div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php echo wpsc_this_page_url(); ?>" addthis:title="<?php echo wpsc_the_product_title(); ?>">
    <a class="addthis_button_facebook at300b" title="Facebook" href="#"><span class=" at300bs at15nc at15t_facebook"><span class="at_a11y">Share on facebook</span></span></a>
    <a class="addthis_button_twitter at300b" title="Tweet" href="#"><span class=" at300bs at15nc at15t_twitter"><span class="at_a11y">Share on twitter</span></span></a>
    <a class="addthis_button_email at300b" target="_blank" title="Email" href="#"><span class=" at300bs at15nc at15t_email"><span class="at_a11y">Share on email</span></span></a>
    <a class="addthis_button_compact at300m" href="#"><span class=" at300bs at15nc at15t_compact"><span class="at_a11y">More Sharing Services</span></span></a>
    <a class="addthis_counter addthis_bubble_style" href="#" style="display: inline-block;"></a>
<div class="atclear"></div></div>
  

<?php endif; */?>



<?php if (wpsc_have_variation_groups()) { ?>
<style>
	 #nao_estoque {
		width: 295px;
		margin-left: -50px;
		float: left;
		position: relative;
		margin-top: 0px !important;
	}
</style>

<?php } ?>
                                                
                                                </div>
                                                
                                            
                                                
                                                
						
							
							
							<?php if (!wpsc_have_variation_groups()) { ?>
								<form class="product_form mazine_product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>" >
							<?php } ?>
						
							<?php if ( wpsc_product_has_supplied_file() ) : ?>

								<fieldset class="custom_file">
									<legend><?php _e( 'Upload a File', 'wpsc' ); ?></legend>
									<p><?php _e( 'Select a file from your computer to include with this purchase.', 'wpsc' ); ?></p>
									<input type="file" name="custom_file" />
								</fieldset>
							<?php endif; ?>	





<?php if (!wpsc_have_variation_groups()) { 
							/**
							 * Quantity options - MUST be enabled in Admin Settings
							 */
							?>
							<?php if(wpsc_has_multi_adding()): ?>
								<?php if(wpsc_product_has_stock()){  ?>
	                                 <fieldset style="color: #960d5d;position: relative;float: right;width: 130px;padding-top: 40px;">
	                                 <legend style="float:left;margin-left:15px;"><?php _e('Quantity', 'wpsc'); ?>:&nbsp;</legend>
	                                 <div class="wpsc_quantity_update" style="height: 30px; margin-top: -10px;">
									<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" style="width: 25px; padding: 1px !important;" />
									<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
									<input type="hidden" name="wpsc_update_quantity" value="true" />
	                                </div><!--close wpsc_quantity_update-->
	                                </fieldset>
	                                <?php } ?>
							<?php endif;?>
							
<?php } ?>							
							<div class="wpsc_product_price2" style="margin-top: -22px;">
								<?php if(wpsc_show_stock_availability()): ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'wpsc'); ?></div>
									<?php else: ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'wpsc'); ?></div>
									<?php endif; ?>
								<?php endif; ?>	
								<?php /*if(wpsc_product_is_donation()) : ?>
									<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', 'wpsc'); ?>: </label>
									<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />
								<?php else :*/ ?>

								
								<!--  INSERE PREÇO COM OFERTA -->
								
									<?php if(wpsc_product_on_special()) : ?>
										<?php echo '<style>
											p.pricedisplay{
												display:block;
												margin:0px 20px 0 0 !important;
											}
											
										</style>';
									?>
									<?php endif; ?>
								
								
								
								
								
								
								<?php if(wpsc_product_has_stock()){  ?>
									<p class="pricedisplay <?php echo wpsc_the_product_id(); ?>"><?php _e('', 'wpsc'); ?><br/></p>
									
									
									<?php if(wpsc_product_on_special()) : ?>
									<!--  INSERE PREÇO COM OFERTA -->
									<span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>" ><?php echo wpsc_product_normal_price(); ?></span><br/>
									<?php endif; ?>
										 <span  class="currentprice2 pricedisplay2"><?php echo wpsc_the_product_price(); ?></span>
									<?php } ?>
									 <!-- multi currency code -->
                                    <?php if(wpsc_product_has_multicurrency()) : ?>
	                                    <?php echo wpsc_display_product_multicurrency(); ?>
                                    <?php endif; ?>
									<?php if(wpsc_show_pnp()) : ?>
										<p class="pricedisplay"><?php _e('Shipping', 'wpsc'); ?>:<span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
									<?php endif; ?>							
								<?php //endif; ?>
							
							</div><!--close wpsc_product_price-->

							<?php if (!wpsc_have_variation_groups()) {?>
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />
							<?php } ?>					
							<?php if( wpsc_product_is_customisable() ) : ?>
								<input type="hidden" value="true" name="is_customisable"/>
							<?php endif; ?>
							<?php if ( wpsc_product_has_personal_text() ) : ?>
								<br class="clear" />
								<fieldset class="custom_text">
									<legend><?php _e( 'Personalize Your Product', 'wpsc' ); ?></legend>
									<p><?php _e( 'Complete this form to include a personalized message with your purchase.', 'wpsc' ); ?></p>
									<textarea cols='55' rows='5' name="custom_text"></textarea>
								</fieldset>
							<?php endif; ?>
							<?php
							/**
							 * Cart Options
							 */
							?>

							<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container_single_product">
											<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
											<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
											<button class="wpsc_buy_button" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')"><span><span><?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?></span></span></button>
											<?php else: ?>
										
										<?php if (!wpsc_have_variation_groups() && wpsc_product_has_stock()) {?>
											<button id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"><span><span><?php _e('Comprar', 'wpsc'); ?></span></span></button>
										<?php } ?>
										
											<?php endif; ?>
										<div class="wpsc_loading_animation">
											<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
											<?php _e('Updating cart...', 'wpsc'); ?>
										</div><!--close wpsc_loading_animation-->
									</div><!--close wpsc_buy_button_container-->
								<?php else : ?>
									
									
									 <div id="soldoutNovo" align="center" style="width: 250px;float:left;">
                                        <p class='soldout'><?php echo __('This product has sold out.', 'wpsc'); ?></p>
                                           <br/><br/>
                                             
												<?php  /* FORCA AVISE-ME */
												if (!wpsc_have_variation_groups()) { }else{ ?>
																
														<button id="nao_estoque" class="wpsc_buy_button" onclick="window.open('http://www.labellastore.com/backup/wp-content/plugins/nostock/popup/get_email.php?pid=<?php echo wpsc_the_product_id();?>','newWindow','height=500,width=350,top=200,left=300,scrollbars=1'); return false">
															<span style="padding-right: 4px;"><span style="font-size: 12px;">Avise-me quando este produto estiver disponível</span></span>
														</button>
														
														
													
											<?php } ?>
                                       </div>
								
							<?php endif ; ?>
							
							<?php endif ; ?>
							
					<?php if (!wpsc_have_variation_groups()) {?></form><!--close product_form--> <?php } ?>
					<div class="clear"></div>	
					<?php echo wpsc_product_rater(); ?>
					
						
			<?php if(wpsc_show_fb_like()): ?>
	                        <div class="FB_like">
	                        <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo wpsc_the_product_permalink(); ?>&amp;layout=standard&amp;show_faces=true&amp;width=435&amp;action=like&amp;font=arial&amp;colorscheme=light" frameborder="0"></iframe>
	                        </div><!--close FB_like-->
                        <?php endif; ?>
                        
					<!--close productcol-->
                                        
                                        
                                        
<?php /** My variation stuff */ ?>

      <div id="variation-colours">
      	<!-- <div style="margin-top:30px;"></div> -->
        <?php if (wpsc_have_variation_groups()) { ?>
        
        <style>
		    .addthis_toolbox {
		        margin-top: 60px;
		    }
		</style>
		        
        
          <?php $a =0;
          while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
            <?php /** the variation HTML and loop */ ?>
            <?php $skipone = true; ?>
            <?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
              <?php
              $isox = get_term_by('id', wpsc_the_variation_id(), 'wpsc-variation');
              $slugslug = basename(get_permalink()) . '-' . $isox->slug;

              $variation_subs = get_children(array(
                  'post_parent' => wpsc_the_product_id(),
				  'order' => 'ASC'
                      ));
				//echo "<pre>";print_r($variation_subs);echo "</pre>";
				 /*echo "<br/>ID: ";$variation_subs[0][ID];
                                 //echo $variation_subs = get_children('ID');
         		*/
                                 
              foreach ($variation_subs as $variationss) {
                if ($variationss->post_name == $slugslug) {
                  $attached_images = get_children(array(
                      'post_parent' => $variationss->ID,
                      'order' => 'DESC'
                          ));
					//print_r($attached_images);
                  foreach ($attached_images as $image) {
                    $image = array(
                        'URL' => $image->guid,
                        'title' => $image->post_title,
                        'post_parent' => $image->post_parent
                    );
                    
                  }
                }
                
              }
              
              
              /* HACK FEIO :FORÇAR TRAZER AS IMAGENS DE VARIAÇÕES */
              
              $chk_url_image = $image['URL'];

              if (empty($chk_url_image)){
	              
	              $id_produto = wpsc_the_product_id();
	              	
	              $variacao_id = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_parent = $id_produto AND post_type = 'wpsc-product' ORDER BY ID ASC");

	              $variacao_2 = $variacao_id[$a]->ID;

					$img_url= $wpdb->get_results( "SELECT guid FROM $wpdb->posts WHERE post_parent = $variacao_2 AND post_type = 'attachment' and (post_mime_type = 'image/jpeg' or post_mime_type = 'image/png')");
		            
					$image['URL'] = $img_url[0]->guid;
	        
	              
	              
              }
                             ?>
        
			 

              <?php if (!$skipone) { ?>

			<div id="agrupado">
                           
				<form class="product_form mazine_product_form" enctype="multipart/form-data" action="http://www.labellastore.com/products-page/checkout/" method="post" name="<?php echo wpsc_the_variation_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>_<?php echo wpsc_the_variation_id(); ?>" >
              					<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
								<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />
								<input type="hidden" value="<?php echo $image['post_parent']; ?>" name="prodid"/>
								<input type="hidden" value="<?php echo $image['post_parent']; ?>" name="item"/>

								<input type="hidden" value="<?php echo wpsc_the_variation_id(); ?>" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>"/>					
		

                                <div id="agrupado_img">                             	
                                	<img src="<?php echo $image['URL']; ?>" width="100" height="50" class="product_image_variation product_image_<?php echo wpsc_the_variation_id(); ?>" />
                                </div>
                                <div id="agrupado_txt"><?php echo wpsc_the_variation_name(); ?></div>
								<div id="agrupado_txt"><?php echo wpsc_the_variation_price(); ?></div>

								<div id="agrupado_button">

									<button id="product_<?php echo wpsc_the_variation_id(); ?>_button" class="reverse wpsc_buy_button" <?php if (!wpsc_product_has_stock()) { echo "disabled";} ?> >
												<span><span>Adicionar ao Carrinho</span></span>
									</button>
									
								</div>
				
				</form>

			</div>																				
              <?php 
                             
              $a++;
                           
              $variacao_2="";
              $image['URL']="";
                             
                             } $skipone = false; ?>
        
            <?php 
            endwhile; ?>
          <?php endwhile; ?>
        <?php } ?>
</div> <!--close My Variation-->                                         
                                                                               
                                        
                                        
                                        
                                        
                                        
                                        
		<?php if (!wpsc_have_variation_groups()) { ?>
					<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
					</form>
 		<?php } ?>
						
							
						<?php do_action('wpsc_product_addons', wpsc_the_product_id()); ?>




	</div>
	
	
					<?php do_action('wpsc_product_addon_after_descr', wpsc_the_product_id()); ?>
				
					
					
					
					
					<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow') =='1')) : ?>
						<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
					<?php endif ; ?>
					
					
						
						
					
					</div>
		<?php if (!wpsc_have_variation_groups()) { ?>
					<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
					</form>
		<?php } ?>			





						<?php if(wpsc_the_product_additional_description()) : ?>
		

						<?php
							$excerpt =  wpsc_the_product_description(); //Text you want to shorten goes here
							
						?>

						<div class="single_additional_description">
							
							<ul id="tabs">
							    <li><a href="#" name="tab1">Detalhes do Produto</a></li>
							    <li><a href="#" name="tab2">Alguns comentários</a></li>
							    <!--<li><a href="#" name="tab3">Three</a></li>
							    <li><a href="#" name="tab4">Four</a></li> -->   
							</ul>
							
							<div id="content2"> 
							    <div id="tab1"><?php echo wpsc_the_product_description();//string_limit_words($excerpt,40); ?></div>
							    <div id="tab2" style="height: 226px;">	<?php echo comments_template(true); ?></div>
							    <!--<div id="tab3">...</div>
							    <div id="tab4">...</div>-->
							</div>							
							
							
							
							
							
							</div>
						<div class="clear"></div>						
		<?php endif; ?>








					
				</div>
<?php echo wpsc_also_bought( wpsc_the_product_id() ); ?>
<?php on_wpec_related() ?>				
			</div>
		</div>
		
<?php endwhile; ?>
<?php /** end the product loop here */?>

		<?php
		if(function_exists('fancy_notifications')) {
			echo fancy_notifications();
		}
		?>

		<div class="clear"></div>
</div>
