<?php
/**
This is the standard template for displaying main page content
*/

/* add links for any existing subpages */
$cur_page = Page::get_current_page();
$content_context = array(
    'cur_page' => $cur_page,
    'posts'=> Timber::get_posts()
);

Timber::render('content.twig', $content_context);
while (have_posts()){
	the_post();
	the_content();
}