<?php 
	class publisher {
		protected $_id_publisher;
		protected $_publisher_name;
		protected $_publisher_address;
		
		public function __construct ($publisher_name, $publisher_address) {
			$this->_publisher_name = $publisher_name;
			$this->_publisher_address = $publisher_address;
    		}

		public function set_id_publisher($id_publisher) {
			$this->_id_publisher = $id_publisher;
		}
		
   		public function get_id_publisher() {
			return $this->_id_publisher;
		}
		
		public function set_publisher_name($publisher_name) { 
			$this->_publisher_name = $publisher_name;  
 		}
 
   		public function get_publisher_name() {
			return $this->_publisher_name;
		}
		
		public function set_publisher_address($publisher_address) { 
			$this->_publisher_address = $publisher_address;  
 		}
 
    		public function get_publisher_address() {
			return $this->_publisher_address;
		}
		
	} 
?>
