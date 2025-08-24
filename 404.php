<?php get_header(); ?>
<main class="main-content">
	<div class="pError--area">
		<div class="pError--code">404</div>
		<p class="pError--message"><?php echo __('Can not find any content', 'Puma'); ?></p>
		<div class="pRelated--list">
			<?php
			// get same format related posts
			$the_query = new WP_Query(array(
				'post_type' => 'post',
				'post__not_in' => array(get_the_ID()),
				'posts_per_page' => 6,
				'ignore_sticky_posts' => 1,
				'orderby' => 'rand'
			));
			while ($the_query->have_posts()) : $the_query->the_post(); ?>

				<?php get_template_part('template-parts/content', 'related'); ?>

			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>