<?php
/**
 * excelerate Theme Customizer
 *
 * @package excelerate
 */

/**
 * Load Kirki
 */
if ( ! class_exists( 'Kirki' ) && file_exists( get_template_directory() . '/vendor/aristath/kirki/kirki.php' ) ) {
    require get_template_directory() . '/vendor/aristath/kirki/kirki.php';
}

/**
 * Do not proceed if Kirki does not exist
 */ 
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

Kirki::add_config(
	'excelerate_options', array(
		'capability'        => 'edit_theme_options',
        'option_type'       => 'theme_mod',
        'disable_output'    => false,
	)
);

/*
Kirki::add_panel(
	'typography', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Typography', 'excelerate' ),
	)
);

Kirki::add_section( 'typography_general', array(
    'title'       => __( 'General', 'excelerate' ),
    'panel'       => 'typography',
) );

Kirki::add_field( 'typography_body', array(
    'type'        => 'typography',
    'settings'    => 'typography',
    'label'       => esc_html__( 'Body', 'excelerate' ),
    'section'     => 'typography_general',
    'priority'    => 10,
    'transport'   => 'auto',
    'default'     => array(
		'font-family'    => 'inherit',
		'variant'        => 'regular',
		'font-size'      => '16px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
    ),
    'fonts'       => array(
        'standard'      => array( 'serif', 'sans-serif' ),
        'google'        => [],
    ),
    'output'      => array(
        array(
            'element' => array( 'body' ),
        ),
    ),
) );
*/

Kirki::add_panel(
	'layout', array(
		'priority'    => 11,
		'title'       => esc_html__( 'Layout', 'excelerate' ),
	)
);

Kirki::add_section( 'layout_header', array(
    'title'       => __( 'Header', 'excelerate' ),
    'panel'       => 'layout',
) );

Kirki::add_section( 'layout_header_layout', array(
    'title'       => __( 'Layout', 'excelerate' ),
    'panel'       => 'layout',
    'section'     => 'layout_header'
) );

Kirki::add_field( 'excelerate_options', [
	'type'        => 'radio-image',
	'settings'    => 'layout_header_layout',
	'label'       => esc_html__( 'Header layout', 'excelerate' ),
	'section'     => 'layout_header',
	'default'     => 'inline--logo-left',
	'priority'    => 10,
	'choices'     => [
		'inline--logo-left'   => get_template_directory_uri() . '/images/customizer/Excelerate_Customizer_Image__0000_inline--logo-left.png',
		'block--logo-center'  => get_template_directory_uri() . '/images/customizer/Excelerate_Customizer_Image__0001_block--logo-center.png',
	],
] );


Kirki::add_section( 'layout_above_header', array(
    'title'       => __( 'Above Header', 'excelerate' ),
    'panel'       => 'layout',
    'section'     => 'layout_header'
) );

Kirki::add_field( 'excelerate_options', [
	'type'        => 'dimensions',
	'settings'    => 'above_header_padding',
	'label'       => esc_html__( 'Padding', 'excelerate' ),
	'section'     => 'layout_above_header',
	'default'     => array(
		'padding-top'       => '.5em',
		'padding-bottom'    => '.5em',
    ),
    'output'      => array(
        array(
            'element'       => '.header__above',
        ),
        array(
            'element'       => '.header__above',
        )
    ),
    'transport'   => 'auto'
] );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function excelerate_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'excelerate_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'excelerate_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'excelerate_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function excelerate_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function excelerate_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function excelerate_customize_preview_js() {
	wp_enqueue_script( 'excelerate-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'excelerate_customize_preview_js' );
