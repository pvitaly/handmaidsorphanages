<?php

/**
 * The main page template for the handmaids theme.
 */
 
 //get the current page and make sure it has content to display
$cur_page = Page::get_current_page();

if (!$cur_page || !$cur_page->has_content){
	//no page content - redirect to the 404 page
	require '404.php';
	die();
}

//get the root page hierarchy. this will be used to generate the sidebar navigation menu
$page_list = $cur_page->get_root()->children;

//create the timber context
$content_context = array(
    'posts' => Timber::get_posts(),
	'pages' => $page_list
);

//build the output
get_header();

Timber::render('content.twig', $content_context);

get_footer();
?> 
