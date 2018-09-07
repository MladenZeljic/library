<?php 
	class person {
		protected $_name; 
		
		public function __construct ($name) {
			$this->_name = $name;
    	}
		
		function set_name($name) { 
			$this->_name = $name;  
 		}
 
   		function get_name() {
			return $this->_name;
		}
	} 
?>