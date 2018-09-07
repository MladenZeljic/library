<?php 
	class book_lend {
		protected $_id_lend;
		protected $_lend_date;
		protected $_return_date;
		protected $_book_copy;
		protected $_member;
		
		public function __construct ($lend_date, $return_date, $book_copy, $member) {
			$this->_lend_date = $lend_date;
			$this->_return_date = $return_date;
			$this->_book_copy = $book_copy;
			$this->_member = $member;
    		}
		
		public function set_id_lend($id_lend) {
			$this->_id_lend = $id_lend;
		}
		
   		public function get_id_lend() {
			return $this->_id_lend;
		}
		
		public function set_lend_date($lend_date) { 
			$this->_lend_date = $lend_date;  
 		}
 
   		public function get_lend_date() {
			return $this->_lend_date;
		}

		public function set_return_date($return_date) { 
			$this->_return_date = $return_date;  
 		}
 
   		public function get_return_date() {
			return $this->_return_date;
		}
		
		public function set_book_copy($book_copy) { 
			$this->_book_copy = $book_copy;  
 		}
 
    		public function get_book_copy() {
			return $this->_book_copy;
		}

		public function set_member($member) { 
			$this->_member = $member;  
 		}
 
    		public function get_member() {
			return $this->_member;
		}
		
	} 
?>
