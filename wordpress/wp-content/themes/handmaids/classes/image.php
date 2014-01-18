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
		return DBExtractor::find_all(self::criteria());
	}
	
	public static function get_carousel_images(){
		return DBExtractor::find_all(self::criteria(array('post_content' => 'carousel')));
	}
	
	public static function get_logo(){
		return DBExtractor::find(self::criteria(array('post_content' => 'logo')));
	}
	
	private static function criteria($where = null){
		global $wpdb;
		
		$where_args = array(
					'post_type' => 'attachment'
				);
		if ($where){
			$where_args = array_merge($where_args, $where);
		}		

		return array(
			'class' => __CLASS__,
			'table' => $wpdb->posts,
			'where' => $where_args,
			'order' => 'ID');
	}
}

?>