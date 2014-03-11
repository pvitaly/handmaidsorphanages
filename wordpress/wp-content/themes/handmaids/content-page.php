<?php

/**
  This is the standard template for displaying main page content
 */
$content_context = array(
    'posts' => Timber::get_posts()
);

$cur_page = Page::get_current_page();

if ($cur_page) {
    //go to the root of the page tree
    $base = $cur_page;
    while ($base->has_parent()) {
        $base = $base->parent_page;
    }

    if ($base->has_children()) {
		//get the child pages
        $content_context['pages'] = $base->children;
		
		//get the sidebar title associated with the page; this will always be the sidebar title value of the root-level page
		$content_context['sidebar_title'] = get_post_meta($base->ID, 'sidebar_title', true);
    }
}

Timber::render('content.twig', $content_context);
