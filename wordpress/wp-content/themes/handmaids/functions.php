<?php 
/*
 * This file containing the initialization and library functions for the handmaids theme.
 */

//include some class files
require 'classes/treenode.php';
require 'classes/dataloader.php';
require 'classes/image.php';

/*
 * Set up css and script injection 
 */ 
function enqueue_theme_styles() {
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
	wp_enqueue_style('main-style', get_stylesheet_uri());
}
function enqueue_theme_scripts() {
	$baseJsUri = get_template_directory_uri() . '/js/';

	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap', $baseJsUri . 'bootstrap.js', array('jquery'));
	wp_enqueue_script('main-script', $baseJsUri . 'handmaids.js', array('jquery', 'bootstrap'));
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );

/**
Returns the name of the current page. If the page is the front page, then 'home' is returned.
If the page is a 404 page, then '404' is returned. Otherwise the global variable pagename is returned.
*/
function get_page_name(){
	if (is_front_page()){
		return 'home';
	} elseif (is_404()){
		return '404';
	}
	
	global $pagename;
	return $pagename;
}

?>
