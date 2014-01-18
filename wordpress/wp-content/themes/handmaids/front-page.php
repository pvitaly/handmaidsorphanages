<?php
/**
 * The main home page for the handmaids theme.
 */

get_header(); 

// photo carousel
$img_list = Image::get_carousel_images();

echo '<div id="photo-carousel">';

//display a random picture for now
$idx = rand(0, count($img_list) - 1);
$img = $img_list[$idx];
echo "<img src='$img->guid'/>";

// foreach ($img_list as $img){
	// echo "<img src='$img->guid'/>";
// }

echo '</div>';

//display the content
get_template_part('content', 'page');

get_footer(); ?> 
