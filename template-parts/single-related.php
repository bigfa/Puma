<?php

/**
 * The template for displaying posts related to the current post
 *
 * @package Bigfa
 * @subpackage Puma
 * @since Puma 5.0.4
 */
?>
<h3 class="related--posts__title"><?php _e('Related Posts', 'Puma'); ?></h3>
<div class="post--single__related">
    <?php
    // get same format related posts
    $the_query = new WP_Query(array(
        'post_type' => 'post',
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 6,
        'category__in' => wp_get_post_categories(get_the_ID()),
        'ignore_sticky_posts' => 1,
        'tax_query' => get_post_format(get_the_ID()) ? array( // same post format
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-' . get_post_format(get_the_ID())),
                'operator' => 'IN'
            )
        ) : array()
    ));
    while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php if (get_post_format(get_the_ID()) == 'status') : ?>
            <div class="post--single__related__status">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                    <?php the_excerpt(); ?>
                    <div class="meta">
                        <time itemprop="datePublished" datetime="<?php echo get_the_date('c'); ?>" class="humane--time">
                            <?php echo get_the_date('Y-m-d'); ?>
                        </time>
                    </div>
                </a>
            </div>
        <?php else : ?>
            <div class="post--single__related__item">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                    <?php if (puma_is_has_image(get_the_ID())) : ?>
                        <div class="post--single__related__item__img">
                            <img src="<?php echo puma_get_background_image(get_the_ID(), 400, 200); ?>" class="cover" alt="<?php the_title(); ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="post--single__related__item__title">
                        <?php the_title(); ?>
                    </div>
                    <div class="meta">
                        <time datetime="<?php echo get_the_date('c'); ?>" class="humane--time">
                            <?php echo get_the_date('Y-m-d'); ?>
                        </time>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    <?php endwhile;
    wp_reset_postdata(); ?>
</div>