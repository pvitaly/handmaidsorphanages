<?php 
/*
 * The file containing the initialization and library functions for the handmaids theme.
 */

/*
 * Set up the style and script injection 
 */ 
function enqueue_theme_styles() {
	wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
function enqueue_theme_scripts() {
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/handmaids.js' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );
?>
