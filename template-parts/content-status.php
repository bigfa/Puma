<article class="block block--inset block--list">
    <a href="<?php the_permalink(); ?>">
        <div class="post-status u-clearfix">
            <?php echo get_avatar(get_the_author_meta('user_email'), 48) ?><?php the_content(''); ?>
        </div>
    </a>
    <div class="status-footer">
        <span><?php echo get_comments_number(); ?> replies.</span>
    </div>
</article>