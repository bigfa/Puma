<?php get_header(); ?>
<main class="main-content container">
    <header class="pTerm--header">
        <h1 class="pTerm--title"><?php printf(__('Search Results for: %s', 'Puma'), '<span>' . esc_html(get_search_query()) . '</span>'); ?></h1>
    </header>
    <section class="pBlock--list">
        <?php if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/content', get_post_format());
            endwhile;
        endif; ?>
    </section>
    <div class="posts-nav">
        <?php echo paginate_links(array(
            'prev_next'          => 0,
            'before_page_number' => '',
            'mid_size' => 2
        )); ?>
    </div>
</main>
<?php get_footer(); ?>