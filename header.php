<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php if ( is_tag() ) {
			echo __('Tag Archive for &quot;','mazine').$tag.'&quot; | '; bloginfo( 'name' );
		} elseif ( is_archive() ) {
			wp_title(); echo __(' Archive | ','mazine'); bloginfo( 'name' );
		} elseif ( is_search() ) {
			echo __('Search for &quot;','mazine').wp_specialchars($s).'&quot; | '; bloginfo( 'name' );
		} elseif ( is_home() ) {
			bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
		}  elseif ( is_404() ) {
			echo __('Error 404 Not Found | ','mazine'); bloginfo( 'name' );
		} else {
			echo wp_title( ' | ', false, right ); bloginfo( 'name' );
		} ?></title>
	<meta name="description" content="<?php wp_title(); echo ' | '; bloginfo( 'description' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="generator" content="WordPress" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="index" title="<?php bloginfo( 'name' ); ?>" href="<?php echo get_option('home'); ?>/" />
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.5.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-ui.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/ddsmoothmenu.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.capSlide.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-tooltip/lib/jquery.bgiframe.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-tooltip/lib/jquery.dimensions.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-tooltip/jquery.tooltip.js" type="text/javascript"></script>
   <!-- <script src="<?php bloginfo('template_url'); ?>/js/jquery.validate.min.js"></script>-->
    <script src="<?php bloginfo('template_url'); ?>/js/jquery-css-transform.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery-animate-css-rotate-scale.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.quicksand.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/coin-slider.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/mazine.js"></script>




 <style>
    /* Prevents slides from flashing */
    #slides {
      display:none;
    }
  </style>

  	<script src="<?php bloginfo('template_url'); ?>/js/jquery.slides.min.js"></script>


  <script>
    $(function(){
      $("#slides").slidesjs({
        width: 940,
        height: 528
      });
    });
  </script>	
	
	<?php 
		// The HTML5 Shim is required for older browsers, mainly older versions IE
	?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/coin-slider-styles.css" type="text/css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/ie.css"/>
	<![endif]-->
	
	 <!-- this is used by many Wordpress features and for plugins to work proporly -->
	
	<?php wp_head(); ?>

<script type="text/javascript">
        jQuery(document).ready(function($){
            $('.wpsc_select_variation').change(function() {
                var pid = $(this).val();
                pimg = 'img.product_image_'+pid;
                $('img.product_image').attr("src",$(pimg).attr('src'));
            });


            $(".product_image_variation").bind("click", function() {
                $('img.product_image').attr("src",$(this).attr('src'));
                var className = $($(this)).attr('class');
                $('.wpsc_select_variation').val(className.substring((className.lastIndexOf('_')+1))).change();

            });
        });
</script>
    
<script type="text/javascript">
    
	/**
	* Função JavaScript para pegar valor de uma URL
	* Exemplo de uso:
	* Dada a url -> http://ricardospinoza.wordpress.com/index.php?id=1234&nome=ricardo
	* o código abaixo retorna:
	* getURLParameters('nome'); //valor ricardo
	* getURLParameters('id'); //valor 1234
	* getURLParameters('id', 'getURLParameters('nome', 'http://ricardospinoza.desenvolvimentoweb.eti.br/exemplos/exemplo_funcao_javascript_get_param_url.html?id=1234&nome=ricardo')"'); //retorna o valor ricardo
	**/
	function getURLParameters( param, url ) {
		param = param.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+param+"=([^&#]*)";
		var regex = new RegExp( regexS );
		//se url não for informada, assume a url corrente da página
		if (typeof url == "undefined")
			var results = regex.exec( window.location.href );
		else
			var results = regex.exec( url );

		if( results == null ){
			return "";
		}
		else {
			return results[1];
		}
	}					



		
		
var view_type = getURLParameters('view_type');


if(view_type != ""){
	
	$(document).ready(function(){
	
		if(view_type == 'list'){
			$('.grid').removeClass('grid').addClass('list');
		}else{
			 $('.list').removeClass('list').addClass('grid');
		}
	
	});

}
	
</script>



<!-- JQZOOM -->
<!--<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jqzoom.css" type="text/css" media="screen" />-->
<!--<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>-->
<script>
$(document).ready(function() {
    $("#content2 div").hide(); // Initially hide all content
    $("#tabs li:first").attr("id","current"); // Activate first tab
    $("#content2 div:first").fadeIn(); // Show first tab content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();
        if ($(this).closest("li").attr("id") == "current"){ //detection for current tab
         return       
        }
        else{             
        $("#content2 div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
        $('#' + $(this).attr('name')).fadeIn(); // Show content for current tab
        }
    });
});
</script>

	
</head>

<body <?php body_class(); ?>>
	 <!--<div id="chrome"></div>-->
	<header>
		<div class="container_12">
			<div id="cadastre_se">
				
				<?php if (!is_user_logged_in()){ ?>
						<span class="cadastro"><a href="/backup/registrar-se/" style="text-decoration: none;color:#FFFFFF;">Olá, Visitante. Aproveite e Cadastra-se, clicando aqui</a>.</span>
				<?php }else{ ?>
					<?php  $nonce= wp_nonce_field(); ?>

					
					
						<span class="cadastro">
							<a href="http://www.labellastore.com/wp-admin/profile.php" style="text-decoration: none;color:#FFFFFF;">Meus Dados</a> | <a href="/backup/products-page/your-account/" style="text-decoration: none;color:#FFFFFF;">Histórico de pedidos </a> | <a href="http://www.labellastore.com/sair/" style="text-decoration: none;color:#FFFFFF;">Sair</a>
							</span>
				<?php } ?>
                                                
                            <!-- CONTATO -->
                            <div id="contato_topo">
                            	<span class="contato_topo">contato@labellastore.com |</span>
                            </div>
                            
                            <!-- REDES SOCIAIS -->                                               
                           <div id="redes_sociais">
                               <img src="http://www.labellastore.com/wp-content/themes/mazine/images/labella/redes_sociais.png" usemap="#Image-Maps_7201308220930081" border="0">

                                    <map id="_Image-Maps_7201308220930081" name="Image-Maps_7201308220930081">
                                        <area shape="rect" coords="0,0,15,19" href="https://www.facebook.com/labellastore" alt="Facebook" title="Facebook"  target="_blank"  />
                                        <area shape="rect" coords="28,0,43,19" href="https://twitter.com/labellastore1" alt="Twitter" title="Twitter"   target="_blank" />
                                        <area shape="rect" coords="67,0,82,19" href="callto://labellastore/" alt="labellastore" title="labellastore"    />
                                        <area shape="rect" coords="137,0,100,19" href="http://www.pinterest.com/labellastore/" alt="Pinterest" title="Pinterest"    />
                                        
                                        <area shape="rect" coords="120,22,122,24" href="http://www.image-maps.com/index.php?aff=mapped_users_7201308220930081" alt="Image Map" title="Image Map" />
                                    </map>                               
                                
                           </div>			                                                
			</div>
			
			
			
			<div class="grid_12 header_container">
				<?php if( is_front_page() || is_home() ) { ?>
					<h1 id="logo">
					<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>" class="tooltip">
					<?php 
	
						$options = get_option('ti_options');
  						$file = $options['file'];
					
  						 if (!isset($file['error'])) {
        				
        					echo "<img src='{$file['url']}' alt='' />";
    				
    					 } else { 
    			 ?>	
					<?php bloginfo('name'); ?>
					
				<?php } ?>		
					
					</a></h1>
				<?php } else { ?>
				
				<h2 id="logo">
					
					<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>" class="tooltip">
					
					<?php 
					
					$options = get_option('ti_options');
  					
  					$file = $options['file'];
  					
  					 if (!isset($file['error'])) {
  					 
  	    				echo "<img src='{$file['url']}' alt='' />";
    				
    				 } else { ?>	
				
					
					<?php bloginfo('name'); ?>
					
				<?php } ?>		
					
					</a></h2>
				
				<?php } ?>
				<?php /* ?><div id="description"><?php bloginfo('description'); ?></div><?php */ ?>
				<nav id="sub_links">
					<?php //wp_nav_menu( array('menu' => 'Secondary Header Menu' )); /* editable within the Wordpress backend */ ?>
				</nav>
				<div id="sidebar_header"><?php dynamic_sidebar('Header');	 ?></div>		

<script>
    $(function(){
      // bind change event to select
      $('#combo_marcas').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>


<form action="<? bloginfo('url'); ?>" method="get">

<?php
$my_postid = 2023;//This is page id or post id
$content_post = get_post($my_postid);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo $content;

wp_reset_query(); ?>

 
</form>

				<div id="cart">
					<div id="cart_content">
							<?php dynamic_sidebar('Header Cart');	 ?>
					</div>
					<div id="cart_footer"></div>
				</div>
				<div class="clear"></div>
				<div id="container">
					<div id="container_r">
						<div id="container_b">
							<nav id="main_menu">
								<div id="smoothmenu1" class="ddsmoothmenu">
										
									<?php 
									
									/*wp_nav_menu(
				                    array(
				                        'theme_location' => 'header_menu',
				                        'container_id' => 'menu',
				                        'link_before' => '<span>',
				                        'link_after' => '</span>',
				                    )
				                );**/
													
									
									//wp_nav_menu( array( 'theme_location' => 'header_menu')); /* editable within the Wordpress backend */ 
																		
									wp_nav_menu( array(
										'container' => false, 
										'menu_id' => 'nav', 
										'depth' => 0,
										'theme_location' => 'primary', 
										//this is the important part, we tell it to use the nav walker we just wrote
										'walker' => new ik_walker())
									);
									?>
								</div>
							</nav><!--#main_menu-->


							
							<form method="get" name="head_search" id="search_form" action="<?php bloginfo('url'); ?>">
							
								<div id="searchback">
									<input type="text" onblur="if(this.value =='') this.value='Buscar Produtos'" onfocus="if (this.value == 'Buscar Produtos') this.value=''"  value="<?php if (esc_html($s)) echo esc_html($s); else echo 'Buscar Produtos'; ?>" name="s" class="required" id="s"/>
									<a id="header_search_button"></a>
								</div>
							</form>
							<div class="clear"></div>
					</div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="clear"></div>
	</header>
