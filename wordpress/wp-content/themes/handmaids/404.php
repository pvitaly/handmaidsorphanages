<?php
/*
 * This is the main page of the Handmaids of the Blessed Trinity Orphanages site.
 */

get_header();

?>

<div id="content" class="container">
    <div class="row">
		<h2>404 - Page not found</h2>
		<p>The resource you requested could not be found.</p>
		<p><i><?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?></i></p>
	</div>
</div>

<?
get_footer(); 