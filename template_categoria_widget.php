<div id="menu_categoria_product_topo"></div>
<div id="menu_categoria_product_meio">
<?php

$catname_main = wpsc_category_name();

if (!empty($catname_main)){ 

echo '<h3 class="category-title"><span style="color:#960d5d">'.$catname_main.'</span></h3>';

}else{

//echo '<h3 class="category-title"><span style="color:#960d5d">Categorias</span></h3>';
echo'<style>
#menu_categoria_product_meio{
margin-top:-20px !important;	
}
</style>';

}

$category_id = wpsc_category_id();

if (empty($category_id)){

dynamic_sidebar( 'Sidebar' );
	 
}else{


$getsubs = "SELECT term_id FROM wp_term_taxonomy WHERE taxonomy = 'wpsc_product_category' AND parent = '".$category_id."' ORDER BY term_id ASC limit 15";
$subcats = mysql_query($getsubs); //this gets the ids of the subcategories
$num_subcats = mysql_num_rows($subcats); //this is a count of how many subcategories the current category has
while ($row = mysql_fetch_row($subcats)) {
if ($num_subcats > 0){
foreach ($row as $subcat) //this loops through the subcategories of the current category
$catname = wpsc_category_name($subcat); //just assigning variables here to call the category name, image and url
$catimage = wpsc_category_image($subcat);
$catdesc = wpsc_category_description($subcat);
$getsubslug= "SELECT slug FROM wp_terms WHERE term_id = '".$subcat."' limit 1";// query wp terms * rc
$xsubslug = mysql_query($getsubslug);
$subslugs = mysql_fetch_row($xsubslug);
foreach ($subslugs as $subslug)
$subcatlink = get_term_link($subslug,'wpsc_product_category');// here what I chaged $catlink to $subslug * rc
//$catlink = get_term_link($catname,'wpsc_product_category');
echo "<br/>category_id: ".$category_id;
//if ($category_id == '0' || $category_id == '') {

//this code is for all other categories with subcategories
echo '
<div class="product_grid_item">
	<ul>
	<h4 class="prodtitle"><li><a class="wpsc_category_link" href="'.$subcatlink.'">'.$catname.'</a></li></h4>
	</ul>
</div>
';


}//our own sub cat display end
}



}
?>
</div>
<div id="menu_categoria_product_bottom"></div>