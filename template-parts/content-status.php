<article class="block block--inset block--list">
    <a href="<?php the_permalink();?>">
        <div class="post-status u-clearfix">
            <?php echo get_avatar(get_the_author_meta('user_email' ),64)?><?php the_content('');?>
        </div>
    </a>
    <div class="status-footer">
        <span><?php if(function_exists('wpl_get_like_count')) echo wpl_get_like_count(get_the_ID());?> likes . <?php echo get_comments_number();?> replies.</span>
    </div>
</article>