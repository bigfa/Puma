<?php get_header(); ?>
<main class="main-content container">
    <header class="pTerm--header">
        <?php
        the_archive_title('<h1 class="pTerm--title">', '</h1>');
        the_archive_description('<div class="pTerm--description">', '</div>');
        ?>
    </header>
    <section class="pBlock--list">
        <?php if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile;
        endif; ?>
    </section>
    <div class="u-textAlignCenter postsFooterNav">
        <div class="posts-nav">
            <?php echo paginate_links(array(
                'prev_next'          => 0,
                'before_page_number' => '',
                'mid_size' => 2
            )); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>