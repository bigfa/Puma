<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head();?>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/static/img/favicon.ico" type="image/vnd.microsoft.icon">
</head>
<body <?php body_class();?>>
<div class="surface-content">
    <header class="site-header u-textAlignCenter">
    <div class="header-inner">
        <h1 class="site-title">
            <a href="<?php echo home_url();?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
        </h1>
        <?php $description = get_bloginfo( 'description', 'display' );
        if ( $description ) : ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif;?>
        <div class="social-links">
          <?php echo header_social_link();?>
        </div>
        <div class="">
            <?php get_search_form();?>
        </div>
    </div>
    </header>
    <nav class="topNav u-textAlignCenter">
        <div class="layoutSingleColumn">
            <?php wp_nav_menu( array( 'theme_location' => 'puma','menu_class'=>'topNav-items','container'=>'ul','fallback_cb' => 'link_to_menu_editor')); ?>
        </div>
    </nav>