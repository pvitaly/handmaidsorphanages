<?php

/**
  Class representing a page in the site
 */
class Page {

    public $ID;
    public $name;
    public $title;
    public $guid;
    public $parent_ID;
    public $parent_page;
    public $children = array();
	public $is_current_page = false;
	public $is_in_page_path = false;
    
    public function get_permalink() {
        return get_permalink($this->ID);
    }

    public function has_children() {
        return !empty($this->children);
    }
	
	public function has_parent(){
		return isset($this->parent_page);
	}

	/************* Static Members ******************/
	
	/**
	Private variable to help ensure that we only load pages once.
	*/
	private static $loaded = false;
	
	/**
	Stores all of the pages so multiple calls to not result in a reload each time.
	*/
	private static $pages = null;
	
	/**
	Stores the current page so we don't have to look it up each time.
	*/
	private static $current_page = null;
	
	/**
	Returns the current page or null if we are not currently displaying a page.
	*/
    public static function get_current_page() {
        //load all of the pages if we haven't already
		if (!self::$loaded){
			self::load();
		}
		
		return self::$current_page;
    }

    /**
      Gets all of the published pages in the site in a hierarchical structure.
     */
    public static function get_pages() {
		if (!self::$loaded){
			self::load();
		}
		
		return self::$pages;
    }
	
	/**
	Private function to load the page list into memory. This only needs to be done once.
	*/
	private static function load(){
		$posts = get_pages(array(
            'sort_order' => 'ASC',
            'sort_column' => 'menu_order',
            'hierachical' => 1,
            'post_type' => 'page',
            'post_status' => 'publish'
        ));

        self::$pages =  self::to_page_list($posts);
		
		self::$loaded = true;
	}

    /**
      Converts a list of posts to a list of pages.
     */
    private static function to_page_list($posts) {
        global $post;
		
		$page_map = array();
        foreach ($posts as $page_post) {
			$p = self::map_post($page_post);
            $page_map[$page_post->ID] = $p;
			
			//check if this is the current page
			if ($p->ID == $post->ID){
				$p->is_current_page = true;
				$p->is_in_page_path = true;
				self::$current_page = $p;
			}
        }

        //convert the flat page array into a list of page hierarchies
        $page_list = array();
        foreach ($page_map as $id => $page) {
            if (array_key_exists($page->parent_ID, $page_map)) { //this page has a parent
                $parent = $page_map[$page->parent_ID];

                $page->parent_page = $parent;
                $parent->children[] = $page;
				
				if ($page->is_current_page){
					//set all ancestor pages to be in the page path
					$ancestor = $page->parent_page;
					 while (!is_null($ancestor)) {
							$ancestor->is_in_page_path = true;
							$ancestor = $ancestor->parent_page;
					 }
				}
            } else { //no parent; add to list
                $page_list[] = $page;
            }
        }
		
        return $page_list;
    }

    /**
      Maps the given wp_post into the Page object
     */
    private static function map_post($post) {
        $p = new Page();

        $p->ID = $post->ID;
        $p->name = $post->post_name;
        $p->title = $post->post_title;
        $p->guid = $post->guid;
        $p->parent_ID = $post->post_parent;

        return $p;
    }
}
