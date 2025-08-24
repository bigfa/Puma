<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimal-ui,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/build/images/favicon.png" type="image/vnd.microsoft.icon">
</head>

<body <?php body_class(); ?>>
    <?php
    global $pumaSetting;
    if ($pumaSetting->get_setting('darkmode')) : ?>
        <script>
            window.DEFAULT_THEME = "auto";
            if (localStorage.getItem("theme") == null) {
                localStorage.setItem("theme", window.DEFAULT_THEME);
            }
            if (localStorage.getItem("theme") == "dark") {
                document.querySelector("body").classList.add("dark");
            }
            if (localStorage.getItem("theme") == "auto") {
                document.querySelector("body").classList.add("auto");
            }
        </script>
    <?php endif; ?>
    <div class="surface-content">
        <header class="pHeader">
            <div class="header-inner">
                <h1 class="site-title">
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                        <?php if (!get_option('header_logo_image')) {
                            bloginfo('name');
                        } else {
                            echo '<img src="' . get_option('header_logo_image') . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                        } ?>
                    </a>
                </h1>
                <?php $description = get_bloginfo('description', 'display');
                if ($description) : ?>
                    <p class="site-description"><?php echo $description; ?></p>
                <?php endif; ?>
                <?php echo get_search_form(); ?>
                <div class="pHeader--icons">
                    <?php get_template_part('template-parts/sns'); ?>
                </div>
            </div>
        </header>
        <nav class="pNav">
            <?php wp_nav_menu(array('theme_location' => 'puma', 'menu_class' => 'pNav--list', 'container' => 'ul', 'fallback_cb' => 'link_to_menu_editor')); ?>
        </nav>