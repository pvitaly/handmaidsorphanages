<?php

/*
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */

 $max_menu_depth = 1;
/**
  Renders the page menu
 */
function build_page_menu($max_depth) {
    //get a hierarchical list of all pages in the site
    $page_list = Page::get_pages();

    $context = array();
    $context['page_list'] = $page_list;
    Timber::render('navmenu.twig', $context);

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
	<title><?php echo wp_title( '|', false, 'right' ), get_bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >
	<div id="page">
		<div id="header">
			<div class="wrapper clearfix">
				<img class="logo" src="<?php echo get_stylesheet_directory_uri() . "/img/logo.png"; ?>"/>
				<div id="mainTitle">Handmaids of the Blessed Trinity Orphanages</div>
				<?php echo build_page_menu($max_menu_depth); ?>
			</div>
		</div>

		<div id="main" class="wrapper container">