<?php 
	class user {
		protected $_id_user;
		protected $_firstname;
		protected $_lastname;
		protected $_date_of_birth;
		protected $_e_mail;
		protected $_username;
		protected $_password;
		protected $_approval;
		protected $_admin;
		protected $_status;
		
		public function __construct ($firstname, $lastname, $date_of_birth, $e_mail, $username, $password, $approval, $admin, $status) {
			$this->_firstname = $firstname;
			$this->_lastname = $lastname;
			$this->_date_of_birth = $date_of_birth;
			$this->_e_mail = $e_mail;			
			$this->_username = $username;
			$this->_password = $password;
			$this->_approval = $approval;
			$this->_admin = $admin;
			$this->_status = $status;
    		}

   		public function set_id_user($id_user) {
			$this->_id_user = $id_user;
		}
		
   		public function get_id_user() {
			return $this->_id_user;
		}
		
		public function set_firstname($firstname) { 
			$this->_firstname = $firstname;  
 		}
 
   		public function get_firstname() {
			return $this->_firstname;
		}
		
		public function set_lastname($lastname) { 
			$this->_lastname = $lastname;  
 		}
 
   		public function get_lastname() {
			return $this->_lastname;
		}
		
		public function set_date_of_birth($date_of_birth) { 
			$this->_date_of_birth = $date_of_birth;  
 		}
 
   		public function get_date_of_birth() {
			return $this->_date_of_birth;
		}

		public function set_e_mail($e_mail) { 
			$this->_e_mail = $e_mail;  
 		}
		
		public function get_e_mail() {
			return $this->_e_mail;
		}
		
		public function set_username($username) { 
			$this->_username = $username;  
 		}
		
		public function get_username() {
			return $this->_username;
		}
		
		public function set_password($password) { 
			$this->_password = $password;  
 		}
		
		public function get_password() {
			return $this->_password;
		}
		
		public function set_approval($approval) { 
			$this->_approval = $approval;  
 		}
		
		public function get_approval() {
			return $this->_approval;
		}
		
		public function set_admin($admin) { 
			$this->_admin = $admin;  
 		}
		
		public function get_admin() {
			return $this->_admin;
		}
		
		public function set_status($status) { 
			$this->_status = $status;  
 		}
		
		public function get_status() {
			return $this->_status;
		}
		
	} 
?>
