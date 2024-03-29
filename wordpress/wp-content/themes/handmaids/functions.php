<?php

/*
 * This file containing the initialization and library functions for the handmaids theme.
 */

//include some class files
require 'includes/class-pods-helper.php';
require 'includes/class-image.php';
require 'includes/class-page.php';

//load the admin page ui if needed
if (is_admin()) {
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
    wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false /* no dependencies */, '1.10.2', true /* in footer */);
    wp_enqueue_script('jquery');

    wp_enqueue_script('bootstrap', $baseJsUri . 'bootstrap.js', array('jquery'), null, true);
    wp_enqueue_script('main-script', $baseJsUri . 'handmaids.js', array('jquery', 'bootstrap'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_theme_styles');
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');

/**
  register shortcodes
 */
 
 // executes nested shortcodes, ignoring other content
 function do_nested_shortcodes($content = null){
	$result = '';
	
	if ($content){
		$shortcodes = array();

		preg_match_all('/(\[.*?\])/', $content, $shortcodes, PREG_PATTERN_ORDER); //pull out all of the internal shortcodes
		if ($shortcodes[0]){
			foreach ($shortcodes[0] as $shortcode){
				$result .= do_shortcode($shortcode);
			}
		}
	}
	
	return $result;
 }
 
//shortcode for creating a page title
function pagetitle_handler($atts, $content = null) {
    return '<div class="page-title row">' . $content . '</div>';
}

add_shortcode('pagetitle', 'pagetitle_handler');

//shortcode for creating a section title
function sectiontitle_handler($atts, $content = null) {
    return '<div class="section-title row">' . $content . '</div>';
}

add_shortcode('sectiontitle', 'sectiontitle_handler');


//shortcode for google maps
$map_count = 0;

function googlemap_handler($atts, $content = null) {
    global $map_count;

    extract(shortcode_atts(array(
        'lat' => 42.2733204,
        'long' => -83.7376894,
        'zoom' => 8,
        'width' => -1,
        'height' => -1
                    ), $atts));

    $id = "googlemap$map_count";

    $result = '';
    if ($map_count == 0) { //first map on the page
        $result = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
    }

    $result .= "<div id='$id' class='googlemap' style='";

    if ($width > -1) {
        $result .= "width: ${width}px;";
    } else {
        $result .= "width: 100%;";
    }

    if ($height > -1) {
        $result .= "height: ${height}px;";
    } else {
        $result .= "height: 100%;";
    }


    $result .= "'></div>";
    $result .= "<script type='text/javascript'>function initialize_$id(){var opts = {center: new google.maps.LatLng($lat, $long), zoom: $zoom };";
    $result .= "var $id = new google.maps.Map(document.getElementById('$id'), opts);";
	
	//call do_shortcodes on the content to place any markers
	$result .= do_nested_shortcodes($content);
	
    $result .= "}; google.maps.event.addDomListener(window, 'load', initialize_$id);";
    $result .= "</script>";

	//increment the map count for the next map
    $map_count++;

    return $result;
}
add_shortcode('googlemap', 'googlemap_handler');

function map_marker_handler($atts){
	global $map_count;

	extract(shortcode_atts(array(
        'lat' => 0,
        'long' => 0,
        'title' => ''), $atts));
		
	$id = "googlemap$map_count";
		
	return "new google.maps.Marker({ position: new google.maps.LatLng($lat, $long), map: $id, title : '$title'});";
}
add_shortcode('marker', 'map_marker_handler');

function carousel($atts) {

    extract(shortcode_atts(array(
        'name' => 'school'
                    ), $atts));

    $img_list = Image::get_carousel_images($name);

    $content_context = array(
        'img_list' => $img_list
    );

    return Timber::compile('generic-carousel.twig', $content_context);
}

add_shortcode('carousel', 'carousel');

function float_right($atts, $content = null) {
    return '<div class="float_right">' . do_shortcode($content) . '</div>';
}

add_shortcode('right', 'float_right');

function float_left($atts, $content = null) {
    return '<div class="float_left">' . do_shortcode($content) . '</div>';
}

add_shortcode('left', 'float_left');

function anchor($atts) {
	extract(shortcode_atts(array(
        'name' => ''
                    ), $atts));
    return '<a class="jumpAnchor" id="' . $name . '"></a>';
}

add_shortcode('anchor', 'anchor');
