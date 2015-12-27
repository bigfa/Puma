<article class="block block--inset block--list">
    <h2 class="block-title post-featured" itemprop="headline">
        <a href="<?php the_permalink();?>"><?php the_title();?></a>
    </h2>
    <div class="block-postMetaWrap u-textAlignCenter">
        <time><?php echo get_the_date('Y/m/d');?></time>
    </div>
    <div class="block-snippet block-snippet--subtitle grap" itemprop="about">
        <?php if(has_post_thumbnail()):?>
            <p class="with-img"><?php the_post_thumbnail( 'full' ); ?></p>
            <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220,"...");?></p>
        <?php else : ?>
        <?php the_content('');?>    
        <?php endif;?>
        
    </div>
    <div class="block-footer">
        By <?php the_author();?> . In <?php the_category(',');?>.
        <div class="block-footer-inner">
            <?php if(function_exists('wpl_get_like_count')) echo wpl_get_like_count(get_the_ID());?> likes . <?php echo get_comments_number();?> replies.
        </div>
    </div>
</article>