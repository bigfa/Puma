<article class="block block--inset block--list">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-status__link">
        <div class="post-status">
            <?php echo get_avatar(get_the_author_meta('user_email'), 32) ?>
        </div>
    </a>
    <div class="block-snippet grap" itemprop="about">
        <?php the_content(''); ?>
    </div>
    <div class="block-footer">
        By <?php the_author(); ?> . In <?php the_category(','); ?>.
        <div class="block-footer-inner">
            <?php echo get_comments_number(); ?> <?php echo __('replies.', 'Puma'); ?>
            <span class="sep"></span>
            <?php echo (int)get_post_meta(get_the_ID(), PUMA_POST_VIEW_KEY, true); ?> <?php echo __('views', 'Puma'); ?>
        </div>
    </div>
</article>