<?php

function puma_customize_register( $wp_customize ) {

    $wp_customize->add_section('header_logo',array(
        'title'     => '站点Logo',
        'priority'  => 50
    ) );

    $wp_customize->add_setting( 'header_logo_image', array(
        'default'   => '',
        "transport" => "postMessage",
        'type'      => 'option'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo_image', array(
         'label'     => '站点logo',
         'section'   => 'header_logo'
    ) ) );
}
add_action( 'customize_register', 'puma_customize_register' );