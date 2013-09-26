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
	
</head>

<body <?php body_class(); ?>>
	 <!--<div id="chrome"></div>-->
	<header>
		<div class="container_12">
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
					<?php wp_nav_menu( array('menu' => 'Secondary Header Menu' )); /* editable within the Wordpress backend */ ?>
				</nav>
						
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
									<?php wp_nav_menu( array( 'theme_location' => 'header_menu')); /* editable within the Wordpress backend */ ?>
								</div>
							</nav><!--#main_menu-->
							<form method="get" name="head_search" id="search_form" action="<?php bloginfo('url'); ?>">
							
								<div id="searchback">
									<input type="text" onblur="if(this.value =='') this.value='enter search terms'" onfocus="if (this.value == 'enter search terms') this.value=''"  value="<?php if (esc_html($s)) echo esc_html($s); else echo 'enter search terms'; ?>" name="s" class="required" id="s"/>
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
