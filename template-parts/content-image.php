<article class="block block--inset block--list">
    <h2 class="block-title post-featured" itemprop="headline">
        <a href="<?php the_permalink();?>"><?php the_title();?></a>
    </h2>
    <div class="block-postMetaWrap u-textAlignCenter">
        <time><?php echo get_the_date('Y/m/d');?></time>
    </div>
    <div class="puma-images"><?php echo puma_get_images($post->post_content);?></div>
    <div class="block-footer">
        By <?php the_author();?> . In <?php the_category(',');?>.
        <div class="block-footer-inner">
            <?php if(function_exists('wpl_get_like_count')) echo wpl_get_like_count(get_the_ID());?> <?php echo __( 'likes', 'Puma' );?> . <?php echo get_comments_number();?> <?php echo __( 'replies', 'Puma' );?>.
        </div>
    </div>
</article>