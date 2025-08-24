<article class="pStatus--item">
    <div class="pStatus--header">
        <?php echo get_avatar(get_the_author_meta('user_email'), 32) ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php echo human_time_diff(get_the_time('U'), current_time('U')) . __(' ago', 'Puma'); ?>
        </a>
    </div>
    <div class="pBlock--snippet pGraph" itemprop="about">
        <p>
            <?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220, "..."); ?>
        </p>
        <p>
            <a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo __('Read More.', 'Puma'); ?>
            </a>
        </p>
    </div>
    <div class="pBlock--footer">
        <?php the_category(','); ?>
        <span class="sep"></span>
        <?php echo puma_get_post_views_text(false, false, false, get_the_ID()); ?>
        <span class="sep"></span>
        <?php echo puma_get_post_read_time_text(get_the_ID()); ?>
    </div>
</article>