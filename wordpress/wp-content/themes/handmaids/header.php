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
	$favicon = Image::get_image_by_title('favicon');
	if ($favicon){
		echo '<link rel="shortcut icon" href="' . $favicon->get_url(). '" type="' . $favicon->post_mime_type . '" />';
	}
}

/**
Renders the logo img tag
*/
function write_logo(){
	$logo = Image::get_image_by_title('logo');
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
	
	<title><?php echo wp_title( '|', false, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >
		
		<!-- Facebook js-->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<!-- twitter js -->
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

		<!-- google share js -->
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/platform.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>

	<div id="page">
		<div id="header">
			<div class="wrapper clearfix center navbar navbar-fixed-top navbar-inverse">
                            <div id="header-logo-title" class="container">
                            <?php write_logo(); ?>
				<div id="mainTitle"><?php echo strtolower(get_bloginfo('name')); ?></div>
                            </div>
        	<?php build_page_menu(); ?>
			</div>
		</div>

		<div id="main-container" class="wrapper container">
			<div id="main">
	
