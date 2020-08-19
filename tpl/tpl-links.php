<?php
/*
Template Name: 友情链接模版
*/
?>
<?php get_header();?>
    <main class="main-content layoutSingleColumn">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="section-header">
                    <h2 class="grap--h2"><?php the_title();?></h2>
                </header>
            <?php endwhile; ?>
            <div class="page-wrapper">
            <?php echo get_link_items();?>
        </div>
        </section>
    </main>
<?php get_footer();?>