<?php
/* 
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */

 $max_menu_depth = 0;
 
/**
Renders the page menu
*/
function build_page_menu($max_depth) {
	//get the name of the current page
	$current_page = get_page_name();
	
	//get a hierarchical list of all pages in the site
	$page_list = DataLoader::get_page_list();
	
	//begin creating the 
	$output = '<ul id="navmenu">';
	
	foreach ($page_list as $page_node){
		$page = $page_node->node;
		$is_current_page = ($current_page == $page->post_name);
		
		$output .= '<li';
		if ($is_current_page) {
			$output .=  ' class="current"';
		}
		$output .= '><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a>';
		
		if ($is_current_page){
			$output .= '<div class="uparrow"></div>';
		}
		
		//render any children if needed
		if ($page_node->has_children()){
			$output .= build_page_children($page_node->children, 1, $max_depth);
		}
		
		$output .= '</li>';
	}
	
	$output .= '</ul>';
	
	return $output;
}

/**
Recursive method to render a page heirarchy to the given max_depth
*/
function build_page_children($page_nodes, $current_depth, $max_depth){
	if (empty($page_nodes) || $current_depth > $max_depth){
		return '';
	}
	
	$output = '<ul class="submenu">';
	
	foreach ($page_nodes as $page_node) {
		$page = $page_node->node;
		$output .= '<li><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a>';
		$output .= build_page_children($page_node->children, $current_depth++, $max_depth);
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
				<div id="mainTitle">Handmaids of the Blessed Trinity Orphanages</div>
				<?php echo build_page_menu($max_menu_depth); ?>
			</div>
		</div>

		<div id="main" class="wrapper">


