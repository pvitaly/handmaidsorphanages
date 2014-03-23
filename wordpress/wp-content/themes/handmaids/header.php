<?php

/*
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */

/**
  Renders the page menu
 */
function build_page_menu() {
    //get a hierarchical list of all pages in the site
    $page_list = Page::get_pages();

    $context = array();
    $context['page_list'] = $page_list;
    Timber::render('navmenu.twig', $context);
}

/**
 Renders the favicon link if applicable
*/
function write_favicon(){
	$favicon = Image::get_image_by_name('favicon');
	if ($favicon){
		echo '<link rel="shortcut icon" href="' . $favicon->get_url(). '" type="' . $favicon->post_mime_type . '" />';
	}
}

/**
Renders the logo img tag
*/
function write_logo(){
	$logo = Image::get_image_by_name('logo');
	if ($logo){
		echo '<img class="logo" src="' . $logo->get_url() .'" />';
	}
}

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php write_favicon(); ?>
	
	<title><?php echo wp_title( '|', false, 'right' ), get_bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >
	<div id="page">
		<div id="header">
			<div class="wrapper clearfix center navbar navbar-fixed-top navbar-inverse">
				<?php write_logo(); ?>
				<div id="mainTitle"><?php echo strtolower(get_bloginfo('name')); ?></div>
				<?php build_page_menu(); ?>
			</div>
		</div>

		<div id="main-container" class="wrapper container">
			<div id="main">