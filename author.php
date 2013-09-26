<?php get_header(); ?>
<section id="content">
	<div class="container_12">
		<div class="grid_12 cont_col">
	<?php
		if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
	    else :
			$curauth = get_userdata(intval($author));
		endif;
	?>
	<div class="title">
		<h1 class="category-title"><?php _e('About','mazine')?>: <?php echo $curauth->display_name; ?></h1>
	</div>
	<div class="author box"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
		
			<?php if(function_exists('get_avatar')) { echo '<figure>'; echo get_avatar( $curauth->user_email, $size = '180' ); echo '</figure>'; } /* Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars */ ?>
		
		<?php if($curauth->description !="") { /* Displays the author's description from their Wordpress profile */ ?>
			<p><?php echo $curauth->description; ?></a></p>
		<?php } ?>
	</div></div></div></div></div></div></div></div><!--.author-->

	<div class="title">
		<h2 class="category-title"><?php echo __('Recent Posts by','mazine'); ?> <?php echo $curauth->display_name; ?></h2>
	</div>
	<div id="posts">
		
		
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); /* Displays the most recent posts by that author. Note that this does not display custom content types */ ?>
			<?php static $count = 0;
				if ($count == "5") // Number of posts to display
	            	{ break; }
				else { ?>
					<article>
			<?php if ( has_post_thumbnail()) : ?>
				<?php echo '<figure class="thumb">'; the_post_thumbnail(); echo '</figure>'; /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ ?>
			<?php endif; ?>
			<div class="heading">
				<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="post-meta-written">
					<?php the_time('F j, Y'); ?> <?php echo __('at','mazine'); ?> <?php the_time() ?>, <?php echo __('by','mazine'); ?> <?php the_author_posts_link() ?>
				</div>
			</div>
			
			<div class="post-content">
				<?php the_excerpt(__('Read more','mazine'));?>
			</div>
			<div class="post-meta">
				<div class="post-meta-taxonomy">
					<b><?php echo __('Categories','mazine'); ?>:</b> <?php the_category(', ') ?><br/>
					<?php if (the_tags(__('<b>Tags:</b> ','mazine'), ', ', ' ')); ?>
				</div>
				<div class="post-meta-comments">
					<?php comments_popup_link(__('No Comments','mazine'), __('1 Comment','mazine'), __('% Comments','mazine')); ?>
				</div>
			</div><!--.postMeta-->
		</article>
			<?php $count++; } ?>
		<?php endwhile; else: ?>
				<div class="fance">
					<?php printf(__('No posts by %s yet.','mazine'), $curauth->display_name)  ?>
				</div>
		<?php endif; ?>
	</div><!--#recentPosts-->

	<div id="recent-author-comments" class="box"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
		<h3><?php echo __('Recent Comments by','mazine'); ?> <?php echo $curauth->display_name; ?></h3>
			<?php
				$number=5; // number of recent comments to display
				$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number");
			?>
			<ul class="list">
				<?php
					if ( $comments ) : foreach ( (array) $comments as $comment) :
					echo  '<li class="recentcomments">' . sprintf(__('%1$s on %2$s','mazine'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
				endforeach; else: ?>
                	<p>
                		<?php printf(__('No posts by %s yet.','mazine'), $curauth->display_name);  ?>
                	</p>
				<?php endif; ?>
            </ul>
	</div></div></div></div></div></div></div></div><!--#recentAuthorComments-->
</div><!--#content-->
<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>
