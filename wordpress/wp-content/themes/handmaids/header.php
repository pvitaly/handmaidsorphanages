<?php
/* 
 * The header for the handmaids theme. This displays all of the head tags and the content header up until the
 * div id="main" section.
 */
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
			</div>
		</div>
		<div id="main" class="wrapper">

