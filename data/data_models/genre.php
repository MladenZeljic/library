<?php 
	class genre implements JsonSerializable {
		protected $_id_genre;
		protected $_genre_title;
		protected $_books;
		
		public function __construct ($genre_title) {
			$this->_genre_title = $genre_title;
			$this->_books = array();
    		}
		
		public function set_id_genre($id_genre) {
			$this->_id_genre = $id_genre;
		}
		
   		public function get_id_genre() {
			return $this->_id_genre;
		}
		
		public function set_genre_title($genre_title) { 
			$this->_genre_title = $genre_title;  
 		}
 
   		public function get_genre_title() {
			return $this->_genre_title;
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
		public function jsonSerialize() {
			return [
			'id_genre' => $this->get_id_genre(),
			'genre_title' => $this->get_genre_title()
			];
		}
		
	} 
?>
