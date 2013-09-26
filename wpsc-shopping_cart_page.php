<?php
/*print_r($_REQUEST);
print_r($_SESSION);
print_r($_COOKIE); */ 
//echo "<br/>wpsc_shipping_quote_value: ".wpsc_shipping_quote_value();

global $wpsc_cart, $wpdb, $wpsc_checkout, $wpsc_gateway, $wpsc_coupons;
$wpsc_checkout = new wpsc_checkout();
$wpsc_gateway = new wpsc_gateways();
$alt = 0;
$template_path = get_bloginfo('template_url'); 

if(isset($_SESSION['coupon_numbers']))
   $wpsc_coupons = new wpsc_coupons($_SESSION['coupon_numbers']);


//echo "<br/>wpsc_cart_item_quantity: ".wpsc_cart_item_quantity();
if(wpsc_cart_item_count() < 1) :?>

<div class="fance">
<span style="font-weight:bold; size:14px; color:#960d5d;">
<?php
   _e('Oops, there is nothing in your cart.', 'wpsc') . "<a href=".get_option("product_list_url").">" . __('Please visit our shop', 'wpsc') . "</a>";
   return; 
   ?>
   </div>
   <?php
endif;
?>
</span>

<?php



if (wpsc_have_morethanone_shipping_quote()) :?>
<?php while (wpsc_have_shipping_methods()) : wpsc_the_shipping_method(); ?>
      <?php    if (!wpsc_have_shipping_quotes()) { continue; } // Don't display shipping method if it doesn't have at least one quote ?>
      
      <?php while (wpsc_have_shipping_quotes()) : wpsc_the_shipping_quote();  ?>
<?php //echo wpsc_shipping_quote_value(); ?>
            
           <?php if(wpsc_have_morethanone_shipping_methods_and_quotes()): ?>
                  <!--<input type='radio' id='<?php echo wpsc_shipping_quote_html_id(); ?>' <?php //echo wpsc_shipping_quote_selected_state(); ?>  onclick='switchmethod("<?php echo wpsc_shipping_quote_name(); ?>", "<?php echo wpsc_shipping_method_internal_name(); ?>")' value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />-->
               <?php else: ?>
                  <!-- input <?php echo wpsc_shipping_quote_selected_state(); ?> disabled='disabled' type='radio' id='<?php //echo wpsc_shipping_quote_html_id(); ?>'  value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />-->
                     <?php wpsc_update_shipping_single_method(); ?>
               <?php endif; ?>
		                     
      <?php endwhile; ?>
<?php endwhile; ?>
 <?php endif; 






?>





<div id="checkout_cont" >


<div id="step-1">

<h3><?php _e('Confira como está sua sacola', 'wpsc'); ?></h3>
<table class="checkout_cart table checkout-table">
   <tr class="header">
      <th colspan="2" ><?php _e('Product', 'wpsc'); ?></th>
      <th><?php _e('Quantity', 'wpsc'); ?></th>
      <th><?php _e('Price', 'wpsc'); ?></th>
      <th><?php _e('Total', 'wpsc'); ?></th>
        <th>&nbsp;</th>
   </tr>
   <?php while (wpsc_have_cart_items()) : wpsc_the_cart_item(); ?>
      <?php
       $alt++;
       if ($alt %2 == 1)
         $alt_class = 'alt';
       else
         $alt_class = '';
       ?>
      <?php  //this displays the confirm your order html ?>

      <tr class="product_row product_row_<?php echo wpsc_the_cart_item_key(); ?> <?php echo $alt_class;?>">

         <td class="firstcol wpsc_product_image wpsc_product_image_<?php echo wpsc_the_cart_item_key(); ?>">
         <?php if('' != wpsc_cart_item_image()): ?>
            <img src="<?php echo wpsc_cart_item_image(114, 87); ?>" alt="<?php echo wpsc_cart_item_name(); ?>" title="<?php echo wpsc_cart_item_name(); ?>" class="product_image" />
         <?php else:
         /* I dont think this gets used anymore,, but left in for backwards compatibility */
         ?>
            <div class="item_no_image">
               <a href="<?php echo wpsc_the_product_permalink(); ?>">
               <span><?php _e('No Image','wpsc'); ?></span>

               </a>
            </div>
         <?php endif; ?>
         </td>

         <td class="wpsc_product_name wpsc_product_name_<?php echo wpsc_the_cart_item_key(); ?>">
            <h4><a href="<?php echo wpsc_cart_item_url();?>"><?php echo wpsc_cart_item_name(); ?></a></h4>
         </td>

         <td class="wpsc_product_quantity wpsc_product_quantity_<?php echo wpsc_the_cart_item_key(); ?>">
            <form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform qty">
               <input type="text" name="quantity" size="2" value="<?php echo wpsc_cart_item_quantity(); ?>" />
               <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
               <input type="hidden" name="wpsc_update_quantity" value="true" />
               <button class="reverse"><span><span><?php _e('Update', 'wpsc'); ?></span></span></button>
            </form>
         </td>

       
            <td><?php echo wpsc_cart_single_item_price(); ?></td>
         <td class="wpsc_product_price wpsc_product_price_<?php echo wpsc_the_cart_item_key(); ?>"><span class="pricedisplay"><?php echo wpsc_cart_item_price(); ?></span></td>

         <td class="wpsc_product_remove wpsc_product_remove_<?php echo wpsc_the_cart_item_key(); ?>">
            <form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform remove">
               <input type="hidden" name="quantity" value="0" />
               <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
               <input type="hidden" name="wpsc_update_quantity" value="true" />
              <button class="reverse"><span><span><?php _e('Remove', 'wpsc'); ?></span></span></button>
            </form>
         </td>
      </tr>
   <?php endwhile; ?>
   <?php //this HTML displays coupons if there are any active coupons to use ?>

   <?php

   if(wpsc_uses_coupons()): ?>

      <?php if(wpsc_coupons_error()): ?>
         <tr class="wpsc_coupon_row wpsc_coupon_error_row"><td><?php _e('Coupon is not valid.', 'wpsc'); ?></td></tr>
      <?php endif; ?>
      <tr class="wpsc_coupon_row">
         <td colspan="3"><?php _e('Enter coupon code', 'wpsc'); ?> (CLIQUE EM ATUALIZAR PARA VALIDAR O CUPOM) :</td>
         <td  colspan="3" class="coupon_code">
            <form  method="post" action="<?php echo get_option('shopping_cart_url'); ?>">
               <input type="text" name="coupon_num" id="coupon_num" placeholder="cupom200" value="cupom200<?php //echo $wpsc_cart->coupons_name; ?>" />
               <input type="submit" value="<?php _e('Update', 'wpsc') ?>" />
            </form>
         </td>
      </tr>
      <tr class="wpsc_total_before_shipping">
	      <td colspan="3"><?php _e('Cost before shipping:','wpsc'); ?></td>
	      <td colspan="3" class="wpsc_total_amount_before_shipping"><?php echo wpsc_cart_total_widget(false,false,false);?></td>
      </tr>
   <?php endif; ?>
   </table>
   <!-- cart contents table close -->
  <?php if(wpsc_uses_shipping()): ?>
	   <p class="wpsc_cost_before"></p>
   <?php endif; ?>
   <?php  //this HTML dispalys the calculate your order HTML   ?>

   <?php if(wpsc_has_category_and_country_conflict()): ?>
      <p class='validation-error'><?php echo $_SESSION['categoryAndShippingCountryConflict']; ?></p>
      <?php unset($_SESSION['categoryAndShippingCountryConflict']);
   endif;

   if(isset($_SESSION['WpscGatewayErrorMessage']) && $_SESSION['WpscGatewayErrorMessage'] != '') :?>
      <p class="validation-error"><?php echo $_SESSION['WpscGatewayErrorMessage']; ?></p>
   <?php
   endif;
   ?>

   <?php do_action('wpsc_before_shipping_of_shopping_cart'); ?>

	<div id="subtotal_main">
	<div id="subtotal_texto" style="">Preço Sub-Total:</div>
	<div id="subtotal"><span class="texto1">A compra está em apenas: </span><?php echo wpsc_cart_total_widget(); ?></div>
	</div>
   <div id="wpsc_shopping_cart_container">
   <?php if(wpsc_uses_shipping()) : ?>
      <h2><?php _e('Calculate Shipping Price', 'wpsc'); ?></h2>
    <div id="frete1">      

      <table class="productcart">
         <tr class="wpsc_shipping_info">
            <td colspan="5">
               <?php _e('Por favor, etre com seu CEP para calcular o custo do frete:', 'wpsc'); ?>
            </td>
         </tr>

         <?php if (!wpsc_have_shipping_quote()) : // No valid shipping quotes ?>
            <?php if (wpsc_have_valid_shipping_zipcode()) : ?>
                  <!--<tr class='wpsc_update_location'>
                     <td colspan='5' class='shipping_error' >
                        <?php //_e('Por favor, etre com seu CEP para calcular o custo do frete:', 'wpsc'); ?>
                     </td>
                  </tr>-->
            <?php else: ?>
               <tr class='wpsc_update_location_error'>
                 <!--<td colspan='5' class='shipping_error' >
                     <?php //_e('Sorry, online ordering is unavailable to this destination and/or weight. Please double check your destination details.', 'wpsc'); ?>
                 </td>-->
               </tr>
            <?php endif; ?>
         <?php endif; ?>
         <tr class='wpsc_change_country'>
            <td colspan='5'>
               <form name='change_country' id='change_country' action='' method='post'>
                  <?php echo wpsc_shipping_country_list();?>
                  <input type='hidden' name='wpsc_update_location' value='true' />
                  
                  <button type='submit' name='wpsc_submit_zipcode' class="button_frete" />
                  <span>
                  	<span>Calcular</span>
                  </span>
                 </button>
                  <!--<input type='submit' class="reverse" name='wpsc_submit_zipcode' value='Calcular' />-->
               </form>
            </td>
         </tr>
</table>


        <?php 
        
        /*$valor_frete = substr(wpsc_shipping_quote_value(), -11, 4);
        
        if ($valor_frete == "0,00") : // No valid shipping quotes ?>
               
               <div class="error"><div class="error_icon"></div>
               
               <?php _e('Favor Calcular seu CEP.', 'mazine'); ?>
               
               </div>
               </div>
			</div>
			</div>
			
            <?php return; ?>
         <?php endif; */?>





        <?php
        
       $valor_frete = substr(wpsc_shipping_quote_value(), -11, 4);
       
        if (!wpsc_have_shipping_quote() || $valor_frete == "0,00") : // No valid shipping quotes ?>
               
               <div class="error"><div class="error_icon"></div>
               
               <?php _e('O CEP inserido está inválido', 'mazine'); ?>
               
               </div>
               </div>
			</div>
			</div>
			
            <?php return; ?>
         <?php endif; ?>

</div>
         <?php if (wpsc_have_morethanone_shipping_quote()) :?>
            <?php while (wpsc_have_shipping_methods()) : wpsc_the_shipping_method(); ?>
                  <?php    if (!wpsc_have_shipping_quotes()) { continue; } // Don't display shipping method if it doesn't have at least one quote ?>
                  
                  <div id="frete2">
                  
                         <div id="frete2_meio">
                  <table class="productcart"  style="background:url('<?php echo $template_path; ?>/images/labella/produtos/sacola/bkg_frete2_meio.png'">
                  <tr class='wpsc_shipping_header'><td class='shipping_header' colspan='5'><?php echo wpsc_shipping_method_name().__(' - Choose a Shipping Rate', 'wpsc'); ?> </td></tr>
                  <?php while (wpsc_have_shipping_quotes()) : wpsc_the_shipping_quote();  ?>
                     <tr class='<?php echo wpsc_shipping_quote_html_id(); ?>'>
                        <td class='wpsc_shipping_quote_name wpsc_shipping_quote_name_<?php echo wpsc_shipping_quote_html_id(); ?>' colspan='3'>
                           <label for='<?php echo wpsc_shipping_quote_html_id(); ?>'><?php echo wpsc_shipping_quote_name(); ?></label>
                        </td>
                        <td class='wpsc_shipping_quote_price wpsc_shipping_quote_price_<?php echo wpsc_shipping_quote_html_id(); ?>' style='text-align:center;'>
                           <label for='<?php echo wpsc_shipping_quote_html_id(); ?>'><?php echo wpsc_shipping_quote_value(); ?></label>
                        </td>
                        <td class='wpsc_shipping_quote_radio wpsc_shipping_quote_radio_<?php echo wpsc_shipping_quote_html_id(); ?>' style='text-align:center;'>
                           <?php if(wpsc_have_morethanone_shipping_methods_and_quotes()): ?>
                              <input type='radio' id='<?php echo wpsc_shipping_quote_html_id(); ?>' <?php echo wpsc_shipping_quote_selected_state(); ?>  onclick='switchmethod("<?php echo wpsc_shipping_quote_name(); ?>", "<?php echo wpsc_shipping_method_internal_name(); ?>")' value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />
                           <?php else: ?>
                              <input <?php echo wpsc_shipping_quote_selected_state(); ?> disabled='disabled' type='radio' id='<?php echo wpsc_shipping_quote_html_id(); ?>'  value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />
                                 <?php wpsc_update_shipping_single_method(); ?>
                           <?php endif; ?>
                        </td>
                     </tr>
					                     
                  <?php endwhile; ?>
            <?php endwhile; ?>
         <?php endif; ?>

         <?php wpsc_update_shipping_multiple_methods(); ?>


         
      </table>
		<div id="frete2_bottom"></div>
      
      </div>






		</div>
   <?php endif;  ?>

   <?php
      $wpec_taxes_controller = new wpec_taxes_controller();
      if($wpec_taxes_controller->wpec_taxes_isenabled()):
   ?>
      <table class="productcart">
         <tr class="total_price total_tax">
            <td colspan="3">
               <?php echo wpsc_display_tax_label(true); ?>
            </td>
            <td colspan="2">
               <span id="checkout_tax" class="pricedisplay checkout-tax"><?php echo wpsc_cart_tax(); ?></span>
            </td>
         </tr>
      </table>
   <?php endif; ?>
   <?php do_action('wpsc_before_form_of_shopping_cart'); ?>
                 
	
	
	<div class="checkout_actions">
		<a class="button checkout-2" onclick="checkout_step(2, '#checkout_cont');"><span><span><?php _e('Finalizar Compra', 'mazine') ?></span></span></a>
		<a style="margin-right: 100px;" class="button checkout-2" onclick="javascript: window.location.href='http://www.labellastore.com/'"><span><span><?php _e('Continuar Comprando', 'mazine') ?></span></span></a>
		
	</div>
</div>
</div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<div id="step-2">


   <?php do_action('wpsc_before_form_of_shopping_cart'); ?>
                 
	<?php if(!empty($_SESSION['wpsc_checkout_user_error_messages'])): ?>
		<p class="validation-error">
		<?php
		foreach($_SESSION['wpsc_checkout_user_error_messages'] as $user_error )
		echo $user_error."<br />\n";
		
		$_SESSION['wpsc_checkout_user_error_messages'] = array();
		?>
	<?php endif; ?>

	<?php //if ( /*wpsc_show_user_login_form() && */ !is_user_logged_in() ): 
	/*?>
			<p><?php _e('You must sign in or register with us to continue with your purchase', 'wpsc');?></p>
			<script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
			<div class="wpsc_registration_form fance grid_5">
				
				<fieldset class='wpsc_registration_form'>
					<h2><?php _e( 'Sign in', 'wpsc' ); ?></h2>
					<div class="wpsc_signup_text"><?php _e('If you have bought from us before please sign in here to purchase', 'wpsc');?></div>
					<br/>
					<?php
					$args = array( 'remember' => false );
					wp_login_form( $args );
					?>
					
				</fieldset>
			</div>
	<?php endif; */?>	
	<form class='wpsc_checkout_forms' action='<?php echo get_option('shopping_cart_url'); ?>' method='post' enctype="multipart/form-data">
				
      <?php
      /**
       * Both the registration forms and the checkout details forms must be in the same form element as they are submitted together, you cannot have two form elements submit together without the use of JavaScript.
      */
      ?>

    <?php if(wpsc_show_user_login_form()):
          global $current_user;
          get_currentuserinfo();   ?>

		<div class="wpsc_registration_form fance grid_5">
			
	        <fieldset class='wpsc_registration_form wpsc_right_registration'>
	        	<h2><?php _e('Join up now', 'wpsc');?></h2>
	            <div class="wpsc_signup_text"><?php _e('Signing up is free and easy! please fill out your details your registration will happen automatically as you checkout. Don\'t forget to use your details to login with next time!', 'wpsc');?></div>
	      		<br/>
				<label><?php _e('Username', 'wpsc'); ?>:</label>
				<input type="text" name="log" id="log" value="" size="20"/><br/>
				<br/>
				<label><?php _e('Password', 'wpsc'); ?>:</label>
				<input type="password" name="pwd" id="pwd" value="" size="20" /><br />
				<br/>
				<label><?php _e('E-mail', 'wpsc'); ?>:</label>
	            <input type="text" name="user_email" id="user_email" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="20" /><br />
	            
	        </fieldset>
	               </div>
        <div class="clear"></div>
   <?php endif; // closes user login form

      if(!empty($_SESSION['wpsc_checkout_misc_error_messages'])): ?>
         <div class='login_error'>
            <?php foreach((array)$_SESSION['wpsc_checkout_misc_error_messages'] as $user_error ){?>
               <p class='validation-error'><?php echo $user_error; ?></p>
               <script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
               <?php } ?>
         </div>

      <?php
      endif;
       $_SESSION['wpsc_checkout_misc_error_messages'] = array(); ?>
<?php ob_start(); ?>
   <table class='wpsc_checkout_table table'>
      <?php $i = 0;
      while (wpsc_have_checkout_items()) : wpsc_the_checkout_item(); ?>

        <?php if(wpsc_checkout_form_is_header() == true){
               $i++;
               //display headers for form fields ?>
               <?php if($i > 1):?>
                  </table>
                  <table class='wpsc_checkout_table table'>
               <?php endif; ?>

               <tr <?php echo wpsc_the_checkout_item_error_class();?>>
                  <td <?php wpsc_the_checkout_details_class(); ?> colspan='2'>
                     <h4><?php echo wpsc_checkout_form_name();?></h4>
                  </td>
               </tr>
               <?php if(wpsc_is_shipping_details()):?>
               <tr class='same_as_shipping_row'>
                  <td colspan ='2'>
                  <?php $checked = '';
                  if(isset($_POST['shippingSameBilling']) && $_POST['shippingSameBilling'])
                  	$_SESSION['shippingSameBilling'] = true;
                  elseif(isset($_POST['submit']) && !isset($_POST['shippingSameBilling']))
                  	$_SESSION['shippingSameBilling'] = false;

                  	if($_SESSION['shippingSameBilling'] == 'true')
                  		$checked = 'checked="checked"';
                   ?>
					<label for='shippingSameBilling'><?php _e('Same as billing address:','wpsc'); ?></label>
					<input type='checkbox' value='true' name='shippingSameBilling' id='shippingSameBilling' <?php echo $checked; ?> />
					<br/><span id="shippingsameasbillingmessage"><?php _e('Your order will be shipped to the billing address', 'wpsc'); ?></span>
                  </td>
               </tr>
               <?php endif;

            // Not a header so start display form fields
            }elseif(wpsc_disregard_shipping_state_fields()){
            ?>
               <tr class='wpsc_hidden'>
                  <td class='<?php echo wpsc_checkout_form_element_id(); ?>'>
                     <label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
                     <?php echo wpsc_checkout_form_name();?>
                     </label>
                  </td>
                  <td>fff
                     <?php echo wpsc_checkout_form_field();?>
                      <?php if(wpsc_the_checkout_item_error() != ''): ?>
                             <p class='validation-error'><?php echo wpsc_the_checkout_item_error(); ?></p>
                             <script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
                     <?php endif; ?>
                  </td>
               </tr>
            <?php
            }elseif(wpsc_disregard_billing_state_fields()){
            ?>
               <tr class='wpsc_hidden'>
                  <td class='<?php echo wpsc_checkout_form_element_id(); ?>'>
                     <label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
                     <?php echo wpsc_checkout_form_name();?>
                     </label>
                  </td>
                  <td>
                     <?php echo wpsc_checkout_form_field();?>
                      <?php if(wpsc_the_checkout_item_error() != ''): ?>
                             <p class='validation-error'><?php echo wpsc_the_checkout_item_error(); ?></p>
                             <script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
                     <?php endif; ?>
                  </td>
               </tr>
            <?php
            }elseif( $wpsc_checkout->checkout_item->unique_name == 'billingemail'){ ?>
               <?php $email_markup =
               "<div class='wpsc_email_address'>
                  <p class='<?php wpsc_checkout_form_element_id(); ?>'>
                     <label class='wpsc_email_address' for='" . wpsc_checkout_form_element_id() . "'>
                     " . __('Enter your email address', 'wpsc') . "
                     </label>
                  <p class='wpsc_email_address_p'>
                  <img src='https://secure.gravatar.com/avatar/empty?s=60&amp;d=mm' id='wpsc_checkout_gravatar' />
                  " . wpsc_checkout_form_field();
                  
                   if(wpsc_the_checkout_item_error() != '')
                      $email_markup .= "<p class='validation-error'>" . wpsc_the_checkout_item_error() . "</p>
                      <script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
                      ";
               $email_markup .= "</div><div class='clear'></div>";
             }else{ ?>
			<tr>
               <td class='<?php echo wpsc_checkout_form_element_id(); ?>'>
                  <label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
                  <?php echo wpsc_checkout_form_name();?>
                  </label>
               </td>
               <td>
                  <?php echo wpsc_checkout_form_field();?>
                   <?php if(wpsc_the_checkout_item_error() != ''): ?>
                          <p class='validation-error'><?php echo wpsc_the_checkout_item_error(); ?></p>
                          <script>$(window).load(function(){checkout_step(2, '#checkout_cont');});</script>
                  <?php endif; ?>
               </td>
            </tr>

         <?php }//endif; ?>

      <?php endwhile; ?>
 
<?php 
	$buffer_contents = ob_get_contents();
	ob_end_clean();
	if(isset($email_markup))
		echo $email_markup;
	echo $buffer_contents;
?>

      <?php if (wpsc_show_find_us()) : ?>
      <tr>
         <td><label for='how_find_us'><?php _e('How did you find us' , 'wpsc'); ?></label></td>
         <td>
            <select name='how_find_us'>
               <option value='Word of Mouth'><?php _e('Word of mouth' , 'wpsc'); ?></option>
               <option value='Advertisement'><?php _e('Advertising' , 'wpsc'); ?></option>
               <option value='Internet'><?php _e('Internet' , 'wpsc'); ?></option>
               <option value='Customer'><?php _e('Existing Customer' , 'wpsc'); ?></option>
            </select>
         </td>
      </tr>
      <?php endif; ?>
      <?php do_action('wpsc_inside_shopping_cart'); ?>

      <?php  //this HTML displays activated payment gateways   ?>
      <?php if(wpsc_gateway_count() > 1): // if we have more than one gateway enabled, offer the user a choice ?>
         <tr>
         <td colspan='2' class='wpsc_gateway_container'>
            <h3><?php _e('Payment Type', 'wpsc');?></h3>
            <?php 
            
            //print_r(wpsc_the_gateway());
            
            
            while (wpsc_have_gateways()) : wpsc_the_gateway(); ?>
            <?php /* HACK: FORÇA CHECAR O PAYPAL E ORDENAR DESC */
            
            $nome_pagamento = wpsc_gateway_name();

            if ($nome_pagamento == "pagseguro"){ $checked_pg =  false;}
            if ($nome_pagamento == "PayPal"){ $checked_pg =  'checked="checked"';}
            
            $pega_payment[] = array(

								'radio_value'		=>	wpsc_gateway_internal_name(),
								'radio_checked'		=>  $checked_pg,
								'img_pag_url'		=> wpsc_gateway_image_url(),
								'nome_pagamento'	=>	$nome_pagamento
            );
            
		

            
            /* ?>
               <div class="custom_gateway">
                     <label><input type="radio" value="<?php echo wpsc_gateway_internal_name();?>" <?php echo $checked_pg; //wpsc_gateway_is_checked(); ?> name="custom_gateway" class="custom_gateway"/><?php echo wpsc_gateway_name(); ?> 
                     	<?php if( wpsc_show_gateway_image() ): ?>
                     	<img src="<?php echo wpsc_gateway_image_url(); ?>" alt="<?php echo wpsc_gateway_name(); ?>" style="position:relative; top:5px;" />
                     	<?php endif; ?>
                     </label>

                  <?php 
                  
                  
                  if(wpsc_gateway_form_fields()): ?>
                     <table class='wpsc_checkout_table <?php echo wpsc_gateway_form_field_style();?>'>
                        <?php echo wpsc_gateway_form_fields();?>
                     </table>
                  <?php endif; ?>
               </div> */ ?>
            <?php endwhile; ?>
            
            
                    <?php /* HACK: FORÇA CHECAR O PAYPAL E ORDENAR DESC */
                    
                    arsort($pega_payment);

         			$qtde =  count($pega_payment);
         
 					if ($qtde > 0){ 
         
	                foreach ($pega_payment as $key=>$value) { ?>
 
	                      <div class="custom_gateway">
	                     <label><input type="radio" value="<?php echo $value['radio_value']?>" <?php echo $value['radio_checked']; ?> name="custom_gateway" class="custom_gateway"/><?php echo $value['nome_pagamento']; ?> 
	                     	<?php if( $value['img_pag_url'] ): ?>
	                     	<img src="<?php echo $value['img_pag_url']; ?>" alt="<?php echo $value['nome_pagamento']; ?>" style="position:relative; top:5px;" />
	                     	<?php endif; ?>
	                     </label>
	
	                  <?php  }// fecha foreach
	                 
	                  
	                  
	                  if(wpsc_gateway_form_fields()): ?>
	                     <table class='wpsc_checkout_table <?php echo wpsc_gateway_form_field_style();?>'>
	                        <?php echo wpsc_gateway_form_fields();?>
	                     </table>
	                  <?php endif; ?>
	               </div>
	 
	 			<?php }// fecha if ?>
 
            
            
            
            
            </tr></td>
         <?php else: // otherwise, there is no choice, stick in a hidden form ?>
            <tr><td colspan="2" class='wpsc_gateway_container'>
            <?php while (wpsc_have_gateways()) : wpsc_the_gateway(); ?>
               <input name='custom_gateway' value='<?php echo wpsc_gateway_internal_name();?>' type='hidden' />

                  <?php if(wpsc_gateway_form_fields()): ?>
                     <table class='wpsc_checkout_table <?php echo wpsc_gateway_form_field_style();?>'>
                        <?php echo wpsc_gateway_form_fields();?>
                     </table>
                  <?php endif; ?>
            <?php endwhile; ?>
            
            
            
            
            
  
            
            
            
            
            
            
            
            
            
            
            
            
         </td>
         </tr>
         <?php endif; ?>

         
         
         
      <?php if(wpsc_has_tnc()) : ?>
         <tr>
            <td colspan='2'>
                <label for="agree"><?php printf(__("I agree to The <a class='thickbox' target='_blank' href='%s' class='termsandconds'>Terms and Conditions</a>", "wpsc"), site_url("?termsandconds=true&amp;width=360&amp;height=400'")); ?></label><input id="agree" type='checkbox' value='yes' name='agree' /> 
               </td>
         </tr>
      <?php endif; ?>
      </table>

   <table  class='wpsc_checkout_table table'>
      <?php if(wpsc_uses_shipping()) : ?>
	      <tr>
	         <td class='wpsc_total_price_and_shipping'colspan='2'>
	            <h4><?php _e('Review and purchase','wpsc'); ?></h4>
	         </td>
	      </tr>
	
	      <tr class="total_price total_shipping">
	         <td class='wpsc_totals'>
	            <?php _e('Total Shipping', 'wpsc'); ?>:
	         &nbsp;&nbsp;&nbsp;
	            <span id="checkout_shipping" class="pricedisplay checkout-shipping"><?php echo wpsc_cart_shipping(); ?></span>
	         </td>
	      </tr>
      <?php endif; ?>

     <?php if(wpsc_uses_coupons() && (wpsc_coupon_amount(false) > 0)): ?>
      <tr class="total_price">
         <td class='wpsc_totals'>
            <?php _e('Discount', 'wpsc'); ?>:
      &nbsp;&nbsp;&nbsp;      <span id="coupons_amount" class="pricedisplay"><?php echo wpsc_coupon_amount(); ?></span>
          </td>
         </tr>
     <?php endif ?>



   <tr class='total_price'>
      <td class='wpsc_totals'>
      <?php _e('Total Price', 'wpsc'); ?>:
      &nbsp;&nbsp;&nbsp;	
               <span id='checkout_total' class="pricedisplay checkout-total"><?php echo wpsc_cart_total(); ?></span>
      </td>
   </tr>
   </table>


<div class="checkout_actions" style="margin-left: 200px;">
		<a class="button checkout-1" onclick="checkout_step(1, '#checkout_cont');"><span><span>Voltar</span></span></a>
	</div>
<!-- div for make purchase button -->
      <div class='wpsc_make_purchase'>
            <?php if(!wpsc_has_tnc()) : ?>
               <input type='hidden' value='yes' name='agree' />
            <?php endif; ?>
               <input type='hidden' value='submit_checkout' name='wpsc_action' />
               <button><span><span><?php _e('Purchase', 'wpsc');?></span></span></button>
      </div>


</form>

</div>

<div class="clear"></div>
</div>		