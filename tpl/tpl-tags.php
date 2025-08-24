<?php
/*
 Template Name: Tags Template
 Template Post Type: page
*/
get_header(); ?>
<main class="main-content container">
    <section class="pArticle">
        <?php while (have_posts()) : the_post(); ?>
            <header class="pArticle--header">
                <h2 class="pArticle--title"><?php the_title(); ?></h2>
            </header>
            <div class="archive--tagList">
                <?php $tags = get_tags();
                foreach ($tags as $tag) {
                    $link = get_tag_link($tag->term_id)
                ?>
                    <a class="archive--tagItem" title="<?php echo $tag->name; ?>" aria-label="<?php echo $tag->name; ?>" href="<?php echo $link; ?>">
                        <?php echo $tag->name; ?><span>(<?php echo $tag->count; ?>)</span>
                    </a>
                <?php } ?>
            </div>
        <?php endwhile; ?>
    </section>
</main>
<?php get_footer(); ?>