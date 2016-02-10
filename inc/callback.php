<?php

/**
 * Ajax comment submit function.
 *
 * @since Puma 2.0.0
 *
 * @return string new comment for the theme.
 */

function puma_ajax_comment_callback(){
    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $data = $comment->get_error_data();
        if ( ! empty( $data ) ) {
            fa_ajax_comment_err($comment->get_error_message());
        } else {
            exit;
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?>>
        <article class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, $size = '48')?>
                    <b class="fn">
                        <?php echo get_comment_author_link();?>
                    </b>
                </div>
                <div class="comment-metadata">
                    <?php echo get_comment_date(); ?>
                </div>
            </footer>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
        </article>
    </li>
    <?php die();
}

add_action('wp_ajax_nopriv_ajax_comment', 'puma_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'puma_ajax_comment_callback');

/**
 * Ajax comment submit function.
 *
 * @since Puma 2.0.0
 *
 * @param error message
 *
 * @return echo error message with 500 response.
 */

function fa_ajax_comment_err($a) {
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-Type: text/plain;charset=UTF-8');
    echo $a;
    exit;
}


/**
 * Term like callback function.
 *
 * @since Puma 2.0.4
 *
 * @return status and like num with json format
 */

function wp_term_like_callback(){
    $id = $_POST['actionId'];
    $num = get_term_meta($id,'_term_like',true) ? get_term_meta($id,'_term_like',true) : 0;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('_term_like_'.$id,$id,$expire,'/',$domain,false);
    update_term_meta($id,'_term_like',$num + 1);
    echo json_encode(array(
        'status'=>200,
        'data'=> $num + 1,
    ));
    die;
}

add_action('wp_ajax_nopriv_termlike','wp_term_like_callback');
add_action('wp_ajax_termlike','wp_term_like_callback');