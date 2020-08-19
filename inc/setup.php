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

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_style('puma', get_template_directory_uri() . '/build/css/app.css' , array(), PUMA_VERSION , 'screen');
    wp_enqueue_script( 'puma', get_template_directory_uri() . '/build/js/app.js' , array( 'jquery' ), PUMA_VERSION, true );
    wp_localize_script( 'puma', 'PUMA', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
    ) );
}

add_action( 'wp_enqueue_scripts', 'puma_load_static_files' );

function puma_post_nav_background() {
    if ( ! is_single() ) {
        return;
    }

    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );
    $css      = '.children {
      margin-left:50px;
    }';

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
add_action( 'wp_enqueue_scripts', 'puma_post_nav_background' );

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

if ( !function_exists('disable_emojis') ) :

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
endif;
add_action( 'init', 'disable_emojis' );

if ( !function_exists('disable_emojis_tinymce') ) :

    function disable_emojis_tinymce( $plugins ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }

endif;

/**
 * Hack default search form.
 *
 * @since Puma 3.0.1
 */


function puma_get_search_form(){
    $form = '<form method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
                    <input type="search" class="search-field" placeholder="输入内容按回车搜索" value="' . get_search_query() . '" name="s" />
            </form>';
    return $form;
}
add_filter('get_search_form','puma_get_search_form');

/**
 * Puma theme active analystic.
 *
 * @since Puma 3.0.1
 */

function puma_send_analystic(){
    $current_version = get_option('_puma_version');
    $api_url = "https://dev.fatesinger.com/_/api/";
    $theme_data = puma_get_theme();
    if ( $current_version == $theme_data['theme_version'] || $theme_data['site_url'] == 'localhost' ) return;
    $send_body = array_merge(array('action' => 'puma_send_analystic'), $theme_data);
    $send_for_check = array(
        'body' => $send_body,
        'sslverify' => false,
        'timeout' => 300,
    );
    $response = wp_remote_post($api_url, $send_for_check);
    if ( !is_wp_error($response ) ) update_option( '_puma_version' , $theme_data['theme_version'] );
}
add_action('after_switch_theme','puma_send_analystic');

function puma_get_theme(){
    global $wp_version;
    $theme_name = get_option('template');

    if(function_exists('wp_get_theme')){
        $theme_data = wp_get_theme($theme_name);
        $theme_version = $theme_data->Version;
    } else {
        $theme_data = get_theme_data( PURE_THEME_URL . '/style.css');
        $theme_version = $theme_data['Version'];
    }

    $site_url = home_url();

    return compact('wp_version', 'theme_name', 'theme_version', 'site_url' );

}