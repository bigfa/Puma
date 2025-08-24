<?php
/*
Template Name: Categories
Template Post Type: page
*/
get_header(); ?>

<main class="main-content container">
    <section class="pArticle">
        <?php while (have_posts()) : the_post(); ?>
            <header class="pArticle--header">
                <h2 class="pArticle--title"><?php the_title(); ?></h2>
            </header>
            <div class="pCategory--list">
                <?php $categories = get_terms([
                    'taxonomy' => 'category',
                    'hide_empty' => false,
                    'order' => 'DESC',
                ]);
                foreach ($categories as $category) {
                    $link = get_term_link($category, 'category')
                ?>
                    <a class="pCategory--item" title="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" href="<?php echo $link; ?>" data-count="<?php echo $category->count; ?>">
                        <?php if (get_term_meta($category->term_id, '_thumb', true)) : ?>
                            <img class="pCategory--image" alt="<?php echo $category->name; ?>" aria-label="<?php echo $category->name; ?>" src="<?php echo get_term_meta($category->term_id, '_thumb', true); ?>">
                        <?php endif ?>
                        <div class="pCategory--meta">
                            <div class="pCategory--title"><?php echo $category->name; ?></div>
                            <div class="pCategory--description"><?php echo $category->description; ?></div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php endwhile; ?>
    </section>
</main>

<?php get_footer(); ?>