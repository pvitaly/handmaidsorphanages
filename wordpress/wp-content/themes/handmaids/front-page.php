<?php
/**
 * The main home page for the handmaids theme.
 */

get_header(); 

// photo carousel
$img_list = Image::get_carousel_images();

echo '<div id="carousel-div" class="row">';
echo '<div id="carousel-generic" class="carousel slide" data-ride="carousel">';
// indicators 
echo ' <ol class="carousel-indicators">';
echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
echo '<li data-target="#carousel-example-generic" data-slide-to="1"></li>';
echo '</ol>';
echo '<div class="carousel-inner">';
echo '<div class="item active">';
$img = $img_list[0];
echo "<img class='carousel-image img-rounded' src='$img->guid'/>";
echo '</div>';
echo '<div class="item">';
$img2 = $img_list[1];
echo "<img class='carousel-image img-rounded' src='$img2->guid'/>";
echo '</div>';
echo '</div>';

// Controls
echo '<a class="left carousel-control" href="#carousel-generic" data-slide="prev">';
echo '<span class="glyphicon glyphicon-chevron-left"></span>';
echo '</a>';
echo '<a class="right carousel-control" href="#carousel-generic" data-slide="next">';
echo '<span class="glyphicon glyphicon-chevron-right"></span>';
echo '</a>';
echo '</div>';
echo '</div>';



// foreach ($img_list as $img){
	// echo "<img src='$img->guid'/>";
// }

echo '</div>';

//display the content
get_template_part('content', 'page');

get_footer(); ?> 
