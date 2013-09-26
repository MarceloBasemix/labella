<?php get_header(); ?>
<?php //echo "<br/>Busca"; ?>

<?php

global $wp_query;	

$pega_s = $_REQUEST['s'];

$url_atual = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];


/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
 
 ?>
<style>
 
/**** post pagination wordpress - madlyluv.com ***/
.paginacao {
         clear:both;
         padding: 20px 0;
         position:relative;
         float: right;
}

.paginacao span, .paginacao a {
         display:block;
         float:left;
         /*font: normal 14px georgia, verdana;*/
         /*background: #F5F5F5;*/
         padding: 4px 7px 4px 7px;
         margin: 1px 2px 0 2px;
         text-transform: capitalize;
         color: #000;
}

.paginacao span {
         /*font: bold normal 14px georgia, verdana;*/
}

.paginacao .current, .paginacao .current a {
         color: #960d5d;
         /*background: #f0f0f0;*/
         padding: 4px 7px 4px 7px;
         margin: 1px 2px 0 2px;
         font: bold italic 14px georgia, verdana;
         text-transform: capitalize;
} 
.paginacao .selected{
	color: #960d5d !important;
}
 

 
</style>
<?php
 


function post_pagination($pages = '', $range = 4)
{
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}

	if(1 != $pages)
	{
		echo "<div class='paginacao'><span>P&aacute;ginas:</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."' class='selected'>&laquo;</a>";
		if($paged > 6 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'> 1 </a> <span class='selected'>...</span>";

		for ($i=1; $i <= $pages; $i++)
		{
		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		{
		echo ($paged == $i)? "<span class='selected'>".$i."</span>":"<a href='".get_pagenum_link($i)."' >  ".$i."  </a> ";
		
		
		}
		}

		
		
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<span class='selected'> ... </span> <a href='".get_pagenum_link($pages)."'>$pages</a>";
         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."' class='selected'> &raquo; </a>";
         		echo "</div>\n";
	}
	
	
	}

?>




<section id="content">
	<div class="container_12">
			<div class="grid_3 side_col_left">
				<?php get_sidebar(); ?>
				<?php //echo NggRandom_sidebar(4); ?>		

			</div>		
		<div class="grid_9 cont_col" id="posts">

	<div class="smaller-title">
		<h1 class="category-title lower-case"><?php _e('Nossos Produtos','mazine'); ?>: <?php the_search_query(); ?></h1>
	</div>
	<?php
	global $wp_query;
	
	query_posts($query_string . '&post__not_in=2023&order=ASC');
	
	if (have_posts()) : ?>


		<div class="title border">
					<h2 class="category-title"><?php echo wpsc_current_category_name(); ?></h2>


					<div class="pager">

					<form id="variacoes" action="<?php echo $url_atual.'&s='.$pega_s; ?>" method="GET" class="product_search">


						<!--<div id="combo_ordenacao">


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


						</div> -->
						
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
					</div>
					
					

					
						<?php /** the variation group HTML and loop ends here */?>
						<div class="action" style="position:relative !important;">
								
							
						
							<div class="wpsc_product_price">
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
										<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('', 'wpsc'); ?> <span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span></p>
									<?php endif; ?>
									<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><?php _e('', 'wpsc'); ?> <span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><?php echo wpsc_the_product_price(); ?></span></p>
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
                                                            <div id="soldoutNovo" align="center" style="margin-top: -40px;">
                                                              <p class='soldout'><?php echo __('This product has sold out.', 'wpsc'); ?></p>
                                                                          <br/>                                                      
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
	
				<?php post_pagination(); ?>
				

	




















	<?php else: ?>
	<div class="fance">
		<div class="no-results">
			<div class="heading">
				<h2><?php _e('Ops! Sem resultados.','mazine'); ?></h2>
                                
                               
			</div>
			<div class="post-content">
				<p><?php _e('Por favor preencha o que procura no campo Buscar Produtos e tente novamente','mazine'); ?></p>
			</div>
		</div><!--no-results-->
	</div>
	<?php endif; ?>


</div><!-- #content -->

		<div class="clear"></div>

		<!-- BANNER RODAPÉ -->
		<?php echo NggRandom_bottom_left(3); echo NggRandom_bottom_right(6);?>	
		
	</div>	
</section>

<?php get_footer(); ?>
