<?php 
	class book {
		protected $_id_book;
		protected $_book_title;
		protected $_original_book_title;
		protected $_authors;
		protected $_category;
		protected $_genres;
		
		public function __construct ($book_title, $original_book_title, $category) {
			$this->_book_title = $book_title;
			$this->_original_book_title = $original_book_title;
			$this->_authors = array();
			$this->_category = $category;
			$this->_genres = array();
    		}
		
   		public function set_id_book($id_book) {
			$this->_id_book = $id_book;
		}
		
   		public function get_id_book() {
			return $this->_id_book;
		}
		
		public function set_book_title($book_title) { 
			$this->_book_title = $book_title;  
 		}
 
   		public function get_book_title() {
			return $this->_book_title;
		}
		
		public function set_original_book_title($original_book_title) { 
			$this->_original_book_title = $original_book_title;  
 		}
 
   		public function get_original_book_title() {
			return $this->_original_book_title;
		}
		

		public function set_authors($authors){
			$this->_authors = $authors;		
		}
		
		public function get_authors(){
			return $this->_authors;
		}
		
		public function add_author($author){
			array_push($this->_authors,$author);
		}

		public function remove_author(){
			return array_pop($this->_authors);
		}
		
		public function set_category($category){
			$this->_category = $category;		
		}
		
		public function get_category(){
			return $this->_category;
		}

		public function set_genres($genres){
			$this->_genres = $genres;		
		}
		
		public function get_genres(){
			return $this->_genres;
		}
		
		public function add_genre($genre){
			array_push($this->_genres,$genre);
		}

		public function remove_genre(){
			return array_pop($this->_genres);
		}
		
	} 
?>
