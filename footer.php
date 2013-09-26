<div class="clear"></div>


<footer>
	<div id="footback">
		<div class="container_12">
			<div class="grid_12 content">
				
				<div class="footer_container">
					<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
						<!--Wigitized Footer-->
					<?php endif ?>
					<div class="clear"></div>
				</div>
				<div id="end">
					&copy; <?php echo date("Y") ?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"> <?php bloginfo('name'); ?></a>.:. <?php _e('Todos os Direitos Reservados. &nbsp;','mazine') ?>
					<?php /*wp_nav_menu( array('menu' => 'Footer Menu', 'depth'=>'1' )); /* editable within the Wordpress backend */ ?> 
					 <!--<a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow"><?php _e('Entries (RSS)','mazine'); ?></a>  <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow"><?php _e('Comments (RSS)','mazine'); ?></a>-->
				</div>
			</div>	
		</div>
		<div class="clear"></div>
		</div>
	</footer>

<?php wp_footer(); /* this is used by many Wordpress features and for plugins to work proporly */ ?>
<?php echo getAnalyticsCode(); /* Enables google analytics tracking */ ?>
</body>
</html>