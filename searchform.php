
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" style="height:21px; width:138px; float:left"  />
	<button style="height:27px; margin-top:-3px;" id="searchsubmit"><span><span><?php _e('Buscar','mazine'); ?></span></span></button>
</form>
