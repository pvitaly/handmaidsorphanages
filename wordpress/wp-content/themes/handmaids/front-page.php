<?php
/**
 * The main home page for the handmaids theme.
 */

get_header(); 

// photo carousel
$img_list = Image::get_images();

echo '<div id="photo-carousel">';
foreach ($img_list as $img){
	echo "<img src='$img->guid'/>";
}
echo '</div>';

//display the content
get_template_part('content', 'page');

get_footer(); ?> 
