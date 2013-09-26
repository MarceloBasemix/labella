<?php
	// enables wigitized sidebars
	if ( function_exists('register_sidebar') )

	// Sidebar Widget
	// Location: the sidebar
	register_sidebar(array('name'=>'Sidebar',
		'before_widget' => '<div class="box border %2$s" id="%1$s"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">',
		'after_widget' => '</div></div></div></div></div></div></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Header Widget
	// Location: right after the navigation
	register_sidebar(array('name'=>'Header',
		'before_widget' => '<div class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	// Footer Widget
	// Location: at the top of the footer, above the copyright
	register_sidebar(array('name'=>'Footer',
		'before_widget' => '<div class="%2$s inner-box box-3">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// The Alert Widget
	// Location: displayed on the top of the home page, right after the header, right before the loop, within the contend area
	register_sidebar(array('name'=>'Alert',
		'before_widget' => '<div class="alert-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// The Slider Widget
	// Location: displayed on the top of the home page, right after the header within the contend area, primary purpose is to contain sliders 
	register_sidebar(array('name'=>'Sliders',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	
	// The Category Widget
	// Location: displayed under the sliders on home page only, primary purpose is to contain shop categories slider 
	register_sidebar(array('name'=>'Categories',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<!--',
		'after_title' => '-->',
	));
	
	
	// The Home Sidebar Widget
	// Location: displayed in the content area floated right, only on home page 
	register_sidebar(array('name'=>'Home Sidebar',
		'before_widget' => '<div class="box border %2$s" id="%1$s"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">',
		'after_widget' => '</div></div></div></div></div></div></div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	
	// The Home Sidebar Widget
	// Location: displayed in the content area floated left, only on home page 
	register_sidebar(array('name'=>'Home Content',
		'before_widget' => '<div class="fance">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title border"><h2 class="category-title">',
		'after_title' => '</h2></div>',
	));
	
	
	// The Home Subcontent Widget
	// Location: displayed in the content area floated left, only on home page 
	register_sidebar(array('name'=>'Home Subcontent',
		'before_widget' => '<div class="%2$s inner-box box-3">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// The Home Supcontent Widget
	// Location: displayed in the content area floated left, only on home page 
	register_sidebar(array('name'=>'Home Supcontent',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	
	// The Header Cart Widget
	// Location: displayed in header, primary goal is to show shopping cart widget 
	register_sidebar(array('name'=>'Header Cart',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<!--',
		'after_title' => '-->',
	));
	
	// The Contacts Page Sidebar
	// Location: displayed in header, primary goal is to show shopping cart widget 
	register_sidebar(array('name'=>'Contacts Sidebar',
		'before_widget' => '<div class="box border %2$s" id="%1$s"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">',
		'after_widget' => '</div></div></div></div></div></div></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// The Store Page Sidebar
	// Location: displayed in header, primary goal is to show shopping cart widget 
	register_sidebar(array('name'=>'Store Page Sidebar',
		'before_widget' => '<div class="box border %2$s" id="%1$s"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">',
		'after_widget' => '</div></div></div></div></div></div></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// The Banner Sidebar
	// Location: displayed in the top of the store page, primary goal is to show banners 
	register_sidebar(array('name'=>'Banner Holder',
		'before_widget' => '<div class="space">',
		'after_widget' => '</div>',
		'before_title' => '<!--',
		'after_title' => '-->',
	));
	
	// The Special Sidebar
	// Location: displayed on home page before footer, primary goal is to show specials widget 
	register_sidebar(array('name'=>'Home Specials',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<!--',
		'after_title' => '-->',
	));
	


	if ( ! function_exists('mazine_css') ) {
		function mazine_css($wp) {
			$wp .= ',' . get_bloginfo('stylesheet_url');
		return $wp;
		}
	}
	add_filter( 'mce_css', 'mazine_css' );

	//----localization--------------------
	
	load_theme_textdomain( 'mazine', TEMPLATEPATH . '/locales' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/locales/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );


	// post thumbnail support
	add_theme_support( 'post-thumbnails' );

	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header_menu' => __('Header Menu'),
	  		  'subheader_menu' => __('Secondary Header Menu'),
	  		  'sidebar_menu' => __('Sidebar Menu'),
	  		  'footer_menu' => __('Footer Menu')
	  		)
	  	);
	}

	// custom background support
	//add_custom_background();
	
	// removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));
	
	//overrides menu output
	function ti_wp_nav_menu_args( $args = '' ){
		$args['theme_location'] = 'header_menu';
		$args['container'] = false;
		//$args['walker'] = new ti_menu_walker();
		$args['walker'] = new ik_walker();
				

		return $args;
	} // function
	add_filter( 'wp_nav_menu_args', 'ti_wp_nav_menu_args' );
	
	//show home page in menu options
	function ti_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'ti_page_menu_args' );
	
	// Removes <p> tags from content
	
	remove_filter ('the_content',  'wpautop');
	
	// Removes Trackbacks from the comment cout
	add_filter('get_comments_number', 'comment_count', 0);
	function comment_count( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
			return count($comments_by_type['comment']);
		} else {
			return $count;
		}
	}
	
	
	// wrapping all images
	function ti_image_tag($html, $id , $alt, $title){
		$html = "<figure>".$html."</figure>";
		return $html;
	}
	//add_filter('get_image_tag','ti_image_tag', 1, 4);
	
	// custom excerpt ellipses for 2.9+
	function custom_excerpt_more($more) {
		return 'Read More &raquo;';
	}
	add_filter('excerpt_more', 'custom_excerpt_more');
	// no more jumping for read more link
	function no_more_jumping($post) {
		return '&nbsp;<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
	}
	add_filter('excerpt_more', 'no_more_jumping');
	
	// category id in body and post class
	function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
			$classes [] = 'cat-' . $category->cat_ID . '-id';
			return $classes;
	}
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');
	
	function ti_footer_function() {
    	echo '<script> setThemeURL("'.get_template_directory_uri().'"); </script>';
    	
	}
	add_action('wp_head', 'ti_footer_function');
	
	
	function is_sidebar_active( $index = 1 ) {
		global $wp_registered_sidebars;
	
		if ( is_int( $index ) ) :
			$index = "sidebar-$index";
		else :
			$index = sanitize_title( $index );
			foreach ( (array) $wp_registered_sidebars as $key => $value ) :
				if ( sanitize_title( $value['name'] ) == $index ) :
					$index = $key;
					break;
				endif;
			endforeach;
		endif;
	
		$sidebars_widgets = wp_get_sidebars_widgets();
	
		if ( empty( $wp_registered_sidebars[$index] ) || !array_key_exists( $index, $sidebars_widgets ) || !is_array( $sidebars_widgets[$index] ) || empty( $sidebars_widgets[$index] ) )
			return false;
		else
			return true;
	}	
	
	function ti_change_mce_options($initArray) {
		$ext = 'figure';
		if ( isset( $initArray['extended_valid_elements'] ) ) {
			$initArray['extended_valid_elements'] .= ',' . $ext;
		} else {
			$initArray['extended_valid_elements'] = $ext;
		}
		return $initArray;
	}
	
	
	
	
	add_filter('tiny_mce_before_init', 'ti_change_mce_options');
	
	/**
	 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
	 */
	
	
	add_filter('widget_text', 'do_shortcode');
	
	function widget_first_last_classes($params) {
	
		global $my_widget_num; // Global a counter array
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	
	
		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}
	
		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}
	
		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}
	
		$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options
	
		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= 'alpha ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= 'omega ';
		}
	
		$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
	
		return $params;
	
	}
	add_filter('dynamic_sidebar_params','widget_first_last_classes');
	
	
	//----------------Custom Logo---------------------
	
	//add_custom_image_header( '', '' );
	
	
	//------PIE.htc for wordpress----------------------
	add_action('parse_request', 'pie_request' );
	
	function pie_request($wp){
	
		if ( !array_key_exists('callback', $wp->query_vars) ) return;

		if ( $wp->query_vars['callback'] == 'pie') {
			header("Location:".get_template_directory_uri().'/js/PIE.htc');
			exit;
		}
		
	}
	//------Images Rewrite----------------------------- 
	add_action('parse_request', 'path_request' );
	
	function path_request($wp){
	
		if ( !array_key_exists('callback', $wp->query_vars) ) return;
		
		if ( $wp->query_vars['callback'] == 'path') {
			header("Location:".get_template_directory_uri().'/'.urldecode($wp->query_vars['p']));
			 
			exit;
		}
	
	} 
	
	//--wp-e-commerece utilities-----------------------
	function isOnWPSCpage(){
        global $post;
        return  ($this->isOnWPSCList() || $this->isOnUserLogPage() || $this->isOnAccountPage() ||
                $this->isOnProductPage() || $this->isOnShoppingCartPage() || $this->isOnTransactionPage());
            
        //return false;
    }
	
	
	//---- Custom menu Walker---------------------------
	
	/*class ti_menu_walker extends Walker_Nav_Menu
	{
	      function start_el(&$output, $item, $depth, $args)
	      {
	           global $wp_query;
	           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	           $class_names = $value = '';
	
	           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
				if ($item->menu_order == 1) {
					$classes[] = 'alpha';
				}
	           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	           $class_names = ' class="'. esc_attr( $class_names ) . '"';
	
				//echo esc_attr( $class_names );
	           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
	
	           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
	           $prepend = '';
	           $append = '';
	        	
	           if($depth != 0)
	           {
	                     $description = $append = $prepend = "";
	           }
				
				
	            $item_output = $args->before;
				//$item_output .= '<div class="pointer">Teste</div>';
				
	            $item_output .= '<a'. $attributes .'><span><span>';
	            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
	            $item_output .= $description.$args->link_after;
	            $item_output .= '</span></span></a>';
	            $item_output .= $args->after;
	
	            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	            }
	}
	*/
	
	
	add_action('admin_init', 'ti_admin_init');
function ti_admin_init() {
    register_setting( 'ti_options', 'ti_options', 'ti_options_validate' );
    add_settings_section('ti_main', 'Choose Logo', 'ti_section_text', 'ti');
    add_settings_field('ti_filename', 'File:', 'ti_setting_filename', 'ti', 'ti_main');
}

// add the admin options page
add_action('admin_menu', 'ti_admin_add_page');
function ti_admin_add_page() {
    $mypage = add_theme_page('Custom Logo', 'Custom Logo', 'manage_options', 'ti', 'ti_options_page');
}

// display the admin options page
function ti_options_page() {
?>
    <div class="wrap">
    <h2>Upload Custom Logo Image</h2>
    <p>Upload the logo image you would like to have.</p>
    <form method="post" enctype="multipart/form-data" action="options.php">
    <?php settings_fields('ti_options'); ?>
    <?php do_settings_sections('ti'); ?>
    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>
    </form>

    </div>
    
<?php
}

function ti_section_text() {
    $options = get_option('ti_options');
    echo '<p>Upload your logo here:</p>';
    if ($file = $options['file']) {
        // var_dump($file);
        echo "<img src='{$file['url']}' />";
    }
}

function ti_setting_filename() {
    echo '<input type="file" name="ti_filename" size="40" />';
}

function ti_options_validate($input) {
    $newinput = array();
    if ($_FILES['ti_filename']) {
        $overrides = array('test_form' => false); 
        $file = wp_handle_upload($_FILES['ti_filename'], $overrides);
        $newinput['file'] = $file;
    }
    return $newinput;
}
	
	
	
	include_once('tiadmin/tiadmin.php');
	include_once('extensions/contact7submit.php');
	include_once('extensions/nlajaxwidget.php');
	include_once('extensions/gmapswidget.php');
	include_once('extensions/nggcustomajax.php');
	include_once('extensions/sliderswidget.php');
	include_once('extensions/nggfeatured.php');
	include_once('extensions/wpscmazinecats.php');
	include_once('extensions/wpscspecialsdwidget.php');
	include_once('extensions/wpsclatestwidget.php');
	include_once('extensions/icl_utility.php');
	$iclUtility = new IclUtility();

	
$blogusers = get_users();
foreach ($blogusers as $user) {
    update_user_meta( $user->ID, 'show_admin_bar_front', 'false' );
}




function NggRandom_topo($galleryId = 0) {

    // get now the recent or random images
    $picturelist = nggdb::get_random_images(5, $galleryId);
    //echo $image->ngg_custom_fields["customlink"];
    //print_r($picturelist[0]->description);

$out = '<div id="galeria_random" style="float: left; height: 223px;overflow: hidden; width: 960px;">
			
			<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
				<img src="'.$picturelist[0]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
			</a>';

	if (!empty($picturelist[1])){
	
		$out .= '&nbsp;<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
			<img src="'.$picturelist[1]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
		</a></div>';
	
	}else{
	
		$out .= '</div>';	
	}

    return $out;
}

function NggRandom($galleryId = 0) {

	// get now the recent or random images
	$picturelist = nggdb::get_random_images(5, $galleryId);
	//echo $image->ngg_custom_fields["customlink"];
	//print_r($picturelist[0]->description);

	$out = '<div id="galeria_random" style="float: left; overflow: hidden; width: 960px;">
		
			<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
				<img src="'.$picturelist[0]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
			</a>';

	if (!empty($picturelist[1])){

		$out .= '&nbsp;<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
			<img src="'.$picturelist[1]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
		</a></div>';

	}else{

		$out .= '</div>';
	}

	return $out;
}

function NggRandom_bottom_left($galleryId = 0) {

	// get now the recent or random images
	$picturelist = nggdb::get_random_images(5, $galleryId);


	$out = '<div id="galeria_random" style="float: left; overflow: hidden; width: 295px; height:380px;margin-bottom: 10px;">

			<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
				<img src="'.$picturelist[0]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
			</a>';

	if (!empty($picturelist[1])){

		$out .= '&nbsp;<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
			<img src="'.$picturelist[1]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
		</a></div>';

	}else{

		$out .= '</div>';
	}

	return $out;
}

function NggRandom_bottom_right($galleryId = 0) {

	// get now the recent or random images
	$picturelist = nggdb::get_random_images(5, $galleryId);


	$out = '<div id="galeria_random" style="float: left; overflow: hidden; width: 625px; height:380px;margin-bottom: 10px;">

			<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
				<img src="'.$picturelist[0]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
			</a>';

	if (!empty($picturelist[1])){

		$out .= '&nbsp;<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'" >
			<img src="'.$picturelist[1]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
		</a></div>';

	}else{

		$out .= '</div>';
	}

	return $out;
}


function NggRandom_sidebar($galleryId = 0) {

    // get now the recent or random images
    $picturelist = nggdb::get_random_images(5, $galleryId);

$out = '<div id="galeria_random" style="width: 230px;">
			
			<a href="'.$picturelist[0]->description.'" title="'.get_bloginfo('name').'">
				<img src="'.$picturelist[0]->imageURL.'" title="'.get_bloginfo('name').'" alt="'.get_bloginfo('name').'" />
			</a></div>';

    return $out;
}


class ik_walker extends Walker_Nav_Menu{
	//start of the sub menu wrap
	/*function start_lvl(&$output, $depth) {
		$output .= '<div class="drop">
						<div class="holder">
							<div class="container">
								<ul class="list">';
	}
 
	//end of the sub menu wrap
	function end_lvl(&$output, $depth) {
		$output .= '
					</ul>
				</div>
			</div>
			<div class="bottom"></div>
		</div>';
	}*/
	
	function start_lvl(&$output, $depth) {
		$output .= '<ul class="sub-menu"><div id="topo_submenu"></div>';
	}
 
	//end of the sub menu wrap
	function end_lvl(&$output, $depth) {
		$output .= '<div class="rodape_submenu"></div></ul>';
	}
		
 
	//add the description to the menu item output
	      function start_el(&$output, $item, $depth, $args)
	      {
	           global $wp_query;
	           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	           $class_names = $value = '';
	
	           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
				if ($item->menu_order == 1) {
					$classes[] = 'alpha';
				}
	           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	           $class_names = ' class="'. esc_attr( $class_names ) . '"';
	
				//echo esc_attr( $class_names );
	           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
	
	           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	
	           $prepend = '';
	           $append = '';
	        	
	           if($depth != 0)
	           {
	                     $description = $append = $prepend = "";
	           }
				
				
	            $item_output = $args->before;
				//$item_output .= '<div class="pointer">Teste</div>';
				
	            $item_output .= '<a'. $attributes .'><span><span>';
	            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
	            $item_output .= $description.$args->link_after;
	            $item_output .= '</span></span></a>';
	            $item_output .= $args->after;
	
	            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	            }
}

add_action('init', 'product_thumbnails_init');
function product_thumbnails_init() {
add_post_type_support( 'wpsc-product', 'thumbnail' );
}


function string_limit_words($string, $word_limit)
{
   $words = explode(' ', $string, ($word_limit + 1));
   if(count($words) > $word_limit)
   array_pop($words);
   if(count($words) > 50){
    return implode(' ', $words)." ...";
   }else{
      return implode(' ', $words); 
   }
}

$blogusers = get_users();
foreach ($blogusers as $user) {
    update_user_meta( $user->ID, 'show_admin_bar_front', 'false' );
}

//Use shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');



// search filter
function fb_search_filter($query) {

	if ( !$query->is_admin && $query->is_search) {
		$query->set('post__not_in', array(4064, 4080) ); // id of page or post
	}

	return $query;
}
add_filter( 'pre_get_posts', 'fb_search_filter' );


 

?>