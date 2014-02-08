<?php

/**
Contains functions for customizing the admin menus.
*/

/**************************** Media ******************************/

function my_manage_media_columns_filter($columns, $wp_list_table){
	//insert the show in carousel column into the desired position
	$pos = 4;

	return array_slice($columns, 0, $pos, true) + 
		array('show_in_carousel' => 'Show in Carousel') +
		array_slice($columns, $pos, count($columns) - 1, true);
}

function my_manage_upload_sortable_columns_filter($columns){
	$columns['show_in_carousel'] ='show_in_carousel';
	
	return $columns;
}

function my_manage_media_custom_column($column_name, $post_id){
	$img = Image::get_image_by_id($post_id);

	if (!is_null($img) && $img->show_in_carousel == 1){
			echo "Yes";
	}
}

add_filter( 'manage_media_columns',  'my_manage_media_columns_filter', 10, 2);
add_filter( 'manage_upload_sortable_columns',  'my_manage_upload_sortable_columns_filter', 10, 1);
add_action('manage_media_custom_column', 'my_manage_media_custom_column', 10, 2);

