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
//        Timber::render('sidebar.twig', array('pages' => $base->children));
        $content_context['pages'] = $base->children;
    }
}



Timber::render('content.twig', $content_context);
