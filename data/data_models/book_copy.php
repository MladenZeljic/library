<?php 
	class book_copy {
		protected $_id_book_copy;
		protected $_year_of_publication;
		protected $_number_of_pages;
		protected $_available;
		protected $_book;
		protected $_publisher;
		
		public function __construct ($year_of_publication, $number_of_pages, $available, $book, $publisher) {
			$this->_year_of_publication = $year_of_publication;
			$this->_number_of_pages = $number_of_pages;
			$this->_available = $available;
			$this->_book = $book;
			$this->_publisher = $publisher;
    		}

		public function set_id_book_copy($id_book_copy) {
			$this->_id_book_copy = $id_book_copy;
		}
		
   		public function get_id_book_copy() {
			return $this->_id_book_copy;
		}
		
		public function set_year_of_publication($year_of_publication) { 
			$this->_year_of_publication = $year_of_publication;  
 		}
 
   		public function get_year_of_publication() {
			return $this->_year_of_publication;
		}
		
		public function set_number_of_pages($number_of_pages) { 
			$this->_number_of_pages = $number_of_pages;  
 		}
		
		public function get_number_of_pages() {
			return $this->_number_of_pages;
		}
		
		public function set_available($available) { 
			$this->_available = $available;  
 		}
 
   		public function get_available() {
			return $this->_available;
		}
		
		public function set_book($book) { 
			$this->_book = $book;  
 		}
 
    		public function get_book() {
			return $this->_book;
		}
		
		public function set_publisher($publisher) { 
			$this->_publisher = $publisher;  
 		}
 
	    	public function get_publisher() {
			return $this->_publisher;
		}
		
	} 
?>
