<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_access/book_genreDAO.php';
	require_once __DIR__.'/../../data/data_models/author.php';	
	require_once __DIR__.'/../../data/data_models/book.php';	
	require_once __DIR__.'/../../data/data_models/category.php';
	require_once __DIR__.'/../../data/data_models/genre.php';
	
	class bookDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$book_sql = "SELECT * FROM book INNER JOIN category ON book.id_category = category.id_category";
			$book_statement = $connection->prepare($book_sql);
			$book_statement->execute();
			$book_results = $book_statement->get_result();
			 
			$books = array();
			
			if ($book_results->num_rows > 0) {
				while($book_row = $book_results->fetch_assoc()) {
					$category = new category($book_row["category_title"]);
					$category->set_id_category($book_row["id_category"]);
					$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
					$book->set_id_book($book_row["id_book"]);
					
					$genres_sql = "SELECT * FROM genre INNER JOIN book_genre ON genre.id_genre = book_genre.id_genre INNER JOIN book ON book.id_book = book_genre.id_book WHERE book.id_book = ?";
					$genre_statement = $connection->prepare($genres_sql);
					$genre_statement->bind_param("i",$book_row["id_book"]);				
					$genre_statement->execute();
					$genre_results = $genre_statement->get_result();
					
					if ($genre_results->num_rows > 0) {
						while($genre_row = $genre_results->fetch_assoc()) {
							$genre = new genre($genre_row["genre_title"]);
							$genre->set_id_genre($genre_row["id_genre"]);
							$book->add_genre($genre);
						}
					}
					
					$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author WHERE book_author.id_book = ?";
					$author_statement = $connection->prepare($author_sql);
					$author_statement->bind_param("i",$book_row["id_book"]);				
					$author_statement->execute();
					$author_results = $author_statement->get_result();
					if ($author_results->num_rows > 0) {
						while($author_row = $author_results->fetch_assoc()) {
							$author = new author($author_row["firstname"],$author_row["lastname"],$author_row["date_of_birth"],$author_row["short_biography"]);
							$author->set_id_author($author_row["id_author"]);
							$book->add_author($author);
						}
					}
					array_push($books,$book);
				}
			}
			return $books;
		}
		
		public function get_range($from, $limit){
			
			$connection = $this->get_connection();
			$book_sql = "SELECT * FROM book INNER JOIN category ON book.id_category = category.id_category LIMIT ?,?";
			$book_statement = $connection->prepare($book_sql);
			$book_statement->bind_param("ii",$from, $limit);
			$book_statement->execute();
			$book_results = $book_statement->get_result();
			 
			$books = array();
			
			if ($book_results->num_rows > 0) {
				while($book_row = $book_results->fetch_assoc()) {
					$category = new category($book_row["category_title"]);
					$category->set_id_category($book_row["id_category"]);
					$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
					$book->set_id_book($book_row["id_book"]);
					
					$genres_sql = "SELECT * FROM genre INNER JOIN book_genre ON genre.id_genre = book_genre.id_genre INNER JOIN book ON book.id_book = book_genre.id_book WHERE book.id_book = ?";
					$genre_statement = $connection->prepare($genres_sql);
					$genre_statement->bind_param("i",$book_row["id_book"]);				
					$genre_statement->execute();
					$genre_results = $genre_statement->get_result();
					
					if ($genre_results->num_rows > 0) {
						while($genre_row = $genre_results->fetch_assoc()) {
							$genre = new genre($genre_row["genre_title"]);
							$genre->set_id_genre($genre_row["id_genre"]);
							$book->add_genre($genre);
						}
					}
					
					$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author WHERE book_author.id_book = ?";
					$author_statement = $connection->prepare($author_sql);
					$author_statement->bind_param("i",$book_row["id_book"]);				
					$author_statement->execute();
					$author_results = $author_statement->get_result();
					if ($author_results->num_rows > 0) {
						while($author_row = $author_results->fetch_assoc()) {
							$author = new author($author_row["firstname"],$author_row["lastname"],$author_row["date_of_birth"],$author_row["short_biography"]);
							$author->set_id_author($author_row["id_author"]);
							$book->add_author($author);
						}
					}
					array_push($books,$book);
				}
			}
			return $books;
		}

		public function get_by_title_in_range($title,$from, $limit){
			
			$connection = $this->get_connection();
			$book_sql = "SELECT * FROM book INNER JOIN category ON book.id_category = category.id_category WHERE book.book_title LIKE ? LIMIT ?,?";
			$book_statement = $connection->prepare($book_sql);
			$like = "%".$title."%";
			$book_statement->bind_param("sii",$like,$from, $limit);
			$book_statement->execute();
			$book_results = $book_statement->get_result();
			 
			$books = array();
			
			if ($book_results->num_rows > 0) {
				while($book_row = $book_results->fetch_assoc()) {
					$category = new category($book_row["category_title"]);
					$category->set_id_category($book_row["id_category"]);
					$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
					$book->set_id_book($book_row["id_book"]);
					
					$genres_sql = "SELECT * FROM genre INNER JOIN book_genre ON genre.id_genre = book_genre.id_genre INNER JOIN book ON book.id_book = book_genre.id_book WHERE book.id_book = ?";
					$genre_statement = $connection->prepare($genres_sql);
					$genre_statement->bind_param("i",$book_row["id_book"]);				
					$genre_statement->execute();
					$genre_results = $genre_statement->get_result();
					
					if ($genre_results->num_rows > 0) {
						while($genre_row = $genre_results->fetch_assoc()) {
							$genre = new genre($genre_row["genre_title"]);
							$genre->set_id_genre($genre_row["id_genre"]);
							$book->add_genre($genre);
						}
					}
					
					$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author WHERE book_author.id_book = ?";
					$author_statement = $connection->prepare($author_sql);
					$author_statement->bind_param("i",$book_row["id_book"]);				
					$author_statement->execute();
					$author_results = $author_statement->get_result();
					if ($author_results->num_rows > 0) {
						while($author_row = $author_results->fetch_assoc()) {
							$author = new author($author_row["firstname"],$author_row["lastname"],$author_row["date_of_birth"],$author_row["short_biography"]);
							$author->set_id_author($author_row["id_author"]);
							$book->add_author($author);
						}
					}
					array_push($books,$book);
				}
			}
			return $books;
		}
		
		public function count_by_title($title){
			
			$connection = $this->get_connection();
			$book_sql = "SELECT COUNT(*) FROM book INNER JOIN category ON book.id_category = category.id_category WHERE book.book_title LIKE ?";
			$book_statement = $connection->prepare($book_sql);
			$like = "%".$title."%";
			$book_statement->bind_param("s",$like);
			$book_statement->execute();
			$count_result = $book_statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$book_sql = "SELECT * FROM book INNER JOIN category ON book.id_category = category.id_category WHERE id_book = ? ";
			
			$statement = $connection->prepare($book_sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$book_result = $statement->get_result();
			
			if ($book_result->num_rows == 1) {
				$book_row = $book_result->fetch_assoc();
				
				$category = new category($book_row["category_title"]);
					$category->set_id_category($book_row["id_category"]);
					$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
					$book->set_id_book($book_row["id_book"]);
					
					$genres_sql = "SELECT * FROM genre INNER JOIN book_genre ON genre.id_genre = book_genre.id_genre INNER JOIN book ON book.id_book = book_genre.id_book WHERE book.id_book = ?";
					$genre_statement = $connection->prepare($genres_sql);
					$genre_statement->bind_param("i",$book_row["id_book"]);				
					$genre_statement->execute();
					$genre_results = $genre_statement->get_result();
					
					if ($genre_results->num_rows > 0) {
						while($genre_row = $genre_results->fetch_assoc()) {
							$genre = new genre($genre_row["genre_title"]);
							$genre->set_id_genre($genre_row["id_genre"]);
							$book->add_genre($genre);
						}
					}
					
					$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author WHERE book_author.id_book = ?";
					$author_statement = $connection->prepare($author_sql);
					$author_statement->bind_param("i",$book_row["id_book"]);				
					$author_statement->execute();
					$author_results = $author_statement->get_result();
					if ($author_results->num_rows > 0) {
						while($author_row = $author_results->fetch_assoc()) {
							$author = new author($author_row["firstname"],$author_row["lastname"],$author_row["date_of_birth"],$author_row["short_biography"]);
							$author->set_id_author($author_row["id_author"]);
							$book->add_author($author);
						}
					}
					return $book;
			}
			return null;
		}
		
		public function insert($object){
			$db_object = $this->get_by_id($object->get_id_book());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$book_sql = "INSERT INTO book (book_title,original_book_title,id_category)
					       VALUES (?,?,?)";
				$book_statement = $connection->prepare($book_sql);
				
				//bind_param accepts only variables
				$book_title = $object->get_book_title();
				$original_book_title = $object->get_original_book_title();
				$id_category = $object->get_category()->get_id_category();
				$book_authors = $object->get_authors();
				$book_genres = $object->get_genres();
				
				$book_statement->bind_param("ssi",$book_title,$original_book_title,$id_category);
				$book_insert = $book_statement->execute();
				
				$id_book = mysqli_insert_id($connection);
				$book_authorDao = new book_authorDAO();
				$author_insert = TRUE;
				foreach($book_authors as $book_author){
					$id_author = $book_author->get_id_author();
					if(!$book_authorDao->book_author_exists($id_book, $id_author)){
						$book_author_sql = "INSERT INTO book_author (id_book,id_author)
							     	    VALUES (?,?)";
						$book_author_statement = $connection->prepare($book_author_sql);
						$book_author_statement->bind_param("ii",$id_book,$id_author);
						$author_insert = ($author_insert and $book_author_statement->execute());
					}
				}
				$book_genreDao = new book_genreDAO();
				$genre_insert = TRUE;
				foreach($book_genres as $book_genre){
					$id_genre = $book_genre->get_id_genre();
					if(!$book_genreDao->book_genre_exists($id_book, $id_genre)){
						$book_genre_sql = "INSERT INTO book_genre (id_book,id_genre)
							     	    VALUES (?,?)";
						$book_genre_statement = $connection->prepare($book_genre_sql);
						$book_genre_statement->bind_param("ii",$id_book,$id_genre);
						$genre_insert = ($genre_insert and $book_genre_statement->execute());
					}
				}
				

				return $author_insert and $book_insert and $genre_insert;
			}
			return false;
			
		}
		
		public function update($old_object, $new_object){
			$db_object = $this->get_by_id($old_object->get_id_book());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$book_authors_delete_sql = "DELETE FROM book_author WHERE id_book = ?";
				$book_authors_delete_statement = $connection->prepare($book_authors_delete_sql);
				$book_delete_id = $db_object->get_id_book();
				$book_authors_delete_statement->bind_param("i",$book_delete_id);
				$book_authors_delete = $book_authors_delete_statement->execute();
				
				$book_genres_delete_sql = "DELETE FROM book_genre WHERE id_book = ?";
				$book_genres_delete_statement = $connection->prepare($book_genres_delete_sql);
				$book_genres_delete_statement->bind_param("i",$book_delete_id);
				$book_genres_delete = $book_genres_delete_statement->execute();
								
				$book_sql = "UPDATE book SET book_title = ?, original_book_title = ?, id_category = ?
					     WHERE id_book = ?";
				$book_statement = $connection->prepare($book_sql);
				
				//bind_param accepts only variables
				$book_title = $new_object->get_book_title();
				$original_book_title = $new_object->get_original_book_title();
				$id_category = ($new_object->get_category())->get_id_category();
				
				$id_book = $db_object->get_id_book();
				$book_genres = $new_object->get_genres();
				$book_authors = $new_object->get_authors();
				
				$book_statement->bind_param("ssii",$book_title,$original_book_title,$id_category,$id_book);
				$book_update = $book_statement->execute();
				
				$author_insert = TRUE;
				
				foreach($book_authors as $book_author){
					$id_author = $book_author->get_id_author();
					$author_book_sql = "INSERT INTO book_author (id_author,id_book)
							     	    VALUES (?,?)";
					$author_book_statement = $connection->prepare($author_book_sql);
					$author_book_statement->bind_param("ii",$id_author,$id_book);
					$author_insert = ($author_insert and $author_book_statement->execute());
					
					
				}
				$genre_insert = TRUE;
				
				foreach($book_genres as $book_genre){
					$id_genre = $book_genre->get_id_genre();
					$genre_book_sql = "INSERT INTO book_genre (id_genre,id_book)
							     	    VALUES (?,?)";
					$genre_book_statement = $connection->prepare($genre_book_sql);
					$genre_book_statement->bind_param("ii",$id_genre,$id_book);
					$genre_insert = ($genre_insert and $genre_book_statement->execute());
					
					
				}
				return $book_authors_delete and $book_genres_delete and $book_update and $author_insert and $genre_insert;
			}
			return false;			
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_book());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM book WHERE id_book = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_book();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
