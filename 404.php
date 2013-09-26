<?php get_header(); ?>
<section id="content">
	<div class="container_12">
		<div class="grid_9 cont_col">
	<div id="error404" class="post">
		<div class="smaller-title">
			<h1 class="category-title lower-case"><?php echo __('Desculpe! Produto não encontrado.','mazine'); ?></h1>
		</div>
		<div class="postContent box"><div class="box_tr"><div class="box_bl"><div class="box_br"><div class="box_t"><div class="box_b"><div class="box_r"><div class="box_l">
			<p><?php echo __('O produto pesquisado por você não foi encontrado em nossos registros.','mazine'); ?></p>
			<p><?php echo __('Por favor verifique se o texto foi digitado corretamente ou utilize o formulário de pesquisa abaixo.','mazine'); ?></p>
			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
		</div></div></div></div></div></div></div></div>
		
		<!--.post-content-->
	</div><!--#error404 .post-->
</div><!--#content-->
<div class="grid_3 side_col_right">
<?php get_sidebar(); ?>
</div>
		<div class="clear"></div>
	</div>	
</section>
<?php get_footer(); ?>