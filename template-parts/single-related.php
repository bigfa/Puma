<?php

/**
 * The template for displaying posts related to the current post
 *
 * @package Bigfa
 * @subpackage Puma
 * @since Puma 5.0.4
 */
?>
<h3 class="pRelated--heroTitle"><?php _e('Related Posts', 'Puma'); ?></h3>
<div class="pRelated--list">
    <?php
    // get same format related posts
    $the_query = new WP_Query(array(
        'post_type' => 'post',
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 6,
        'category__in' => wp_get_post_categories(get_the_ID()),
        'ignore_sticky_posts' => 1,
    ));
    while ($the_query->have_posts()) : $the_query->the_post(); ?>

        <?php get_template_part('template-parts/content', 'related'); ?>

    <?php endwhile;
    wp_reset_postdata(); ?>
</div>