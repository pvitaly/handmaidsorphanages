<?php
/* 
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */

 $max_menu_depth = 1;
 
/**
Renders the page menu
*/
function build_page_menu($max_depth) {
	//get the name of the current page
	$current_page = Page::get_current_pagename();
	
	//get a hierarchical list of all pages in the site
	$page_list = Page::get_pages();
	
	
	//begin creating the output 
	$output = '<ul id="navmenu" class="horizontalList">';
	
	foreach ($page_list as $page){
		$is_selected_page = $page->in_tree($current_page);
		
		$output .= '<li';
		if ($is_selected_page) {
			$output .=  ' class="current"';
		}
		$output .= '><a href="' . $page->get_permalink() . '">' . $page->title . '</a>';
		
		//render any children if needed
		if ($page->has_children()){
			$output .= build_page_children($page->children, 1, $max_depth);
		}
		
		//if ($is_selected_page){
			$output .= '<div class="uparrow"></div>';
		//}
		
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	
	return $output;
}

/**
Recursive method to render a page heirarchy to the given max_depth
*/
function build_page_children($page_list, $current_depth, $max_depth){
	if (empty($page_list) || $current_depth > $max_depth){
		return '';
	}
	
	$output = '<ul class="submenu">';
	
	foreach ($page_list as $page) {
		$output .= '<li><a href="' . $page->get_permalink() . '">' . $page->title . '</a>';
		$output .= build_page_children($page->children, $current_depth++, $max_depth);
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	return $output;
}

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo wp_title( '|', false, 'right' ), get_bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >
	<div id="page">
		<div id="header">
			<div class="wrapper">
				<img class="logo" src="<?php echo get_stylesheet_directory_uri() . "/img/logo.png"; ?>"/>
				<div id="mainTitle">Handmaids of the Blessed Trinity Orphanages</div>
				<?php echo build_page_menu($max_menu_depth); ?>
			</div>
		</div>

		<div id="main" class="wrapper container">


