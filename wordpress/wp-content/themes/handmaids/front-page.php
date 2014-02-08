<?php
/**
 * The main home page for the handmaids theme.
 */

get_header(); 

// photo carousel
$img_list = Image::get_carousel_images();

$context = array(
    'img1' => $img_list[1]->guid,
    'img2' => $img_list[2]->guid
);
Timber::render('carousel.twig', $context);

//display the content
get_template_part('content', 'page');

get_footer(); ?> 