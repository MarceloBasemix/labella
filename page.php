<?php get_header(); ?>
<?php //echo "<br/>Page"; ?>

<style>
	#execphp-5 {
		margin-left: -1.5px;
	}
	
#execphp-4 .widget-2 {
	margin-left: -1.5px !important;
	background: none;	
}	
</style>

<?php global $iclUtility; global $post;?>
<section id="content">
	<div class="container_12">
	
<?php echo NggRandom_topo(5); ?>	
	
	<?php if (!$iclUtility->isOnWPSCpage() && !$post->post_type == "wpsc-product"): ?>
	
		<div class="grid_9 cont_col">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
			<div class="fance" id="post">
				<article>
					<div class="title border">
						<h1 class="category-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<div class="post-meta-written">
							<?php the_time('F j, Y'); ?> <?php _e('at','mazine'); ?> <?php the_time() ?><?php edit_post_link(__('&nbsp;|&nbsp;<small>Edit this entry</small>','mazine'),'',''); ?>
						</div>
					</div>
					
					<?php if ( has_post_thumbnail()) : ?>
						<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '<figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
					<?php endif; ?>
					<div id="post-content">
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
					</div><!--#post-content-->
				</article>
				<div class="post-meta">
						<div class="post-meta-taxonomy">
							<b><?php _e('Categories','mazine'); ?>:</b> <?php the_category(', ') ?> <br/> 
							<?php the_tags(__('<b>Tags:</b> ','mazine'), ', ', ' '); ?><br/>
							<b><?php _e('Recieve new post updates:','mazine'); ?></b>&nbsp;<a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow"><?php _e('Entries (RSS)','mazine'); ?></a>
							<br />
							<b><?php _e('Recieve follow up comments updates','mazine');?>:</b>&nbsp;<?php post_comments_feed_link(); ?>
						</div>
						<div class="post-meta-comments">
							<?php comments_popup_link(__('No comments','mazine'), __('One comment','mazine'), __('% comments','mazine'), 'comments-link', __('Comments are closed','mazine')); ?>
						</div>
					</div>
				</div>
		</div><!--#post-# .post-->

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>
</div><!--#content-->
<div class="grid_3 side_col_right">
<?php get_sidebar(); ?>
</div>

<?php else : ?>

<?php if(!is_single() ): 

$id = get_the_ID();
$pagina = 1703;
$pagina2 = 1705;
$pagina3 = 1410;
$pagina4 = 1706;
$pagina5 = 1707;

if($id == $pagina || $id == $pagina2 || $id == $pagina3 || $id == $pagina4 || $id == $pagina5){

}else{
?>	
		<div class="grid_3 side_col_left">
			<?php if (!is_page('checkout') ){
					
				if ( ! dynamic_sidebar( 'Store Page Sidebar' )) : ?>
						
			<?php endif;
					
			} ?>
		</div>
	<?php }
	
	endif; ?>
		<div class="grid_9 cont_col">
		<?php if(!(wpsc_is_in_category())): ?>
			
			<?php if ( ! dynamic_sidebar( 'Banner Holder' )) : ?>
						
			<?php endif; ?>
			
		<?php endif; ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
	<?php endwhile; ?>
		</div>
		<?php if(is_single()): ?>	
		<div class="grid_3 side_col_left">
			<?php if ( ! dynamic_sidebar( 'Store Page Sidebar' )) : ?>
						
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php endif; ?>



		<div class="clear"></div>
<?php echo NggRandom_bottom_left(3); echo NggRandom_bottom_right(6);?>	
	</div>	
</section>
<?php get_footer(); ?>
