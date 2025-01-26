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
        $output .= '<ul class="link-items">';
        foreach ($bookmarks as $bookmark) {
            $output .=  '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >' . get_avatar($bookmark->link_notes, 48) . '<span class="sitename"><strong>' . $bookmark->link_name . '</strong>' . $bookmark->link_description . '</span></a></li>';
        }
        $output .= '</ul>';
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
            $result .=  '<h3 class="link-title">' . $linkcat->name . '</h3>';
            if ($linkcat->description) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
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
