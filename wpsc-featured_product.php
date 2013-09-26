<?php
foreach ( $query as $product ) :
	setup_postdata( $product );
	
	global $post;
	$old_post = $post;
	$post = $product;
?>


    <div class="fance">
        <div class="">
            <div class=" product_view_<?php $product->ID; ?>">
               
               
                <?php if ( wpsc_the_product_thumbnail ( ) ) : ?>
                 <div class="featured_image">
                    <a href="<?php echo get_permalink( $product->ID ); ?>" title="<?php echo get_the_title( $product->ID ); ?>"><?php echo wpsc_the_sticky_image( wpsc_the_product_id() ); ?></a>
                </div><?php else: ?>

                <div class="item_no_image">
                    <a href="<?php echo get_the_title( $product->ID ); ?>"><span><?php _e('No Image Available<'); ?></span></a>
                </div><?php endif; ?>
                
                <div class="featured_text">
                    <h2><a href='<?php echo get_permalink( $product->ID ); ?>'><?php echo get_the_title( $product->ID ); ?></a></h2>
                      <div class="pricedisplay featured_product_price">
                        <?php _e('Price');?>: <?php echo wpsc_the_product_price(); ?>
                    </div>
                    
                    <div class='wpsc_description'>
                        <?php echo wpsc_the_product_description(); ?> <a class="button right" href='<?php echo get_permalink( $product->ID ); ?>'><span><span><?php _e('More Information&hellip;'); ?></span></span></a>
                    </div>
       
                </div>
                
               
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
<?php endforeach; 
$post = $old_post;
?>