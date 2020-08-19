<article class="block block--inset block--list<?php if(is_sticky()) echo ' sticky';?>">
    <h2 class="block-title post-featured" itemprop="headline">
        <a href="<?php the_permalink();?>"><?php the_title();?></a>
    </h2>
    <div class="block-postMetaWrap">
        <time><?php echo get_the_date('Y/m/d');?></time><span class="sep"></span><?php the_category(',');?>
    </div>
    <div class="block-snippet block-snippet--subtitle grap" itemprop="about">
        <?php if(has_post_thumbnail()):?>
            <p class="with-img"><?php the_post_thumbnail( 'full' ); ?></p>
            <?php if( post_password_required()) : ?>
                <?php the_content('Read More.');?>
            <?php else : ?>
                <?php if( has_excerpt() ) : ?>
                    <p><?php the_excerpt();?></p>
                <?php else: ?>
                    <p><?php echo mb_strimwidth(strip_shortcodes(strip_tags(apply_filters('the_content', $post->post_content))), 0, 220,"...");?></p>
                <?php endif;?>
                <p><a class="more-link" href="<?php the_permalink();?>" rel="nofollow">Read More.</a></p>
            <?php endif;?>
        <?php else : ?>
            <?php the_content('Read More.');?>
        <?php endif;?>
    </div>
</article>