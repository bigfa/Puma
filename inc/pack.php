<?php
/**
 * Display theme credit message,you should not edit this.
 *
 * @since Puma 2.1.0
 *
 * @return theme credit message.
 */

function puma_credit_print(){
    echo 'just a <a href="https://fatesinger.com" title="bigfa" target="_blank">bigfa</a> theme. <span class="icon-heart"></span> Blog since ' . puma_get_site_created_year() . '.';
}

add_action('puma_credit','puma_credit_print');

/**
 * comment page navigation
 *
 * This only display if you have one more pages.
 *
 * @since Puma 2.1.0
 *
 * @return comment page navigation
 */


function puma_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        ?>
        <nav class="navigation comment-navigation u-textAlignCenter" role="navigation">
            <div class="nav-links">
                <?php
                if ( $prev_link = get_previous_comments_link(  '上一页' ) ) :
                    printf( '<div class="nav-previous">%s</div>', $prev_link );
                endif;

                if ( $next_link = get_next_comments_link( '下一页' ) ) :
                    printf( '<div class="nav-next">%s</div>', $next_link );
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


function puma_get_images($contents){
    $matches = array();
    $r = "#(<img.*?>)#";
    if (preg_match_all($r, $contents, $matches)) {
        foreach ($matches[0] as $num => $title) {
            $content .= '<div class="puma-image"><div class="puma-image-overlay"></div>' . $title . '</div>';
        }
    }
    return $content;
}


/**
 * Term like button
 *
 *
 * @since Puma 2.1.0
 *
 * @param text prefix
 * @return Term like button
 */


function wp_term_like( $prefix = null){
    global $wp_query;
    if(!is_tax() && !is_category() && !is_tag()) return ;
    $tax = $wp_query->get_queried_object();
    $id = $tax->term_id;
    $num = get_term_meta($id,'_term_like',true) ? get_term_meta($id,'_term_like',true) : 0;
    $active = isset($_COOKIE['_term_like_'.$id]) ? ' is-active' : '';
    $output = '<button class="button termlike' . $active . '" data-action="termlike" data-action-id="' . $id . '">' . $prefix . '<span class="count">' . $num . '</span></button>';
    return $output;
}


/**
 * Like to menu manager if a menu is not set up.
 *
 * @since Puma 2.1.0
 */

function link_to_menu_editor( $args )
{
    if ( ! current_user_can( 'manage_options' ) ){
        return;
    }

    extract( $args );

    $link = $link_before . '<a href="' .admin_url( 'nav-menus.php' ) . '">' . $before . 'Add a menu' . $after . '</a>' . $link_after;

    if ( FALSE !== stripos( $items_wrap, '<ul' )or FALSE !== stripos( $items_wrap, '<ol' )){
        $link = "<li>$link</li>";
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
    if ( ! empty ( $container ) ){
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ( $echo ){
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

function puma_get_the_term_list( $id, $taxonomy ) {
    $terms = get_the_terms( $id, $taxonomy );
    $term_links = "";
    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    foreach ( $terms as $term ) {
        $link = get_term_link( $term, $taxonomy );
        if ( is_wp_error( $link ) )
            return $link;
        $term_links .= '<a href="' . esc_url( $link ) . '" class="post--keyword" data-title="' . $term->name . '" data-type="'. $taxonomy .'" data-term-id="' . $term->term_id . '">' . $term->name . '<sup>['. $term->count .']</sup></a>';
    }

    return $term_links;
}

/**
 * Social icons in header
 *
 * @since Puma 2.1.0
 *
 * @return social icons
 */

function header_social_link(){
    $socials = array('twitter','sina-weibo','instagram');
    $output = '';
    foreach ($socials as $key => $social) {
        if( get_user_meta(1,$social,true) != '' ) { $output .= '<span class="social-link"><a href="' . get_user_meta(1,$social,true) .'" target="_blank"><span class="icon-' . $social . '"></span></a></span>';
        }
    }
    $output .= '<span class="social-link"><a href="' . get_bloginfo('rss2_url'). '" target="_blank"><span class="icon-rss"></span></a></span>';
    return $output;
}

/**
 * Get link items by categroy id
 *
 * @since Puma 2.1.0
 *
 * @param term id
 * @return link item list
 */

function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=date&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {
        $output .= '<ul class="link-items">';
        foreach ($bookmarks as $bookmark) {
            $output .=  '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" >'. get_avatar($bookmark->link_notes,64) . '<span class="sitename">'. $bookmark->link_name .'<br>' . $bookmark->link_description . '</span></a></li>';
        }
        $output .= '</ul>';
    } else {
        $output = '暂无链接。';
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

function get_link_items(){
    $linkcats = get_terms( 'link_category' );
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){
            $result .=  '<h3 class="link-title">'.$linkcat->name.'</h3>';
            if( $linkcat->description ) $result .= '<div class="link-description">' . $linkcat->description . '</div>';
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

function puma_get_site_created_year(){
    $admin_created = get_userdata(1);
    return date('Y',strtotime($admin_created->user_registered));
}

/**
 * Theme comment reply mail 
 * 
 * @since Puma 2.1.5
 *
 */

function puma_comment_relay_mail() {
    $content = '<table class="body-wrap" style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;line-height:150%;border-spacing:0;background-color:#f7f7f7;width:100%">
    <tbody>
    <tr style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif">
<td style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif"></td>
<td class="container" style="padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;display:block !important;margin:0 auto !important;clear:both !important;max-width:610px !important">
<div class="content" style="font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;padding:15px;max-width:600px;margin:0 auto;display:block;padding-left:5px;padding-right:5px;padding-bottom:5px;padding-top:0px">
<table class="head-wrap" style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;line-height:150%;border-spacing:0;margin-bottom:10px;margin-top:10px;width:100%">
<tbody>
<tr style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif">
<td style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif"></td>
<td class="container header" style="padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;display:block !important;margin:0 auto !important;clear:both !important;max-width:610px !important">
<div class="content" style="font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;padding:15px;max-width:600px;margin:0 auto;display:block;padding-left:5px;padding-right:5px;padding-bottom:5px;padding-top:0px">
</td>
<td style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif"></td>
</tr>
</tbody>
</table>
<div class="section " style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif">
<br style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif">
<br style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif">
</div>
</td>
<td style="margin:0;padding:0;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif"></td>
</tr>
    </tbody>
    </table>
    ';
}