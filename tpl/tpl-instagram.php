<?php
/*
Template Name: Instagram 模板
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
            <?php if( function_exists('wp_fancy_instagram') ) {
                wp_fancy_instagram();
            } else {
                echo '插件<code>wp fancy instagram</code>未安装，请后台搜索安装。';
            }
            ?>
        </section>
    </main>
<?php get_footer();?>