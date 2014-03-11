<?php
/**
 * The main home page for the handmaids theme.
 */

 //display the header
get_header(); 

// get the carousel images and randomize them
$img_list = Image::get_carousel_images();

shuffle($img_list); 
$context = array(
    'img_list' => $img_list,
	'posts' => Timber::get_posts()
);
Timber::render('home.twig', $context);

//display the footer
get_footer(); 