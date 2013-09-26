<?php

add_action('parse_request', 'flashmo_request' );


function flashmo_request($wp){

if ( !array_key_exists('callback', $wp->query_vars) ) return;

if ( $wp->query_vars['callback'] == 'flashmo') {

		
/*
+----------------------------------------------------------------+
+	imageRotartor-XML
+	by Alex Rabe modified by Andy
+   	required for NextGEN Gallery modified by Andy
+----------------------------------------------------------------+
*/

// look up for the path
if ( !defined('ABSPATH') ) 
    require_once( dirname(__FILE__) . '/../ngg-config.php');

global $wpdb;

$ngg_options = get_option ('ngg_options');
$siteurl	 = site_url();

// get the gallery id
$galleryID = (int) $_GET['gid'];

// get the pictures
if ($galleryID == 0) {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
} else {
	$thepictures = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.{$ngg_options['galSort']} {$ngg_options['galSortDir']} ");
}

// Create XML output
header("content-type:text/xml;charset=utf-8");

echo "<photos>

	<config
		auto_play=\"true\" 
		auto_play_duration=\"2.4\" 
		grid_row=\"4\" 
		grid_column=\"6\" 
		tween_duration=\"0.7\" 
		tween_delay=\"0.02\"
		stylesheet=\"".get_bloginfo('template_directory')."/galleries/flashmo_style.css\"
		bar_status=\"0\">
	</config>";

$rotations = array('90', '180', '180', '-90');
$flow = array('out', 'in');
$direction = array('center', 'down', 'up', 'right', 'left');

if (is_array ($thepictures)){
	foreach ($thepictures as $picture) {
	echo "
	<photo>
		<filename>".$siteurl."/".$picture->path."/".$picture->filename."</filename>
		<description><![CDATA[".stripslashes(nggGallery::i18n($picture->alttext))."]]></description>
		<transition flow=\"".$flow[array_rand($flow)]."\" direction=\"".$direction[array_rand($direction)]."\" rotation=\"".$rotation[array_rand($rotation)]."\"></transition>
	</photo>";

	}
}
echo "</photos>\n";
       exit();
}




}





?>