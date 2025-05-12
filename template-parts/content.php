<article class="block--list<?php if (is_sticky()) echo ' sticky'; ?>">
    <header class="u-textAlignCenter">
        <h2 class="block-title post-featured" itemprop="headline">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="block-postMetaWrap">
            <time><?php echo get_the_date('Y/m/d'); ?></time>
        </div>
    </header>
    <div class="block-snippet grap" itemprop="about">
        <?php
        global $pumaSetting;
        if ((has_post_thumbnail() || !$pumaSetting->get_setting('hide_home_cover')) && puma_is_has_image(get_the_ID())) : ?>
            <p class="with-img">
                <img src="<?php echo puma_get_background_image(get_the_ID()); ?>" alt="<?php the_title(); ?>" class="home--cover" />
            </p>
            <?php if (post_password_required()) : ?>
                <?php the_content(__('Read More.', 'Puma')); ?>
            <?php else : ?>
                <?php if (has_excerpt()) : ?>
                    <p><?php the_excerpt(); ?></p>
                <?php else : ?>
                    <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220, "..."); ?></p>
                <?php endif; ?>
                <p><a class="more-link" href="<?php the_permalink(); ?>" rel="nofollow" title="<?php the_title(); ?>"><?php echo __('Read More.', 'Puma'); ?></a></p>
            <?php endif; ?>
        <?php else : ?>
            <?php the_content(__('Read More.', 'Puma')); ?>
        <?php endif; ?>
    </div>
    <div class="block-footer">
        By <?php the_author(); ?> . In <?php the_category(','); ?>.
        <div class="block-footer-inner">
            <?php echo get_comments_number(); ?> <?php echo __('replies.', 'Puma'); ?>
            <span class="sep"></span>
            <?php echo puma_get_post_views_text(false, false, false, get_the_ID()); ?>
        </div>
    </div>
</article>