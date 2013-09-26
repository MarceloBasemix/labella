<?php
	$curr_cat       = get_term( $category_id, 'wpsc_product_category', ARRAY_A );
	$category_list  = get_terms( 'wpsc_product_category', 'hide_empty=0&parent=' . $category_id );
	$link = get_term_link((int)$category_id , 'wpsc_product_category');
	$category_image = wpsc_get_categorymeta( $curr_cat['term_id'], 'image' );
	$category_image = WPSC_CATEGORY_URL . $category_image;
	$show_name = $instance['show_name'];

	
	
	
	if ( $grid ) : ?>

		<a href="<?php echo $link; ?>" style=" margin:4px; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;" title="<?php echo $curr_cat['name']; ?>" class="wpsc_category_grid_item">
			<?php wpsc_parent_category_image( $show_thumbnails, $category_image , $width, $height, true ,$show_name); ?>
		</a>

		<?php wpsc_start_category_query( array( 'parent_category_id' => $category_id, 'show_thumbnails' => $show_thumbnails, 'show_name' => $show_name) ); ?>

		<a href="<?php wpsc_print_category_url(); ?>" style="width:<?php echo $width; ?>px; margin:4px; height:<?php echo $height; ?>px" class="wpsc_category_grid_item" title="<?php wpsc_print_category_name(); ?>">
			<?php wpsc_print_category_image( $width, $height ); ?>
		</a>

		<?php wpsc_print_subcategory( '', '' ); ?>

		<?php wpsc_end_category_query(); ?>

<?php else : ?>
			<?php $total = count ((array)$instance['categories']); ?>
			<?php if ($i == 0) :?> <ul><?php endif; ?>
			
			<?php $i++; ?>
			
				<li class="cat-item" <?php if(($show_thumbnails) ): ?> style="list-style:none" <?php endif; ?>>
					<?php if($show_thumbnails ){ ?>
						<a href="<?php echo $link; ?>" style="float:left; margin-right:5px"><?php 
						wpsc_parent_category_image( $show_thumbnails, $category_image , $width, $height, false, $show_name ); ?></a>
					<?php } ?>
					
					<a href="<?php echo $link; ?>"><?php echo $curr_cat['name']; ?></a>
					
				<?php
				 $sub_categories = get_terms('wpsc_product_category','hide_empty=0&parent='.$category_id);
				 ?>
					<?php if($sub_categories): ?><ul class="children"><?php endif; ?>

						<?php wpsc_start_category_query( array( 'parent_category_id' => $category_id, 'show_thumbnails' => $show_thumbnails , 'show_name' => $show_name) ); ?>

							<li class="cat-item" <?php if($show_thumbnails): ?> style="list-style:none" <?php endif; ?> >
							<?php if($show_thumbnails): ?>	<a href="<?php wpsc_print_category_url(); ?>" class="" style="float:left; margin-right:5px; display:block;">

									<?php wpsc_print_category_image( $width, $height ); ?>

								</a><?php endif; ?>
								
								<a href="<?php wpsc_print_category_url(); ?>" class="">

									<?php wpsc_print_category_name(); ?>

									<?php if ( 1 == get_option( 'show_category_count') ) wpsc_print_category_products_count( "(",")" ); ?>

								</a>
								
								<?php wpsc_print_subcategory( '<ul class="children">', '</ul>' ); ?>

							</li>

						<?php wpsc_end_category_query(); ?>

					<?php if($sub_categories): ?></ul><?php endif; ?>
				</li>
			
	<?php if ($i == $total) :?> </ul><?php endif; ?>	

<?php endif; ?>
