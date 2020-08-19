<?php
define('UIE_VERSION','1.0.1');

/**
 * Theme setup additions.
 */

require get_template_directory() . '/inc/setup.php';

/**
 * Puma only works in WordPress 4.4 or later.
 */

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
}

/**
 * AJAX callback additions.
 */

require get_template_directory() . '/inc/callback.php';

/**
 * Functional Package additions.
 */

require get_template_directory() . '/inc/pack.php';

/**
 * Functional customize additions.
 */

require get_template_directory() . '/inc/customize.php';

/**
 * Theme update additions.
 */

//require get_template_directory() . '/inc/update.php';

/**
 * Theme required plugins
 */

require 'inc/tgm-plugin-activation/plugins.php';

