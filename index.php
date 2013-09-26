	<?php /* Template Name: Home Page */ ?>
<?php get_header(); ?>

<?php

echo "<br/>Index";

 if ( is_sidebar_active('Sliders') ) : ?>
	<section id="featured_products">
		<div class="container_12">
			<div class="grid_12">
				<?php dynamic_sidebar( 'Sliders' ); ?>
			</div>
		</div>
	</section>
<?php endif ?>
<div class="clear"></div>
<?php if ( is_sidebar_active('Categories') ) : ?>
<section id="categories">
		<div class="container_12" style="position:relative">
				<?php dynamic_sidebar( 'Categories' ); ?>
		</div>
</section>		
<?php endif; ?>

<?php if( is_sidebar_active('Home Supcontent') ) : ?>

<section id="supcontent">
	<div class="container_12">
	<div class="grid_12">
		<?php dynamic_sidebar( 'Home Supcontent' ); ?>	
	</div>
</div>
</section>
<?php endif; ?>

<section id="content">
	<div class="container_12">
		<?php if( is_sidebar_active('Home Sidebar') ) : ?>
			<div class="grid_4">
				<?php dynamic_sidebar( 'Home Sidebar' ); ?>	
			</div>
		<?php endif; ?>

		<div class="grid_<?php if ( is_sidebar_active('Home Sidebar') ) echo '8'; else echo '12'; ?> cont_col">	
		
			<?php if( is_sidebar_active('Home Content') ) : ?>
					<?php dynamic_sidebar( 'Home Content' ); ?>
			<?php else : ?>	
			<div id="posts">
					<ul id="listing">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<li>
								<article>
									<?php if ( has_post_thumbnail()) : ?>
										<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
									<?php endif; ?>
									<div class="heading">
										<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark">
											<?php $title = the_title('','', false);  if ($title != '') echo $title; else echo "Article"; ?></a>
										</h2>
										<div class="post-meta-written">
											<?php the_time('F j, Y'); ?> <?php _e('at','mazine'); ?> <?php the_time() ?>, <?php _e('by','mazine'); ?> <?php the_author_posts_link() ?>
										</div>
									</div>
									
									<div class="post-content">
										<?php the_content(__('Read more','mazine'));?>
									</div>
									<div class="post-meta">
										<div class="post-meta-taxonomy">
											<b><?php _e('Categories','mazine')?>: </b> <?php the_category(', ') ?><br/>
											<?php if (the_tags(__('<b>Tags:</b> ','mazine'), ', ', ' ')); ?>
										</div>
										<div class="post-meta-comments">
											<?php comments_popup_link(__('No Comments','mazine'), __('1 Comment','mazine'), __('% Comments','mazine')); ?>
										</div>
									</div><!--.postMeta-->
								</article>
							</li>
						<?php endwhile; else: ?>
							<li>
								<article>
									<div class="no-results">
										<p><strong><?php _e('There has been an error.','mazine');?></strong></p>
										<p><?php _e('We apologize for any inconvenience, please','mazine');?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php _e('return to the home page','mazine'); ?></a> <?php _e('or use the search form below.','mazine'); ?></p>
										<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
									</div><!--noResults-->
								</article>
							</li>
						<?php endif; ?>
				</ul>
			</div>
		<nav class="newer-older">
			<div class="older">
					<?php next_posts_link(__('<span><span>&laquo; Older Entries</span></span>','mazine')) ?>
			</div><!--.older-->
			<div class="newer">
					<?php previous_posts_link(__('<span><span>Newer Entries &raquo;</span></span>','mazine')) ?>
			</div><!--.older-->
		</nav><!--.oldernewer-->
<?php endif; ?>
	</div>
<?php if( is_sidebar_active('Home Specials') ) : ?>
	<div class="grid_12">
			<?php dynamic_sidebar( 'Home Specials' ); ?>	
	</div>
<?php endif; ?>
<?php if( is_sidebar_active('Home Subcontent') ) : ?>
	<div class="grid_12">
		<div class="box"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
			<?php dynamic_sidebar( 'Home Subcontent' ); ?>	
		</div></div></div></div></div></div></div></div>
	</div>
<?php endif; ?>


		<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>
