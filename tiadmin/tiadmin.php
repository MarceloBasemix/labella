<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

include_once('includes/swfobject.php');

function gettitle($gal){
				return nggGallery::i18n($gal[0]->name);
			}
			
function getGallery($galleryID){
			
				$gallery = array();
				global $wpdb;
				$ngg_options = get_option ('ngg_options');
				$siteurl	 = site_url();
			
				// get the pictures
				if ($galleryID == 0) {
					$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
				} else {
				
	
					$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '".$galleryID."' AND tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
				}
				return $thepictures;
			}

if (!class_exists('TiAdminPanel')){
	class TiAdminPanel{
	//--------Making sure we are a static class-----------	
		private static $instance = NULL;
		public function __construct(){
		}
		public function __destruct(){
		}
		public function __clone(){
		}
		static function getInstance(){
			if (self::$instance == NULL){
			 	self::$instance = new TiAdminPanel();
			 }
			 return self::$instance;
		}
	//----Implementation-------
		//-----Setting Defaults-----------------
		private static $themeName = "MyTheme";
		private static $actions = array();	
		private static $shortcodes = array();
		private static $jscripts = array();
		private static $adminTabs = array();
		private static $themeprefix = "mytheme";
		private static $colorSchemes = array();
		//----Getters & Setters-----------------	
		public static function SetThemeName($name){
			TiAdminPanel::$themeName = $name;
		}
		public static function GetThemeName(){
			return TiAdminPanel::$themeName;
		}
		public static function SetThemePrefix($name){
			TiAdminPanel::$themeprefix = $name;
		}
		public static function GetThemePrefix(){
			return TiAdminPanel::$themeprefix;
		}
		//------Helper functions-----------------
		public static function AddAction($tag, $callback){
			array_push(TiAdminPanel::$actions, array($tag , $callback));
		}
		public static function AddScript($script_id, $script_url){
			array_push(TiAdminPanel::$jscripts, array($script_id, $script_url));
		}
		public static function AddShortCode($code, $callback){
			array_push(TiAdminPanel::$shortcodes, array($code , $callback));			
		}
		public static function AddAlert($type, $message){
			add_settings_error(TiAdminPanel::GetThemePrefix().'alert','id_'.TiAdminPanel::GetThemePrefix(), $message, $type);
		}
		public static function GetThemeOptions(){
			settings_fields(TiAdminPanel::GetThemePrefix() );
		}
		public static function CheckColorField($input){
			
			/*if ($input != 'Hello'){
					TiAdminPanel::AddAlert('error', 'Invalid input format');				
				return get_option('color_scheme');
			}else{
				
				return $input;
			}*/
			
			return $input;
                
					
		}
		public static function SetThemeOptions(){
			
			
			function mazine_validate_email($input){
				$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
				if (preg_match($regexp, $input)) {
					    return $input;
					} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid e-mail address');
					   return get_option('cgemail');
					   
				}
			}
			
			function validate_phone($input){
				$regexp = "/[0-9\+\-]/";
				if (preg_match($regexp, $input)) {
					    return $input;
				} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid fax number');
					   return get_option('cphone');
				}
			}
			
			function validate_fax($input){
				$regexp = "/[0-9\+\-]/";
				if (preg_match($regexp, $input)) {
					    return $input;
					} else {
					   TiAdminPanel::AddAlert('error', 'This is not a valid phone number');
					   return get_option('cfax');
					   
				}
			}
			
			register_setting( TiAdminPanel::GetThemePrefix(), 'color_scheme');
			register_setting( TiAdminPanel::GetThemePrefix(), 'ganalytics' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'caddress' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cphone' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cfax' );
			register_setting( TiAdminPanel::GetThemePrefix(), 'cgemail' );
		}
		
		public static function GetColorScheme(){
		
			foreach(TiAdminPanel::$colorSchemes as $scheme){
			
				if (get_option('color_scheme') == $scheme['id']) return $scheme['css'];  
				
			}
		
		}
		
		public static function RegisterScripts(){
			foreach(TiAdminPanel::$jscripts as $script){
			 	wp_deregister_script($script[0]);
				wp_register_script($script[0], get_template_directory_uri().'/js/'.$script[1]);
				wp_enqueue_script($script[0]);
			}
		} 
		public static function RegisterActions(){
			foreach(TiAdminPanel::$actions as $action){
				add_action($action[0], $action[1]);
			}
		}
		public static function RegisterShortcodes(){
			foreach(TiAdminPanel::$shortcodes as $shortcode){
				add_shortcode($shortcode[0], $shortcode[1]);
			}
		}
		// --- Runtime alert------------
		public static function AlertNow($type, $message){
			switch($type){
					case "success": 
						$output .= '<div class="success"><div class="success_icon"></div>'.$message.'</div>'; 
						break;
					case "warning": 
						$output .= '<div class="warning"><div class="warning_icon"></div>'.$message.'</div>';
						break;
					case "error":
						 $output .= '<div class="error"><div class="error_icon"></div>'.$message.'</div>';
						 break;
						case "info": $output .= '<div class="info"><div class="info_icon"></div>'.$message.'</div>';
						break;
				}
				echo $output;
		}
		
		//----------The Actual Work is done here ------------------------
		
	
		
		//----------Registering color schemes----------------------------
		
		public static function RegisterColor($id, $color_icon, $color_name, $color_css){
			array_push(TiAdminPanel::$colorSchemes, array('id'=>$id,'icon'=>$color_icon, 'name'=>$color_name, 'css'=>$color_css));
		}
		
		//-----creating top level menu----------
		public static function TiBuildAdminMenu(){
		
			$html = '<div id="tabs">
						<ul>';
			
			$i = 0;
			
			foreach(TiAdminPanel::$adminTabs as $tab){
				$i++;
				$html .= '<li><a href="#tabs-'.$i.'"><span>'.$tab[0].'</span></a></li>';
			}
			
			$html .= '</ul>';
			$i = 0;
			foreach(TiAdminPanel::$adminTabs as $tab){
				$i++;
				$html .= '<div id="tabs-'.$i.'">'.$tab[1].'</div>';
			}
			
			$html .= '</div>';
			
			return $html;
		}
		
		public static function AddStyles(){
				if ( !is_admin() ) { 
					$styles = TiAdminPanel::GetColorScheme();
					if ($styles != '') wp_enqueue_style('color',$styles);
				}
		}
		
		public static function TiAddAdminScripts(){
			if ( is_admin() ) { 
				wp_enqueue_style('tiadminstyle', get_bloginfo('template_directory') . '/tiadmin/admin.css');
			   	wp_enqueue_script('jquery-ui-tabs');
			   	wp_register_script('tiadmin',get_bloginfo('template_directory') . '/tiadmin/tiadmin.js',array('jquery'));
			   	wp_enqueue_script('tiadmin');
			}
		}
		public static function TiAddAdminSection($heading, $content){
			array_push(TiAdminPanel::$adminTabs, array($heading, $content));
		}
		
		public static function TiTopLevelMenu(){
			add_submenu_page('themes.php',TiAdminPanel::GetThemeName().' Options', TiAdminPanel::GetThemeName().' settings', 'manage_options', TiAdminPanel::GetThemePrefix(), 'TiAdminPanel::TiThemeOptions', '', 95);
			add_action( 'admin_init', 'TiAdminPanel::SetThemeOptions' );

		}
		

		public static function ContactsMapAddressWidget(){
			
			$html .= '<h4>Fill out the form below to enable Contacts Widget on contact page</h4>';
			$html .= '<div class="wrapper">';
			$html .= '<p><label for="caddress">Address:</label>&nbsp;<input type="text" id="caddress" name="caddress" value="'.get_option('caddress').'"/></p>';
			$html .= '<p><label for="cphone">Phone:</label>&nbsp;<input type="text" id="cphone" name="cphone" value="'.get_option('cphone').'"/></p>';
			$html .= '<p><label for="cfax">Fax:</label>&nbsp;<input type="text" id="cfax" name="cfax" value="'.get_option('cfax').'"/></p>';
			$html .= '<p><label for="cgemail">E-mail:</label>&nbsp;<input type="text" id="cgemail" name="cgemail" value="'.get_option('cgemail').'"/></p>';
			$html .= '</div>';
			return $html;	
		
		}
		
		
		public static function HomePageTab(){
		
			$html = '<h4>Home page settings</h4>';
			$html .= '<p></p>';
			
			return $html;
		}
		
		public static function GoogleAnalyticsTab(){
		
			$html = '<h4>Paste your web property ID into the text field below to activate your Google Analytics Tracking snippet</h4>';
			$html .= '<p><label for="ganalytics">Analytics Code:</label>&nbsp;<input type="text" id="analytics" name="ganalytics" value="'.get_option('ganalytics').'"></p>';
			
			return $html;
		}
		
		public static function ColorSchemesTab(){
		
			
		
			$html = '';
			
			$html .= '<h4>Please choose color scheme for your theme</h4>';
			$html .= '<p>You may pick from one of the following color schemes</p>';
			
		
			//$html .= '<ul id="color-schemes">';
		
			$html .= '<table class="colorscheme">';
			
			foreach(TiAdminPanel::$colorSchemes as $scheme){
				
				if (get_option('color_scheme') == $scheme['id']) $checked = 'checked'; else $checked = '';
				
				//$html .= '<li><img src='.$scheme['icon'].' alt="'.$scheme['name'].'"/> <input type="radio" name="color_scheme" value="'.$scheme['id'].'" '.$checked.' ></li>';
				$html .= '<tr><td><img src='.$scheme['icon'].' alt="'.$scheme['name'].'"/></td><td>'.$scheme['name'].'</td>'.'<td><input type="radio" name="color_scheme" value="'.$scheme['id'].'" '.$checked.' ></td></tr>';
				
				
			}
			
			//$html .= '</ul>';
							
			$html .= '</table>';
			
			
			
			return $html;
		
		}
		
		//-----building dasboard page----------
		public static function BuildDashboardPage(){
			
			function settitle(){
				$text = '<h2>'.TiAdminPanel::GetThemeName().' theme settings </h2>';
				return $text;
			}
			echo '<div class="wrap"><div class="icon32" id="icon-themes"><br></div>';
			echo settitle();
			echo '</div>';
			echo settings_errors();
			echo '<form method="post" action="options.php">';
			?> <p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
</p><?php

			TiAdminPanel::GetThemeOptions();
			TiAdminPanel::TiAddAdminSection('Color Schemes',TiAdminPanel::ColorSchemesTab());
			TiAdminPanel::TiAddAdminSection('Google Analytics',TiAdminPanel::GoogleAnalyticsTab());
			TiAdminPanel::TiAddAdminSection('Contacts Page',TiAdminPanel::ContactsMapAddressWidget());
			
			
			
			echo TiAdminPanel::TiBuildAdminMenu();
			?> <p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
</p><?php
			echo '</form>';
			
		}
		//--------theme options handler-----------
		public static function TiThemeOptions(){
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			TiAdminPanel::BuildDashboardPage();
		}
		//----Container (shortcodes for content building)-----------------------
		
		public static function Wrapper($atts, $content = null){
			extract( shortcode_atts( array(
				), $atts ) );
				
				return '<div class="grid_'.$width.'">'.$content.'</div>';
		}
		
		public static function Container($atts, $content = null){
			extract( shortcode_atts( array(
					'width' => 1,
					'chrome' => 'fance'
				), $atts ) );
				
				if ($chrome != 'box') return '<div class="grid_'.$width.'"><div class="'.$chrome.'">'.$content.'</div></div>';
					else return '<div class="grid_'.$width.'"><div class="'.$chrome.'"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">'.$content.'</div></div></div></div></div></div></div></div></div>';
		}
		
		
		
		//----Piecemaker-----------------------
		public static function Flashmo($atts){
		
			if (class_exists('nggLoader')){
				extract( shortcode_atts( array(
					'id' => 0,
					'width' => 920,
					'height' => 360
				), $atts ) );
				
				
			//if there is no nextGenGallery tell to get one
			} else {  
				TiAdminPanel::AlertNow('error','NextGen Gallery plugin is not installed. I can not show you the gallery');
			}
		
			$swiff = new FlashObject(get_bloginfo('template_directory').'/galleries/flashmo_slider.swf', 920, 360, 'This is supposed to be a flashmo slider', 'flashmo'); 

			$swiff->setVariables(array( 
			    'xml_file' => htmlspecialchars_decode(get_bloginfo('siteurl').'/?callback=flashmo&gid='.$id)
			    
			   )); 
			
			
			$swiff->setParams(array( 
			    'wmode' => 'transparent'  
			   )); 
			
			
			// Or assign for later use
			 
		
			$html .= $swiff->get();
			
			$html .= '';
			 
			echo $html;
		
		}
		
		
		//----Coin Slider----------------------
		
		public static function CoinSlider($atts){
			
			function toHTMLcoin($gal){
			
				global $nggdb;
				$html = '<div id="coin-slider">';
								$elid = 0;	
				foreach($gal as $item){
					$elid++;
					 $picture = nggdb::find_image($item->pid);
					
					$html .= '<a href="'.$picture->imageURL.'" target="_blank">
					<img src='.$picture->imageURL.' alt="'.nggGallery::i18n($item->alttext).'" >
					<span>
						'.$item->description.'
					</span>
					</a>';

				}
				
				$html .= '</div>';
				return $html;
			
			}
			
			if (class_exists('nggLoader')){
				extract( shortcode_atts( array(
					'id' => 0,
				), $atts ) );
				
				$gallery = getGallery($id);
				echo toHTMLcoin($gallery);
				
			//if there is no nextGenGallery tell to get one
			} else {  
				TiAdminPanel::AlertNow('error','NextGen Gallery plugin is not installed. I can not show you the gallery');
			}
			
		
		}

		//----Mazine Slider Short Code----------
		public static function MazineSlider($atts){
		
			function toHTMLmazine($gal){
				global $nggdb;
				$html = '<div style="display:none" id="featured_box"><ul>';
								$elid = 0;	
				foreach($gal as $item){
					$elid++;
					 $picture = nggdb::find_image($item->pid);
					$html .= '<li>
							<a href="'.$picture->imageURL.'"><img src="'.$picture->thumbURL. '" title="" alt="" /></a>
						<div class="caption">
							<h3>'.nggGallery::i18n($item->alttext).'</h3>
							'.$item->description.'
						</div>
							
						</li>';
				}
				
				$html .= '</ul></div>';
				return $html;
			}
			
			if (class_exists('nggLoader')){
				extract( shortcode_atts( array(
					'id' => 0,
				), $atts ) );
				$gallery = getGallery($id);
				echo toHTMLmazine($gallery);
				
			//if there is no nextGenGallery tell to get one
			} else {  
				TiAdminPanel::AlertNow('error','NextGen Gallery plugin is not installed. I can not show you the gallery');
			}
			
		} 
		
		//----Gallery Page Short Code-----------
		public static function Gallery($atts){
			
			if (!function_exists('getfilters')){
			function getfilters($gal){
				$filters = array();
				foreach($gal as $item){
					$filters = array_merge($filters,wp_get_object_terms($item->pid, 'ngg_tag', 'fields=names'));
				}
				$filters = array_unique($filters);
				foreach($filters as $filter){
					$html .= '<li><a id="'.$filter.'"><span>'.$filter.'</span></a></li>';
				}				
				return $html;
			}
			}
			
			if (!function_exists('toHTML')){
			function toHTML($gal){
				global $nggdb;
				$html = '';
				$html .= ' <div class="smaller-title border">
							<h2 class="category-title">'.gettitle($gal).'</h2>
							<div class="categories">
							<ul id="filters">
								<li><a id="none" class="selected"><span>all</span></a></li>
								'.getfilters($gal).'
							</ul>
							</div>
							</div>';
				$html .= '<div class="gal-wrapper">
							<ul class="images-gallery" id="all">';
				$elid = 0;	
				foreach($gal as $item){
					$elid++;
					 $picture = nggdb::find_image($item->pid);
					$html .= '
							<li class="'.implode(' ', wp_get_object_terms($item->pid, 'ngg_tag', 'fields=names')).'" data-id="'.$elid.'">
							<div class="ic_container"><a title="'.stripslashes(nggGallery::i18n($item->alttext)).'" rel="group" href="'.$picture->imageURL.'"><img src="'.$picture->thumbURL.'" alt="Hello World" /></a>
							<div class="ic_caption">
							<h3>'.stripslashes(nggGallery::i18n($item->alttext)).'</h3>
							<p class="ic_text">'.$item->description.'</p>
							</div>
							</div></li>';
				}
				
				$html .= '	</ul><div class="clear"></div>
						</div>';
				return $html;
			}
			}
			//----we have to check if there is a nextGenGalleryPlugin
			if (class_exists('nggLoader')){
				extract( shortcode_atts( array(
					'id' => 0,
				), $atts ) );
				
				$gallery = getGallery($id);
				echo toHTML($gallery);
			//if there is no nextGenGallery tell to get one
			}
			else {  
					TiAdminPanel::AlertNow('error','NextGen Gallery plugin is not installed. I can not show you the gallery');
				}
		} 
		
	}
}
	
//-----Preapre Theme and Admin Settings----------------
	TiAdminPanel::SetThemeName('Mazine');
	TiAdminPanel::SetThemePrefix('mazine');
	TiAdminPanel::AddAction('admin_menu', 'TiAdminPanel::TiTopLevelMenu');
	TiAdminPanel::AddShortcode('gallery', 'TiAdminPanel::Gallery');
	TiAdminPanel::AddShortcode('mazine_slider', 'TiAdminPanel::MazineSlider');
	TiAdminPanel::AddShortcode('coin_slider', 'TiAdminPanel::CoinSlider');
	TiAdminPanel::AddShortcode('flashmo_slider', 'TiAdminPanel::Flashmo');
	
	TiAdminPanel::AddShortcode('container', 'TiAdminPanel::Container');
	TiAdminPanel::AddShortcode('wrapper', 'TiAdminPanel::Wrapper');
	
	TiAdminPanel::TiAddAdminScripts();
	TiAdminPanel::RegisterScripts();
	TiAdminPanel::RegisterShortcodes();
	TiAdminPanel::RegisterActions();
	TiAdminPanel::RegisterColor('csyellow',get_bloginfo('template_directory').'/colors/yellow.png', 'yellow', get_bloginfo('template_directory').'/colors/yellow.css');
			TiAdminPanel::RegisterColor('csbrown',get_bloginfo('template_directory').'/colors/brown.png', 'brown', get_bloginfo('template_directory').'/colors/brown.css');
			TiAdminPanel::RegisterColor('csgreen',get_bloginfo('template_directory').'/colors/green.png', 'green', get_bloginfo('template_directory').'/colors/green.css');
			TiAdminPanel::RegisterColor('cspurple',get_bloginfo('template_directory').'/colors/purple.png', 'purple', get_bloginfo('template_directory').'/colors/purple.css');
			TiAdminPanel::RegisterColor('cstorquoise',get_bloginfo('template_directory').'/colors/turquoise.png', 'turquoise', get_bloginfo('template_directory').'/colors/turquoise.css');
			TiAdminPanel::RegisterColor('csdefault',get_bloginfo('template_directory').'/colors/blue.png', 'blue(default)', '');

	TiAdminPanel::AddStyles();
	
	
	function getAnalyticsCode(){
		
		$code = get_option('ganalytics');
		if ( $code != '') {
		
			return '<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \''.$code.'\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>';
		
		}
	}

?>
