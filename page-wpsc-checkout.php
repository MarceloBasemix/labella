<?php /* Template Name: Store Page Checkout */ ?>
<?php get_header(); ?>
<?php //echo "<br/>page-wpsc-checkout"; ?>
<section id="content">
	<div class="container_12">
		
		<?php if ( ! dynamic_sidebar( 'Alert' ) ) : ?>
			<!--Wigitized 'Alert' for the home page -->
		<?php endif ?>
		
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="grid_12 checkout">
		<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
		<!--#content-->
		
	</div>	
</section>
<?php get_footer(); ?>
