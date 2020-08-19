<?php
if ( post_password_required() )
    return;
?>
<div id="comments" class="responsesWrapper">
    <meta content="UserComments:<?php echo number_format_i18n( get_comments_number() );?>" itemprop="interactionCount">
    <h3 class="comments-title">共有 <span class="commentCount"><?php echo number_format_i18n( get_comments_number() );?></span> 条评论</h3>
    <ol class="commentlist">
        <?php
        wp_list_comments( array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 48,
        ) );
        ?>
    </ol>
    <nav class="navigation comment-navigation" data-fuck="<?php the_ID();?>">
    <?php paginate_comments_links(array('prev_next'=>false)); ?>
    </nav>
    <?php if(comments_open()) : ?>
        <?php comment_form(array('comment_notes_after'=>''));?>
    <?php endif; ?>
</div>