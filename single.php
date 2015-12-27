<?php get_header();?>
    <main class="main-content">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="section-header u-textAlignCenter">
                    <h2 class="grap--h2"><?php the_title();?></h2>
                    <div class="block-postMetaWrap">
                        <time><?php echo get_the_date('Y/m/d');?></time>
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
                <div class="postFooterAction">
                    <?php if(function_exists('wp_postlike')) wp_postlike();?>
                </div>
                <div class="postFooterinfo u-textAlignCenter">
                    <?php echo get_avatar(get_the_author_meta('email'),64);?>
                    <h3 class="author-name"><?php the_author();?></h3>
                    <div class="author-description"><?php echo get_the_author_meta('description')?></div>
                    <div class="author-meta">
                        <?php if(get_the_author_meta('location')) : ?>
                            <span class="author-meta-item"><svg class="icon icon-instagram" height="14" width="14" viewBox="0 0 14 14"><use xlink:href="<?php echo get_template_directory_uri() . '/static/img/svgdefs.svg';?>#icon-location"></use></svg><?php echo get_the_author_meta('location');?></span>
                        <?php endif;?>
                        <?php if(get_the_author_meta('url')) : ?>
                            <span class="author-meta-item"><svg class="icon icon-twitter" height="14" width="14" viewBox="0 0 14 14"><use xlink:href="<?php echo get_template_directory_uri() . '/static/img/svgdefs.svg';?>#icon-link"></use></svg><a href="<?php echo get_the_author_meta('url');?>"><?php echo get_the_author_meta('url');?></a></span>
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