<?php /* Template Name: 2 Cols Right with content container */ ?>
<?php get_header(); ?>
<?php echo "<br/>page-blank-2cols-right-chrome"; ?>
<section id="content">
	<div class="container_12">
		<div class="grid_9 cont_col">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="fance">
			<div class="title border">
						<h2 class="category-title"><?php the_title(); ?></h2>
					</div>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</div><!--#content-->
<div class="grid_3 side_col_right">
<?php get_sidebar(); ?>
</div>
		<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>
