<?php get_header();?>
    <main class="main-content">
        <header class="archive-header u-textAlignCenter">
            <?php
            the_archive_title( '<h1 class="archive-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
            ?>
        </header>
        <section class="blockGroup">
            <?php if (have_posts()):
                while (have_posts()): the_post();
                    get_template_part('template-parts/content', get_post_format());
                endwhile;
            endif;?>
        </section>
        <div class="u-textAlignCenter postsFooterNav">
            <div class="posts-nav">
                <?php echo paginate_links( array(
                    'prev_next'          => 0,
                    'before_page_number' => '',
                    'mid_size' => 2
                ) );?>
            </div>
        </div>
    </main>
<?php get_footer();?>