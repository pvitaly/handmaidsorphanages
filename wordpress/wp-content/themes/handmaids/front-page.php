<?php
/**
 * The main home page for the handmaids theme.
 */

 //display the header
get_header(); 

// get the carousel images and randomize them
$img_list = Image::get_carousel_images();

shuffle($img_list); 
$img_context = array(
    'img1' => $img_list[0]->guid,
    'img2' => $img_list[1]->guid
);
Timber::render('carousel.twig', $img_context);

//display the content
get_template_part('content', 'page');
//display the footer
get_footer(); 