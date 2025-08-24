<?php
/*
Template Name: Post Archive
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
        <div class="pArchive">
            <?php $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'ignore_sticky_posts' => 1
            );
            $the_query = new WP_Query($args);
            $posts_rebuild = array();
            while ($the_query->have_posts()) : $the_query->the_post();
                $post_year = get_the_time('Y');
                $post_mon = get_the_time('m');
                $posts_rebuild[$post_year][$post_mon][] = '<div class="pArchive--item"><a href="' . get_permalink() . '" class="pArchive--title">' . get_the_title() . '</a> <span class="pArchive--meta">(' . get_comments_number('0', '1', '%') . ')</span></div>';
            endwhile;
            wp_reset_postdata();
            $output = '';
            foreach ($posts_rebuild as $key => $value) {
                $output .= '<div data-year="' . $key . '" class="pArchive--yearly">';
                $year = $key;
                foreach ($value as $key_m => $value_m) {
                    $output .= '<h3 class="pArchive--monthly">' . $year . ' - ' . $key_m . '</h3><div class="pArchive--list">';
                    foreach ($value_m as $key => $value_d) {
                        $output .=  $value_d;
                    }
                    $output .= '</div>';
                }
                $output .= '</div>';
            }
            echo $output;
            ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>