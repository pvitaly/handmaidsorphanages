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

    public function get_permalink() {
        return get_permalink($this->ID);
    }

    public function has_children() {
        return !empty($this->children);
    }

    /**
      Returns a boolean indicating whether or not the given pagename occurs as part
      of this page's hierarchy.
     */
    public function in_tree($pagename) {
        //check this page's name
        if ($this->name == $pagename) {
            return true;
        }

        //check any descendants
        if ($this->children) {
            foreach ($this->children as $child) {
                if ($child->in_tree($pagename)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function get_current_page() {
        global $post;

        if (!$post || $post->post_type != 'page') {
            return null;
        }

        $post_list = get_pages(array(
            'sort_order' => 'ASC',
            'sort_column' => 'menu_order',
            'hierachical' => 1,
            'post_type' => 'page',
            'post_status' => 'publish',
            'parent' => $post->ID
        ));

        $post_list[] = $post;

        $results = self::to_page_list($post_list);

        return array_shift($results);
    }

    /**
      Returns the name of the current page or null if it could not be found.
     */
    public static function get_current_pagename() {
        $page = self::get_current_page();
        if ($page) {
            return $page->name;
        }
        return null;
    }

    /**
      Gets all of the published pages in the site.
     */
    public static function get_pages() {
        $posts = get_pages(array(
            'sort_order' => 'ASC',
            'sort_column' => 'menu_order',
            'hierachical' => 1,
            'post_type' => 'page',
            'post_status' => 'publish'
        ));

        return self::to_page_list($posts);
    }

    /**
      Converts a list of posts to a list of pages.
     */
    private static function to_page_list($posts) {
        $page_map = array();
        foreach ($posts as $post) {
            $page_map[$post->ID] = self::map_post($post);
        }

        //convert the flat page array into a list of page hierarchies
        $page_list = array();
        foreach ($page_map as $id => $page) {
            if (array_key_exists($page->parent_ID, $page_map)) { //this page has a parent
                $parent = $page_map[$page->parent_ID];

                $page->parent_page = $parent;
                $parent->children[] = $page;
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