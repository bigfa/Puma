<div class="pRelated--item">
    <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>" title="<?php the_title(); ?>">
        <?php if (puma_is_has_image(get_the_ID())) : ?>
            <div class="pRelated--image">
                <img src="<?php echo puma_get_background_image(get_the_ID(), 400, 200); ?>" class="cover" alt="<?php the_title(); ?>" />
            </div>
        <?php endif; ?>
        <div class="pRelated--title">
            <?php the_title(); ?>
        </div>
        <div class="pRelated--meta">
            <time datetime="<?php echo get_the_date('c'); ?>" class="humane--time">
                <?php echo get_the_date('Y-m-d'); ?>
            </time>
            <span class="sep"></span>
            <?php echo puma_get_post_read_time_text(get_the_ID()); ?>
        </div>
    </a>
</div>