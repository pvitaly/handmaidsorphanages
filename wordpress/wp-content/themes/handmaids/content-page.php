<?php
/**
This is the standard template for displaying main page content
*/
$content_context = array(
    'posts'=> Timber::get_posts()
);

Timber::render('content.twig', $content_context);