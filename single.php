<?php get_header();?>
    <main class="main-content container">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="u-textAlignCenter">
                    <h2 class="block-title" itemprop="headline">
                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                    </h2>
                    <div class="block-postMetaWrap">
                        <time><?php echo get_the_date('Y/m/d');?></time>
                    </div>
                </header>
                <div class="grap">
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
                <?php the_post_navigation( array(
                    'next_text' => '<span class="meta-nav">Next</span><span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav">Previous</span><span class="post-title">%title</span>',
                ) );?>
                <div class="postFooterinfo u-textAlignCenter">
                    <?php echo get_avatar(get_the_author_meta('email'),64);?>
                    <h3 class="author-name"><?php the_author();?></h3>
                    <div class="author-description"><?php echo get_the_author_meta('description')?></div>
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