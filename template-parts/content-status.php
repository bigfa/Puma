<article class="block block--inset block--list">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-status__link">
        <div class="post-status">
            <?php echo get_avatar(get_the_author_meta('user_email'), 48) ?><?php echo get_comments_number(); ?> <?php _e('replies.', 'Puma'); ?></span>
        </div>
    </a>
    <div class="block-snippet grap" itemprop="about">
        <?php the_content(''); ?>
    </div>
</article>