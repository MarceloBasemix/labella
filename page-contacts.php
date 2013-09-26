<?php /* Template Name: Contacts Page */ ?>
<?php get_header(); ?>
<section id="content">
	<div class="container_12">
		<div class="grid_8 cont_col">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="fance">
			<div class="title border">
						<h2 class="category-title"><?php the_title(); ?></h2>
					</div>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</div><!--#content-->
<div class="grid_4 side_col_right">
	<?php if ( ! dynamic_sidebar( 'Contacts Sidebar' )) : ?>
	
		
		
	<?php endif; ?>
		<div class="clear"></div>
</div>
	</div>	
</section>
<?php get_footer(); ?>
