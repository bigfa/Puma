<?php get_header(); ?>
<main class="main-content container">
    <section class="pArticle" itemscope="itemscope" itemtype="http://schema.org/Article">
        <?php while (have_posts()) : the_post(); ?>
            <header class="pArticle--header">
                <h2 class="pArticle--title" itemprop="headline"><?php the_title(); ?></h2>
            </header>
            <div class="pGraph pArticle--content" itemprop="articleBody">
                <?php the_content(); ?>
            </div>
            <?php wp_link_pages(array(
                'before'      => '<div class="page-links">',
                'after'       => '</div>',
                'pagelink'    => '%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            )); ?>
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        <?php endwhile; ?>
    </section>
</main>
<?php get_footer(); ?>