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
	
	private function __construct($row){
		foreach ($row as $col => $val){
			$this->$col = $val;
		}
	}
	
	/**
	Returns the url for the image, firing all appropriate triggers 
	*/
	public function get_url(){
		return wp_get_attachment_url($ID);
	}
	
	/**
	Retrieves Images from the database
	TODO: add functionality to pass in filter arguments to this
	*/
	public static function get_images(){
		global $wpdb;
		
		$query_results = $wpdb->get_results(
				"select ID, guid from $wpdb->posts as posts where post_type = 'attachment'",
				ARRAY_A //returns the output as a numerically indexed array of associative arrays, with columns as keys
			);
		
		$img_list = array();
		
		foreach ($query_results as $row){
			array_push ($img_list, new Image($row));
		}
		
		return $img_list;
	}
	
}

?>