<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package excelerate
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function excelerate_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'excelerate_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function excelerate_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'excelerate_pingback_header' );


/**
 * Outputs the content above the primary header
 *
 * @return void
 */
function excelerate_above_header() {
    if ( is_active_sidebar( 'above-header' ) ) {
    ?>

        <div class="header__above">
            <div class="header__above__container">
                <?php dynamic_sidebar( 'above-header' ); ?>
            </div>
        </div>

    <?php
    }
}
add_action( 'excelerate_header', 'excelerate_above_header', 10 );


function excelerate_header_layout() {
    $layout = get_theme_mod( 'layout_header_layout', 'inline--logo-left' );

    switch ( $layout ) {
        case 'inline--logo-left' :
            $template = 'inline-logo-left';
            break;

        default :
            $template = apply_filters( 'excelerate_header_layout_template', '', $layout );
    }

    if ( locate_template( array( 'template-parts/header/' . $template . '.php' ) ) ) {
        get_template_part( 'template-parts/header/' . $template );
    }
}
add_action( 'excelerate_header', 'excelerate_header_layout', 15 );