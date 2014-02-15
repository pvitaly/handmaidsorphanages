<?php
/*
Template Name: Category List Template

This template page will list all posts with a category the same as the name of the
page itself.
*/

get_header();

// this is a request for a page so call this first to get the page content
$pages = Timber::get_posts();

$cur_page = $pages[0];

//get any posts matching the category name
$page_name = $cur_page->post_name;

$order = 'asc';

if (property_exists($cur_page, 'post_order')){
	$page_order = $cur_page->post_order;

	if (strpos(strtolower($page_order), 'desc')  === 0 ){
		$order = 'desc';
	}
}

$posts = Timber::get_posts(
	array(
		'category_name' => $page_name,
		'orderby' => 'date',
		'order' => $order
	)
);

$context = array(
	'pages' => $pages,
	'posts' => $posts
);

//render the page content and then all of the posts below
Timber::render('category-list.twig', $context);


get_footer();
