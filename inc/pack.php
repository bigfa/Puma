<?php

/**
 * Display theme credit message,you should not edit this.
 *
 * @since Puma 2.1.0
 *
 * @return theme credit message.
 */

function puma_credit_print()
{
    $output = 'Just a <a href="https://fatesinger.com" target="_blank">bigfa</a> theme<span class="sep"></span>Blog since ' . puma_get_site_created_year();
    echo apply_filters('puma_footer', $output);
}

add_action('puma_credit', 'puma_credit_print');

/**
 * comment page navigation
 *
 * This only display if you have one more pages.
 *
 * @since Puma 2.1.0
 *
 * @return comment page navigation
 */


function puma_comment_nav()
{
    // Are there comments to navigate through?
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
?>
        <nav class="navigation comment-navigation u-textAlignCenter" role="navigation">
            <div class="nav-links">
                <?php
                if ($prev_link = get_previous_comments_link(__('Prev', 'Puma'))) :
                    printf('<div class="nav-previous">%s</div>', $prev_link);
                endif;

                if ($next_link = get_next_comments_link(__('Next', 'Puma'))) :
                    printf('<div class="nav-next">%s</div>', $next_link);
                endif;
                ?>
            </div>
        </nav>
<?php
    endif;
}

/**
 * Get all images of a post.
 *
 *
 * @since Puma 2.1.0
 *
 * @return images with html tags.
 */


function puma_get_images($contents)
{
    $matches = array();
    $content = '';
    $r = "#(<img.*?>)#";
    if (preg_match_all($r, $contents, $matches)) {
        foreach ($matches[0] as  $title) {
            $content .= '<div class="puma-image"><div class="puma-image-overlay"></div>' . $title . '</div>';
        }
    }
    return $content;
}


/**
 * Like to menu manager if a menu is not set up.
 *
 * @since Puma 2.1.0
 */

function link_to_menu_editor($args)
{
    if (!current_user_can('manage_options')) {
        return;
    }

    extract($args);

    $link = $link_before . '<a href="' . admin_url('nav-menus.php') . '">' . $before . __('Add a menu', 'Puma') . $after . '</a>' . $link_after;

    if (FALSE !== stripos($items_wrap, '<ul') or FALSE !== stripos($items_wrap, '<ol')) {
        $link = "<li>$link</li>";
    }

    $output = sprintf($items_wrap, $menu_id, $menu_class, $link);
    if (!empty($container)) {
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ($echo) {
        echo $output;
    }

    return $output;
}


/**
 * Get taxonomy with posts number
 *
 * @since Puma 2.1.0
 *
 * @param term id and term name
 * @return taxonomy list
 */

function puma_get_the_term_list($id, $taxonomy)
{
    $terms = get_the_terms($id, $taxonomy);
    $term_links = "";
    if (is_wp_error($terms))
        return $terms;

    if (empty($terms))
        return false;

    foreach ($terms as $term) {
        $link = get_term_link($term, $taxonomy);
        if (is_wp_error($link))
            return $link;
        $term_links .= '<a href="' . esc_url($link) . '" class="post--keyword" data-title="' . $term->name . '" data-type="' . $taxonomy . '" data-term-id="' . $term->term_id . '">' . $term->name . '<sup>[' . $term->count . ']</sup></a>';
    }

    return $term_links;
}

/**
 * Get link items by categroy id
 *
 * @since Puma 2.1.0
 *
 * @param term id
 * @return link item list
 */

function get_the_link_items($id = null)
{
    $bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output = '';
    if (!empty($bookmarks)) {
        $output .= '<div class="pLink--list">';
        foreach ($bookmarks as $bookmark) {
            $output .=  '<div class="pLink--item"><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >' . get_avatar($bookmark->link_notes, 32) . '<strong>' . $bookmark->link_name . '</strong><span class="sitename">' . $bookmark->link_description . '</span></a></div>';
        }
        $output .= '</div>';
    } else {
        $output =  __('No links', 'Puma');
    }
    return $output;
}

/**
 * Get link items
 *
 * @since Puma 2.1.0
 *
 * @return link iterms
 */

function get_link_items()
{
    $linkcats = get_terms('link_category');
    $result = '';
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .=  '<h3 class="pLink--title">' . $linkcat->name . '</h3>';
            if ($linkcat->description) $result .= '<div class="pLink--subtitle">' . $linkcat->description . '</div>';
            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}

/**
 * Get site created date
 *
 * @since Puma 2.1.4
 *
 * @return site created year
 */

function puma_get_site_created_year()
{
    $admin_created = get_userdata(1);
    return date('Y', strtotime($admin_created->user_registered));
}


function puma_get_post_views($post_id = 0)
{

    $views_number = (int)get_post_meta($post_id, PUMA_POST_VIEW_KEY, true);

    /**
     * Filters the returned views for a post.
     *
     * @since Puma 5.1.0
     */
    return apply_filters('puma_get_post_views', $views_number, $post_id);
}

/**
 * Get post views
 *
 * @since Puma 5.1.0
 *
 * @param post id
 * @return post views
 */

function puma_get_post_views_text($zero = false, $one = false, $more = false, $post = 0)
{
    $views = puma_get_post_views($post);
    if ($views == 0) {
        return $zero ? $zero : __('No views yet', 'Puma');
    } elseif ($views == 1) {
        return $one ? $one : __('1 view', 'Puma');
    } else {
        return $more ? str_replace('%d', $views, $more) : sprintf(__('%d views', 'Puma'), $views);
    }
}

function puma_get_post_image_count($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $content = apply_filters('the_content', $content);
    preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
    return count($strResult[1]);
}


function puma_get_post_read_time($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed is 200 wpm

    $image_count = puma_get_post_image_count($post_id);
    if ($image_count > 0) {
        $reading_time += ceil($image_count / 10); // Add extra time for images
    }

    return $reading_time;
}

function puma_get_post_read_time_text($post_id)
{
    $reading_time = puma_get_post_read_time($post_id);
    if ($reading_time <= 1) {
        return __('1 min read', 'Puma');
    } else {
        return sprintf(__('%d min read', 'Puma'), $reading_time);
    }
}
