<?php 
	class member {
		protected $_id_member;
		protected $_member_phone;
		protected $_member_mobile;
		protected $_member_from;
		protected $_member_to;
		protected $_penality_points;
		protected $_notes;
		protected $_member_address;
		protected $_user;
		
		public function __construct ($member_phone, $member_mobile, $member_from, $member_to, $penality_points, $notes, $member_address, $user) {
			$this->_member_phone = $member_phone;
			$this->_member_mobile = $member_mobile;
			$this->_member_from = $member_from;
			$this->_member_to = $member_to;
			$this->_penality_points = $penality_points;
			$this->_notes = $notes;
			$this->_member_address = $member_address;	
			$this->_user = $user;
    		}
		
		public function set_id_member($id_member) {
			$this->_id_member = $id_member;
		}
		
   		public function get_id_member() {
			return $this->_id_member;
		}
		
		public function set_member_phone($member_phone) { 
			$this->_member_phone = $member_phone;  
 		}
 
   		public function get_member_phone() {
			return $this->_member_phone;
		}
		
		public function set_member_mobile($member_mobile) { 
			$this->_member_mobile = $member_mobile;  
 		}
 
   		public function get_member_mobile() {
			return $this->_member_mobile;
		}
		
		
		public function set_member_from($member_from) { 
			$this->_member_from = $member_from;  
 		}
 
   		public function get_member_from() {
			return $this->_member_from;
		}

		public function set_member_to($member_to) { 
			$this->_member_to = $member_to;  
 		}
 
   		public function get_member_to() {
			return $this->_member_to;
		}
		
		public function set_penality_points($penality_points) { 
			$this->_penality_points = $penality_points;  
 		}
 
    		public function get_penality_points() {
			return $this->_penality_points;
		}
		
		public function set_notes($notes) { 
			$this->_notes = $notes;  
 		}
 
    		public function get_notes() {
			return $this->_notes;
		}

		public function set_member_address($member_address) { 
			$this->_member_address = $member_address;  
 		}
 
   		public function get_member_address() {
			return $this->_member_address;
		}

		public function set_user($user) { 
			$this->_user = $user;  
 		}
 
    		public function get_user() {
			return $this->_user;
		}
		
	} 
?>
