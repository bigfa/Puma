<?php
/*
Template Name: Marker Pro
Template Post Type: page
*/
?>
<?php get_header(); ?>
<main class="main-content container">
    <section class="section-body">
        <?php while (have_posts()) : the_post(); ?>
            <header class="section-header u-textAlignCenter">
                <h2 class="block-title"><?php the_title(); ?></h2>
            </header>
        <?php endwhile; ?>
        <?php if (function_exists('marker_pro_init')) marker_pro_init(); ?>
    </section>
</main>
<?php get_footer(); ?>