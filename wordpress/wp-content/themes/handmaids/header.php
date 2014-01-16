<?php
/* 
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */

//get the name of the current page
global $pagename;
$current_page = null;
if ($pagename){
	$current_page = strtolower($pagename);
} elseif (is_front_page()){
	$current_page = 'home';
}

//create a map of page data for use in the nav menu
$home = home_url();
$pages = array(
		array(
			'name' => 'home',
			'display' => 'Home',
			'link' => $home . '/'
		),
		array(
			'name' => 'about',
			'display' => 'About',
			'link' => $home . '/about'
			),
		array(
			'name' => 'stories',
			'display' => 'Stories',
			'link' => $home . '/stories'
			),
		array(
			'name' => 'visitor-logs',
			'display' => 'Visitor Logs',
			'link' => $home . '/visitor-logs'
			),
		array(
			'name' => 'give',
			'display' => 'Give',
			'link' => $home . '/give'
			)
	);

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >
	<div id="page">
		<div id="header">
			<div class="wrapper">
				<div class="mainTitle">Handmaids of the Blessed Trinity Orphanages</div>
				<ul class="navmenu">
					<?php foreach ($pages as $page) : ?>
					
					<li <?php if ($current_page == $page['name'] ) : ?>class="current"<?php endif; ?>>
						<a href="<?php echo $page['link']; ?>"><?php echo $page['display']; ?></a>
						<div class="uparrow"></div>	
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div id="main" class="wrapper">


