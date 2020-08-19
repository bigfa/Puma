<?php get_header();?>
    <main class="main-content layoutSingleColumn">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="section-header">
                    <h2 class="grap--h2"><?php the_title();?></h2>
                    <div class="block-postMetaWrap">
                        <time><?php echo get_the_date('Y/m/d');?></time><span class="sep"></span><?php the_category(',');?>
                        <?php if(function_exists('fancyratings')) fancyratings(get_the_ID());?>
                    </div>
                </header>
                <div class="grap">
                    <?php if(has_post_thumbnail()):?>
                        <p class="with-img"><?php the_post_thumbnail( 'full' ); ?></p>
                    <?php endif;?>
                    <?php the_content();?>
                </div>
                <?php wp_link_pages( array(
                    'before'      => '<div class="page-links u-textAlignCenter comment-navigation">',
                    'after'       => '</div>',
                    'link_before' => '<span class="page-link-item">',
                    'link_after'  => '</span>',
                    'pagelink'    => '%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );?>
                <div class="post--keywords" itemprop="keywords">
                    <?php echo puma_get_the_term_list( get_the_ID(), 'post_tag' );?>
                </div>
                <div class="postFooterAction u-clearfix">
                    <?php if(function_exists('wp_postlike')) wp_postlike();?>
                    <div class="share-icons" data-title="<?php the_title();?>" data-url="<?php the_permalink();?>">
                        <span class="icon-wechat" data-type="wechat" title="分享到微信"></span>
                        <span class="icon-twitter" data-type="twitter" title="分享到推特"></span>
                        <span class="icon-sina-weibo" data-type="weibo" title="分享到微博"></span>
                    </div>
                </div>
                <?php the_post_navigation( array(
                    'next_text' => '<span class="meta-nav">Next</span><span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav">Previous</span><span class="post-title">%title</span>',
                ) );?>
                <div class="postFooterinfo">
                    <?php echo get_avatar(get_the_author_meta('email'),64);?>
                    <h3 class="author-name"><?php the_author();?></h3>
                    <div class="author-description"><?php echo get_the_author_meta('description')?></div>
                    <div class="author-meta">
                        <?php if(get_the_author_meta('location')) : ?>
                            <span class="author-meta-item"><span class="icon-location"></span><?php echo get_the_author_meta('location');?></span>
                        <?php endif;?>
                        <?php if(get_the_author_meta('url')) : ?>
                            <span class="author-meta-item"><span class="icon-link"></span><a href="<?php echo get_the_author_meta('url');?>"><?php echo get_the_author_meta('url');?></a></span>
                        <?php endif;?>
                    </div>
                </div>
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; ?>
        </section>
    </main>
<?php get_footer();?>