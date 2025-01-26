<?php
define('PUMA_VERSION', wp_get_theme()->get('Version'));
define('PUMA_SETTING_KEY', 'puma_setting');
define('PUMA_POST_LIKE_KEY', '_postlike');
define('PUMA_POST_VIEW_KEY', 'views');
define('PUMA_ARCHIVE_VIEW_KEY', 'views');
require get_template_directory() . '/inc/setting.php';

/**
 * Functional Package additions.
 */

require get_template_directory() . '/inc/pack.php';



/**
 * Theme update additions.
 */

require get_template_directory() . '/inc/update.php';

/**
 * Theme setting additions.
 */

require get_template_directory() . '/inc/base.php';
require get_template_directory() . '/inc/comment.php';

function puma_get_background_image($post_id, $width = null, $height = null)
{
    global $pumaSetting;
    if (has_post_thumbnail($post_id)) {
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $output = $timthumb_src[0];
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $output = get_post_meta($post_id, '_banner', true);
    } else {
        $content = get_post_field('post_content', $post_id);
        $defaltthubmnail = $pumaSetting->get_setting('default_thumbnail');
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    if ($height && $width) {
        if ($pumaSetting->get_setting('upyun')) {
            $output = $output . "!/both/{$width}x{$height}";
        }

        if ($pumaSetting->get_setting('oss')) {
            $output = $output . "?x-oss-process=image/crop,w_{$width},h_{$height}";
        }

        if ($pumaSetting->get_setting('qiniu')) {
            $output = $output . "?imageView2/1/w/{$width}/h/{$height}";
        }
    }

    return $output;
}


function puma_is_has_image($post_id)
{
    static $has_image;
    if (has_post_thumbnail($post_id)) {
        $has_image = true;
    } elseif (get_post_meta($post_id, '_banner', true)) {
        $has_image = true;
    } else {
        $content = get_post_field('post_content', $post_id);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if ($n > 0) {
            $has_image = true;
        } else {
            $has_image = false;
        }
    }

    return $has_image;
}


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Puma 2.1.0
 */
function puma_javascript_detection()
{
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'puma_javascript_detection', 0);


/**
 * Recover comment fields since WordPress 4.4
 *
 * @since Puma 2.0.4
 */


function recover_comment_fields($comment_fields)
{
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields, array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields', 'recover_comment_fields');


/**
 * Hack default search form.
 *
 * @since Puma 3.0.1
 */


function puma_get_search_form()
{
    $form = '<form method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
                    <input type="search" class="search-field" placeholder="输入内容按回车搜索" value="' . get_search_query() . '" name="s" />
            </form>';
    return $form;
}
add_filter('get_search_form', 'puma_get_search_form');
