<?php 

if ( ! function_exists( 'puma_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Puma 2.0.0
 */

function puma_setup() {
    register_nav_menu( 'puma', __( 'Primary Menu', 'puma' ) );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );
    add_theme_support( 'title-tag' );
    add_filter( 'pre_option_link_manager_enabled', '__return_true' );
    load_theme_textdomain( 'puma', get_template_directory() . '/languages' );
    add_theme_support( 'post-formats', array(
        'status',
        'image',
    ) );
}

endif;

add_action( 'after_setup_theme', 'puma_setup' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Puma 2.1.0
 */
function puma_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'puma_javascript_detection', 0 );


/**
 * Enqueues scripts and styles.
 *
 * @since Puma 2.0.0
 */

function puma_load_static_files(){
    $dir = get_template_directory_uri() . '/static/';
    wp_enqueue_style('puma', $dir . 'css/bundle.css' , array(), PUMA_VERSION , 'screen');
    wp_enqueue_script( 'puma', $dir . 'js/bundle.js' , array( 'jquery' ), PUMA_VERSION, true );
    wp_localize_script( 'puma', 'PUMA', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
    ) );
}

add_action( 'wp_enqueue_scripts', 'puma_load_static_files' );

/**
 * Replace the url of gravatar.
 *
 * @since Puma 2.0.0
 */

function puma_get_ssl_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar);
    return $avatar;
}
add_filter('get_avatar', 'puma_get_ssl_avatar');

/**
 * Add and remove the contact methods.
 *
 * @since Puma 2.0.0
 */

function puma_contactmethods( $contactmethods ) {
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['sina-weibo'] = 'Weibo';
    $contactmethods['location'] = '位置';
    $contactmethods['instagram'] = 'Instagram';
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    return $contactmethods;
}
add_filter('user_contactmethods','puma_contactmethods',10,1);

/**
 * Recover comment fields since WordPress 4.4
 *
 * @since Puma 2.0.4
 */


function recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields','recover_comment_fields');

/**
 * Disable emojis.
 *
 * @since Puma 2.0.0
 */

function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
}