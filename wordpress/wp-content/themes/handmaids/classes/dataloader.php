<?php
/**
Class containing functions for pulling data from the WP database.
*/
class DataLoader {
	/**
	Creates a list of TreeNodes representing the page structure of the site.
	*/
	public static function get_page_list(){
			//pull all of the published pages in the site in a flat array
			$pages = get_pages(array(
					'sort_order' => 'ASC',
					'sort_column' => 'menu_order',
					'hierachical' => 1,
					'post_type' => 'page',
					'post_status' => 'publish'
				));	
			
			//create an id lookup-table consisting of page tree nodes
			$node_map = array();
			foreach ($pages as $p){
				$node_map[$p->ID] = new TreeNode($p);
			}
			
			//convert the flat page array into a list of page hierarchies
			$page_list = array();
			foreach ($pages as $p){
				if ($p->post_parent < 1){ //no parent; add to page list
					$page_list[] =  $node_map[$p->ID];
				} else if ($node_map[$p->post_parent]) { //the page does have a parent in the list
					$node_map[$p->post_parent]->children[] = $node_map[$p->ID];
				}
			}
			
			return $page_list;
	}
}

?>