<?php
/*
Template Name: Blogroll
Template Post Type: page
*/
?>
<?php get_header(); ?>
<main class="main-content">
    <section class="pArticle">
        <?php while (have_posts()) : the_post(); ?>
            <header class="pArticle--header">
                <h2 class="pArticle--title"><?php the_title(); ?></h2>
            </header>
        <?php endwhile; ?>
        <?php echo get_link_items(); ?>
        <div class="pGraph pArticle--content" itemprop="articleBody">
            <?php the_content(); ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>