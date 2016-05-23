<?php
define('PUMA_VERSION','2.1.9');

/**
 * Theme setup additions.
 */

require get_template_directory() . '/inc/setup.php';

/**
 * Puma only works in WordPress 4.4 or later.
 */

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
}

/**
 * AJAX callback additions.
 */

require get_template_directory() . '/inc/callback.php';

/**
 * Functional Package additions.
 */

require get_template_directory() . '/inc/pack.php';

/**
 * Functional customize additions.
 */

require get_template_directory() . '/inc/customize.php';

/**
 * Theme update additions.
 */

require get_template_directory() . '/inc/update.php';

/**
 * Theme required plugins
 */

require 'inc/tgm-plugin-activation/plugins.php';

function twentyfifteen_post_nav_background() {
  if ( ! is_single() ) {
    return;
  }

  $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );
  $css      = '';

  if ( is_attachment() && 'attachment' == $previous->post_type ) {
    return;
  }

  if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
    $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
    $css .= '
      .post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . ');}
      .post-navigation .nav-previous .post-title { color: #fff; }
      .post-navigation .nav-previous .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-previous:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
  }

  if ( $next && has_post_thumbnail( $next->ID ) ) {
    $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
    $css .= '
      .post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . ');}
      .post-navigation .nav-next .post-title { color: #fff; }
      .post-navigation .nav-next .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-next:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
  }

  //echo $css;

  wp_add_inline_style( 'puma', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );