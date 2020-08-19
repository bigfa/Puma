<?php get_header();?>
    <main class="main-content layoutSingleColumn">
        <section class="section-body">
            <?php while ( have_posts() ) : the_post(); ?>
                <header class="section-header">
                    <h2 class="grap--h2"><?php the_title();?></h2>
                </header>
                <div class="grap">
                    <?php the_content();?>
                </div>
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; ?>
        </section>
    </main>
<?php get_footer();?>