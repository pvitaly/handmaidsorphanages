<?php
/*
A class for working with images.
*/

class Image {
	
	/**
	The id of the image
	*/
	public $ID;
	
	/**
	The guid of the image
	*/
	public $guid;
	
	/**
	The description of the image.
	*/
	public $description;
	
	/**
	Boolean value indicating whether or not this image should be displayed in the main
	page image carousel.
	*/
	public $show_in_carousel;
	
	
	/**
	Returns the url for the image, firing all appropriate triggers 
	*/
	public function get_url(){
		return wp_get_attachment_url($ID);
	}
	
	public static $property_map = array(
		'ID' => 'posts.ID',
		'guid' => 'posts.guid',
		'description' => 'posts.post_content',
		'show_in_carousel' => 'custom.show_in_carousel'
	);
	
	public static $post_type_name = 'attachment';
	
	/**
	Retrieves Images from the database
	TODO: add functionality to pass in filter arguments to this
	*/
	public static function get_images(){
		return CustomPost::find_all(__CLASS__, 
			array(
				'order' => 'ID'
				)
			);
	}
	
	public static function get_carousel_images(){
		return CustomPost::find_all(__CLASS__, 
			array(
				'where' => array ('show_in_carousel' => 1),
				'order' => 'ID'
				)
			);
	}
}

?>