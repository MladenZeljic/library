<?php 
	class category {
		protected $_id_category;
		protected $_category_title;
		
		public function __construct ($category_title) {
			$this->_category_title = $category_title;
    	}
		
		public function set_id_category($id_category) {
			$this->_id_category = $id_category;
		}
		
   		public function get_id_category() {
			return $this->_id_category;
		}
		
		public function set_category_title($category_title) { 
			$this->_category_title = $category_title;  
 		}
 
   		public function get_category_title() {
			return $this->_category_title;
		}
		
	} 
?>