<?php
/*
 Template Name: Tags Template
 Template Post Type: page
*/
get_header(); ?>
<main class="main-content container">
    <section class="section-body">
        <?php while (have_posts()) : the_post(); ?>
            <article class="post--single__douban">
                <header class="u-textAlignCenter">
                    <h2 class="post--single__title"><?php the_title(); ?></h2>
                </header>
                <div class="postTag--list">
                    <?php $tags = get_tags();
                    foreach ($tags as $tag) {
                        $link = get_tag_link($tag->term_id)
                    ?>
                        <a class="postTag--item" title="<?php echo $tag->name; ?>" aria-label="<?php echo $tag->name; ?>" href="<?php echo $link; ?>">
                            <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span>
                        </a>
                    <?php } ?>
                </div>
            </article>
        <?php endwhile; ?>
    </section>
</main>
<?php get_footer(); ?>