<?php //echo "<br/>Categoria"; ?>
<?php get_header(); ?>


<section id="content">
	<div class="container_12">
		<div class="grid_9 cont_col" id="posts">
	
	<div class="smaller-title">
		<h1 class="category-title lower-case">
			<?php printf( __( 'Category Archives: %s' ,'mazine'), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
		</h1>
	</div>
	
	<?php $desc = category_description(); if ($desc != '') : ?>
	<div class="box">
		<?php echo $desc; /* displays the category's description from the Wordpress admin */ ?>
	</div>
	<?php endif; ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article>
			<?php if ( has_post_thumbnail()) : ?>
				<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
			<?php endif; ?>
			<div class="heading">
				<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php $title = the_title('','', false);  if ($title != '') echo $title; else  _e("Article",'mazine'); ?></a></h2>
				<div class="post-meta-written">
					<?php the_time('F j, Y'); ?> <?php echo __('at','mazine'); ?> <?php the_time() ?>, <?php echo __('by','mazine'); ?> <?php the_author_posts_link() ?>
				</div>
			</div>
			
			<div class="post-content">
				<?php the_excerpt(__(' Read more','mazine'));?>
			</div>
			<div class="post-meta">
				<div class="post-meta-taxonomy">
					<b><?php echo __('Categories','mazine'); ?>:</b> <?php the_category(', ') ?><br/>
					<?php if (the_tags(__('<b>Tags:</b> ', 'mazine'), ', ', ' ')); ?>
				</div>
				<div class="post-meta-comments">
					<?php comments_popup_link(__('No Comments','mazine'), __('1 Comment','mazine'), __('% Comments','mazine')); ?>
				</div>
			</div><!--.postMeta-->
		</article>
		
	<?php endwhile; else: ?>
		<div class="no-results box"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
			<p><strong><?php echo __('There has been an error.','mazine'); ?></strong></p>
			<p><?php echo __('We apologize for any inconvenience, please','mazine'); ?><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php echo __('return to the home page','mazine'); ?></a> <?php echo __('or use the search form below.','mazine'); ?></p>
			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
		</div></div></div></div></div></div></div></div><!--noResults-->
	<?php endif; ?>
		
	<nav class="newer-older">
			<div class="older">
					<?php next_posts_link(__('<span><span>&laquo; Older Entries</span></span>','mazine')) ?>
			</div><!--.older-->
			<div class="newer">
					<?php previous_posts_link(__('<span><span>Newer Entries &raquo;</span></span>','mazine')) ?>
			</div><!--.older-->
		</nav><!--.oldernewer-->
	
</div><!--#content-->
<div class="grid_3 side_col_right">
<?php get_sidebar(); ?>
</div>
		<div class="clear"></div>
	</div>	
</section>

<?php get_footer(); ?>