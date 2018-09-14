<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_access/book_genreDAO.php';
	
	class genreDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$genre_sql = "SELECT * FROM genre";
			$genre_statement = $connection->prepare($genre_sql);
			$genre_statement->execute();
			$results = $genre_statement->get_result();
			 
			$genres = array();
			
			if ($results->num_rows > 0) {
				while($genre_row = $results->fetch_assoc()) {
					
					$genre = new genre($genre_row["genre_title"]);
					$genre->set_id_genre($genre_row["id_genre"]);
					$books_sql = "SELECT * FROM book INNER JOIN book_genre ON book.id_book = book_genre.id_book INNER JOIN category ON book.id_category = category.id_category WHERE book_genre.id_genre = ?";
					$book_statement = $connection->prepare($books_sql);
					$book_statement->bind_param("i",$genre_row["id_genre"]);				
					$book_statement->execute();
					$book_results = $book_statement->get_result();
					echo $book_results->num_rows;
					if ($book_results->num_rows > 0) {
						while($book_row = $book_results->fetch_assoc()) {
							$category = new category($book_row["category_title"]);
							$category->set_id_category($book_row["id_category"]);
							$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
							$book->set_id_book($book_row["id_book"]);				
							$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author INNER JOIN book ON book.id_book = book_author.id_book WHERE book.id_book = ?";
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
										
							$genre->add_book($book);
						}
					}

					array_push($genres,$genre);
				}
			}
			return $genres;

		}
		
		public function get_by_id($id){
			$connection = $this->get_connection();
			$genre_sql = "SELECT * FROM genre WHERE id_genre = ?";
			$genre_statement = $connection->prepare($genre_sql);
			$genre_statement->bind_param("i",$id);
			$genre_statement->execute();
			$results = $genre_statement->get_result();
			 
			$genres = array();
			
			if ($results->num_rows > 0) {
			
				$genre_row = $results->fetch_assoc();
					
				$genre = new genre($genre_row["genre_title"]);
				$genre->set_id_genre($genre_row["id_genre"]);
				$books_sql = "SELECT * FROM book INNER JOIN book_genre ON book.id_book = book_genre.id_book INNER JOIN category ON book.id_category = category.id_category WHERE book_genre.id_genre = ?";
				$book_statement = $connection->prepare($books_sql);
				$book_statement->bind_param("i",$genre_row["id_genre"]);				
				$book_statement->execute();
				$book_results = $book_statement->get_result();
				if ($book_results->num_rows > 0) {
					while($book_row = $book_results->fetch_assoc()) {
						$category = new category($book_row["category_title"]);
						$category->set_id_category($book_row["id_category"]);
						$book = new book($book_row["book_title"], $book_row["original_book_title"], $category);
						$book->set_id_book($book_row["id_book"]);				
						$author_sql = "SELECT * FROM author INNER JOIN book_author ON author.id_author = book_author.id_author INNER JOIN book ON book.id_book = book_author.id_book WHERE book.id_book = ?";
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
										
						$genre->add_book($book);
					}
				}

				return $genre;
		
			}
			return null;
		}
		
		public function insert($object){
			$db_object = $this->get_by_id($object->get_id_genre());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$genre_sql = "INSERT INTO genre (genre_title)
					       VALUES (?)";
				$genre_statement = $connection->prepare($genre_sql);
				
				//bind_param accepts only variables
				$genre_title = $object->get_genre_title();
				$genre_books = $object->get_books();
				$genre_statement->bind_param("s",$genre_title);
				$genre_insert = $genre_statement->execute();
				
				$id_genre = mysqli_insert_id($connection);
				$book_genreDao = new book_genreDAO();
				$book_insert = TRUE;
				foreach($genre_books as $genre_book){
					$id_book = $genre_book->get_id_book();
					if(!$book_genreDao->book_genre_exists($id_book, $id_genre)){
						$book_genre_sql = "INSERT INTO book_genre (id_book,id_genre)
							 	   VALUES (?,?)";
						$book_genre_statement = $connection->prepare($book_genre_sql);
						$book_genre_statement->bind_param("ii",$id_book,$id_genre);
						$book_insert = ($book_insert and $book_genre_statement->execute());
					}
				}
				return $genre_insert and $book_insert;
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			$db_object = $this->get_by_id($old_object->get_id_genre());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$genre_books_delete_sql = "DELETE FROM book_genre WHERE id_genre = ?";
				$genre_books_delete_statement = $connection->prepare($genre_books_delete_sql);
				$genre_delete_id = $db_object->get_id_genre();
				$genre_books_delete_statement->bind_param("i",$genre_delete_id);
				$genre_books_delete = $genre_books_delete_statement->execute();
								
				$genre_sql = "UPDATE genre SET genre_title = ?
					      WHERE id_genre = ?";
				$genre_statement = $connection->prepare($genre_sql);
				
				//bind_param accepts only variables
				$genre_title = $new_object->get_genre_title();
				$id_genre = $db_object->get_id_genre();

				$genre_statement->bind_param("si",$genre_title,$id_genre);
				$genre_update = $genre_statement->execute();
				$genre_books = $new_object->get_books();

				$book_genreDao = new book_genreDAO();
				$book_insert = TRUE;
				echo count($genre_books);
				foreach($genre_books as $genre_book){
					$id_book = $genre_book->get_id_book();
					$book_genre_sql = "INSERT INTO book_genre (id_genre,id_book)
							   VALUES (?,?)";
					$book_genre_statement = $connection->prepare($book_genre_sql);
					$book_genre_statement->bind_param("ii",$id_genre,$id_book);
					$book_insert = ($book_insert and $book_genre_statement->execute());
					
					
				}
				return $genre_books_delete and $genre_update and $book_insert;
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_genre());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM genre WHERE id_genre = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_genre();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;

		}
	
	}
	
?>
