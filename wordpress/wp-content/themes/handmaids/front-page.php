<?php
/**
 * The main home page for the handmaids theme.
 */

 //display the header
get_header(); 

// get the carousel images and randomize them
$img_list = Image::get_carousel_images();

/* TIMBER CODE 
 * $context = array(
    'img1' => $img_list[1]->guid,
    'img2' => $img_list[2]->guid
);
    Timber::render('carousel.twig', $context);
 */


shuffle($img_list); 

?>
	<div id="carousel-div" class="row">
		<div id="home-carousel" class="carousel slide" data-ride="carousel">

			<ol class="carousel-indicators">
					<?php
					//loop through the images and add the markers for them
					for ( $i = 0; $i <count($img_list) ; ++$i) : ?>
						<li data-target="#home-carousel" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) { echo ' class="active"'; } ?>></li>
				<?php endfor; ?>
			</ol>
			
			<div class="carousel-inner">
			
			<?php
				//loop through the images and add them
				for ( $i = 0; $i <count($img_list) ; ++$i) : ?>
					<div class="item<?php if ($i == 0) { echo ' active'; } ?>">	
						<img class="carousel-image img-rounded" src="<?php echo $img_list[$i]->guid; ?>" />
					</div>
			<?php endfor; ?>

			</div>
			
			<a class="left carousel-control" href="#home-carousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#home-carousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>
	
<?php

//display the content
get_template_part('content', 'page');
//display the footer
get_footer(); 

?> 
