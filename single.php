<?php get_header(); ?>
<?php //echo "<br/>Single"; ?>
<section id="content"> 
	<div class="container_12"> 
		<div class="grid_9 cont_col">
		
		
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
			<div class="fance" id="post"> 
			<?php if ( get_post_type() == gallery ) { /* if a gallery */ ?>
				
				<article>
					<div class="title border">
						<h1 class="category-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<div class="post-meta-written">
							<?php the_time('F j, Y'); ?> <?php _e('at','mazine'); ?> <?php the_time() ?><?php edit_post_link(__('&nbsp;|&nbsp;<small>Edit this entry</small>','mazine'),'',''); ?>
						</div>
					</div>
					
					<?php if ( has_post_thumbnail()) : ?>
						<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
					<?php endif; ?>
					
					<div id="post-content">
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
					</div><!--#post-content-->
				</article>

			<?php } else { /* if not a gallery */ ?>

				<article>
					<div class="title border">
						<h1 class="category-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<div class="post-meta-written">
							<?php the_time('F j, Y'); ?> <?php _e('at','mazine'); ?> <?php the_time() ?><?php edit_post_link(__('&nbsp;|&nbsp;<small>Edit this entry</small>','mazine'),'',''); ?>
						</div>
					</div>
					
					<?php if ( has_post_thumbnail()) : ?>
						<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
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
							<b><?php _e('Receive new post updates','mazine'); ?>:</b>&nbsp;<a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow"><?php _e('Entries (RSS)','mazine'); ?></a>
							<br />
							<b><?php _e('Recieve follow up comments updates','mazine');?>:</b>&nbsp;<?php post_comments_feed_link(); ?>
						</div>
						<div class="post-meta-comments">
							<?php comments_popup_link(__('No comments','mazine'), __('One comment','mazine'), __('% comments','mazine'), 'comments-link', __('Comments are closed','mazine')); ?>
						</div>
					</div>
			</div><!-- #post-## -->
				
				<?php /* If a user fills out their bio info, it's included here */ ?>
				<div class="box" id="post-author"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
					<div class="smallest-title"><h3><?php _e('about the author','mazine'); ?></h3></div>
					<?php if(function_exists('get_avatar')) { echo '<figure>'; echo get_avatar( get_the_author_meta('email'), '107' ); echo '</figure>'; /* This avatar is the user's gravatar (http://gravatar.com) based on their administrative email address */  } ?>
					<h5><?php the_author_posts_link() ?></h5>
					<div id="authorDescription">
						<?php the_author_meta('description') ?> 
						<div id="author-link">
							<p><?php _e('View all posts by','mazine'); ?>: <?php the_author_posts_link() ?></p>
						</div><!--#author-link-->
					</div><!--#author-description -->
				</div></div></div></div></div></div></div></div><!--#post-author-->
	
			
			</div>
			<div class="newer-older">
				<div class="older">
						<?php previous_post_link('%link', __('<span><span>Previous post</span></span>','mazine')) ?>
				</div><!--.older-->
				<div class="newer">
						<?php next_post_link('%link', __('<span><span>Next Post</span></span>','mazine')) ?>
				</div><!--.older-->
			</div><!--.newer-older-->
	
			<?php comments_template( '', true ); ?>
		<?php } /* end if-gallery */ ?>

	<?php endwhile; /* end loop */ ?>
</div>
<div class="grid_3 side_col_right">
<?php get_sidebar(); ?>
</div>
		<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>