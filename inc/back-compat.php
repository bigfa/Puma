<?php

function puma_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'puma_upgrade_notice' );
}
add_action( 'after_switch_theme', 'puma_switch_theme' );


function puma_upgrade_notice() {
	$message = sprintf( __( 'Puma requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'puma' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}


function puma_customize() {
	wp_die( sprintf( __( 'Puma requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'puma' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'puma_customize' );


function puma_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Puma requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'puma' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'puma_preview' );
