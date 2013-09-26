<?php /* Template Name: Institucional */ ?>
<?php get_header(); ?>
<?php //echo "<br/>Institucional"; ?>

<section id="content">
	<div class="container_12">
<?php echo NggRandom_topo(5); ?>			
				
		<div class="grid_9 cont_col">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div><!--#content-->
<div class="grid_3 side_col_right">
	<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
				
	<?php endif; ?>
</div>
		<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>
