<?php
/*
A class for working with images.
*/
class Image {
	
	public static $PODS_NAME = 'media';
	
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
	public $post_content;
	
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
	
	/**
	Loads the given image by its id.
	*/
	public static function get_image_by_id($ID){
		$params = array(
				'where' => "t.ID = '$ID'"
			);
		return PodsHelper::find_one(__CLASS__, $params);	
	}
	
	/**
	Retrieves Images from the database
	*/
	public static function get_images(){
			$params = array(
					'orderby' => 'ID'
					);
				
			return PodsHelper::find(__CLASS__, $params);
	}
	
	public static function get_carousel_images(){
			$params = array(
					'where' => "show_in_carousel.meta_value = 1"
				);
			
			return PodsHelper::find( __CLASS__, $params);
	}
}