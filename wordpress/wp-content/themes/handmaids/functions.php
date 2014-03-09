<?php 
/*
 * This file containing the initialization and library functions for the handmaids theme.
 */
 
//include some class files
require 'includes/class-pods-helper.php';
require 'includes/class-image.php';
require 'includes/class-page.php';

//load the admin page ui if needed
if (is_admin()){
	require 'includes/admin-menu.php';
}

/*
 * Set up css and script injection 
 */ 
function enqueue_theme_styles() {
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style('content', get_template_directory_uri() . '/css/content.css');
	wp_enqueue_style('main-style', get_stylesheet_uri());
}
function enqueue_theme_scripts() {
	$baseJsUri = get_template_directory_uri() . '/js/';

	//move jquery to the footer
	wp_deregister_script('jquery');
	wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false /* no dependencies*/, '1.10.2', true /* in footer*/);
	wp_enqueue_script('jquery');
	
	wp_enqueue_script('bootstrap', $baseJsUri . 'bootstrap.js', array('jquery'), null, true);
	wp_enqueue_script('main-script', $baseJsUri . 'handmaids.js', array('jquery', 'bootstrap'), null, true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );