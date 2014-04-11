<?php

/**
Contains functions for customizing the admin menus.
*/

/**************************** Media ******************************/

function add_media_carousel_column($columns, $wp_list_table){
	//insert the show in carousel column into the desired position
	$pos = 4;

	return array_slice($columns, 0, $pos, true) + 
		array('carousel' => 'Carousel') +
		array_slice($columns, $pos, count($columns) - 1, true);
}

function get_media_carousel_value($column_name, $post_id){
	$img = Image::get_image_by_id($post_id);

	if (!is_null($img) && $img->carousel){
			echo  $img->carousel;
	}
}

function add_media_carousel_sortable($columns){
	$columns['carousel'] ='carousel';
	
	return $columns;
}

function add_media_carousel_sort_vars($vars){
	if ( isset ($vars['orderby']) && $vars['orderby'] == 'carousel'){
		$vars = array_merge($vars, array(
			'meta_key' => 'carousel',
			'orderby' => 'meta_value'
		));
	}
	
	return $vars;
}

add_filter( 'manage_media_columns',  'add_media_carousel_column', 10, 2);
add_action('manage_media_custom_column', 'get_media_carousel_value', 10, 2);

add_filter( 'manage_upload_sortable_columns',  'add_media_carousel_sortable', 10, 1);
add_filter('request', 'add_media_carousel_sort_vars', 10, 1);

/************************** Pages *****************************/

function my_manage_pages_columns_filter($columns){
	//insert the show in carousel column into the desired position
	$pos = 2;

	return array_slice($columns, 0, $pos, true) + 
		array('menu_order' => 'Order') +
		array_slice($columns, $pos, count($columns) - 1, true);
}

function my_manage_pages_custom_column($column_name, $post_id){
	if (get_post_field('post_parent', $post_id) > 0){
		echo '&mdash; ';
	}
	echo get_post_field('menu_order', $post_id);
}

add_filter( 'manage_pages_columns',  'my_manage_pages_columns_filter', 10, 1);
add_action('manage_pages_custom_column', 'my_manage_pages_custom_column', 10, 2);