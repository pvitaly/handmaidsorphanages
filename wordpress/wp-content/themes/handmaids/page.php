<?php
/**
 * The main page template for the handmaids theme.
 */
 
get_header(); 


//render the sidebar if needed

$cur_page = Page::get_current_page();

if ($cur_page){
	//go to the root of the page tree
	$base = $cur_page;
	while ($base->has_parent()){
		$base = $base->parent_page;
	}

	if ($base->has_children()){
		Timber::render('sidebar.twig', array('pages' => $base->children));
	}
}

//display the content for this page
get_template_part('content', 'page');

get_footer(); ?> 
