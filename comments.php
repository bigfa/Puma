<?php
if (post_password_required())
    return;
?>
<div id="comments" class="pComment--area">
    <meta content="UserComments:<?php echo number_format_i18n(get_comments_number()); ?>" itemprop="interactionCount">
    <?php
    // Build a localized comments title with proper plural handling.
    $puma_comments_title = get_comments_number_text(
        __('0 comments', 'puma'),
        __('1 comment', 'puma'),
        __('% comments', 'puma')
    );
    ?>
    <h3 class="pComment--heroTitle"><?php echo esc_html($puma_comments_title); ?></h3>
    <ol class="pComment--list">
        <?php
        wp_list_comments(array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 48,
            'callback'    => 'puma_comment',
        ));
        ?>
    </ol>
    <nav class="comment-navigation" data-fuck="<?php the_ID(); ?>">
        <?php paginate_comments_links(array('prev_next' => false)); ?>
    </nav>
    <?php if (comments_open()) : ?>
        <?php comment_form(array('comment_notes_after' => '')); ?>
    <?php endif; ?>
</div>