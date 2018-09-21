<?php 
	class role {
		protected $_id_role;
		protected $_role_title;
		
		public function __construct ($role_title) {
			$this->_role_title = $role_title;
    		}
		
		public function set_id_role($id_role) {
			$this->_id_role = $id_role;
		}
		
   		public function get_id_role() {
			return $this->_id_role;
		}
		
		public function set_role_title($role_title) { 
			$this->_role_title = $role_title;  
 		}
 
   		public function get_role_title() {
			return $this->_role_title;
		}
		
	} 
?>
