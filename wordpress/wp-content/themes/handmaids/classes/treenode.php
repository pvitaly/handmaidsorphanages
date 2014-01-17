<?php
/**
A simple class representing a node in a tree.
*/

class TreeNode {
		public $node;
		
		public $children; 
		
		public function __construct($nodeArg, $childrenArg = null){
			$this->node = $nodeArg;
			
			$this->children = array();
			if (is_array($childrenArg)){
				$this->children = array_merge($this->children, $childrenArg);
			}
		}
		
		/**
		Returns true if the array has any children. Otherwise returns false.
		*/
		public function has_children(){
			return is_array($this->children) && ! empty($this->children);
		}
}

?>