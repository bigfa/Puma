<?php get_header();?>
    <main class="main-content">
        <header class="archive-header u-textAlignCenter">
           <h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'puma' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
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