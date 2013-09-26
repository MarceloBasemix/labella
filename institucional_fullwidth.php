<?php /* Template Name: institucional (fullwidth) */ ?>
<?php get_header(); ?>
<section id="content">
	<div class="container_12">
		
		
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="grid_12">
		<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
		<!--#content-->
		
	</div>	
</section>
<?php get_footer(); ?>
