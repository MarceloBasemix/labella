	<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
			<div class="box border"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
				<h3><?php _e('navigation','mazine'); ?></h3>
				<?php wp_nav_menu( array('menu' => 'Sidebar Menu', 'menu_class' => 'list2 border' )); /* editable within the Wordpress backend */ ?>
			</div></div></div></div></div></div></div></div>
			<div class="box border"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
				<h3><?php _e('archives','mazine'); ?></h3>
				<ul class="list2 border">
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</div></div></div></div></div></div></div></div>
			<div class="box border"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">		
				<h3><?php _e('Meta','mazine'); ?></h3>
				<ul class="list2 border">
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</div></div></div></div></div></div></div></div>
	<?php endif; ?>
<!--sidebar-->