<?php 
	class author {
		protected $_id_author;
		protected $_firstname;
		protected $_lastname;
		protected $_date_of_birth;
		protected $_short_biography;
		protected $_books;
		
		public function __construct ($firstname, $lastname, $date_of_birth, $short_biography) {
			$this->_firstname = $firstname;
			$this->_lastname = $lastname;
			$this->_date_of_birth = $date_of_birth;
			$this->_short_biography = $short_biography;
			$this->_books = array();
    		}

		public function set_id_author($id_author) {
			$this->_id_author = $id_author;
		}
		
   		public function get_id_author() {
			return $this->_id_author;
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
		
		public function set_short_biography($short_biography) { 
			$this->_short_biography = $short_biography;  
 		}
		
		public function get_short_biography() {
			return $this->_short_biography;
		}
		
		public function set_books($books){
			$this->_books = $books;
		}
		
		public function get_books(){
			return $this->_books;
		}

		public function add_book($book){
			array_push($this->_books, $book);
		}
		
		public function remove_book(){
			return array_pop($this->_books);
		}
		
	} 
?>
