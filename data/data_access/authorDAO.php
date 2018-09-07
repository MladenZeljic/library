<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	require_once '../../data/data_access/book_authorDAO.php';
	require_once '../../data/data_models/author.php';
	require_once '../../data/data_models/book.php';
	require_once '../../data/data_models/category.php';
	require_once '../../data/data_models/genre.php';
	
	class authorDAO extends connection implements query_interface {
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$author_sql = "SELECT * FROM author";
			$author_statement = $connection->prepare($author_sql);
			$author_statement->execute();
			$results = $author_statement->get_result();
			 
			$authors = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$author = new author($row["firstname"],$row["lastname"],$row["date_of_birth"],$row["short_biography"]);
					$author->set_id_author($row["id_author"]);
					$books_sql = "SELECT * FROM book INNER JOIN book_author ON book.id_book = book_author.id_book INNER JOIN category ON book.id_category = category.id_category WHERE book_author.id_author = ?";
					$book_statement = $connection->prepare($books_sql);
					$book_statement->bind_param("i",$row["id_author"]);				
					$book_statement->execute();
					$book_results = $book_statement->get_result();
					
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
										
							$author->add_book($book);
						}
					}

					array_push($authors,$author);
				}
			}
			return $authors;
		}

		public function get_by_id($id){
			
			$connection = $this->get_connection();
			$author_sql = "SELECT * FROM author WHERE id_author = ? ";
			$author_statement = $connection->prepare($author_sql);
			$author_statement->bind_param("i",$id);				
			$author_statement->execute();
			$result = $author_statement->get_result();
			 
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$author = new author($row["firstname"],$row["lastname"],$row["date_of_birth"],$row["short_biography"]);
				$author->set_id_author($row["id_author"]);
				$books_sql = "SELECT * FROM book INNER JOIN book_author ON book.id_book = book_author.id_book INNER JOIN category ON book.id_category = category.id_category WHERE book_author.id_author = ?";
				$book_statement = $connection->prepare($books_sql);
				$book_statement->bind_param("i",$row["id_author"]);				
				$book_statement->execute();
				$book_results = $book_statement->get_result();
					
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
										
						$author->add_book($book);
					}
				
				}
			
				return $author;
			}
			return null;
		}

		public function insert($object){
			$db_object = $this->get_by_id($object->get_id_author());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$author_sql = "INSERT INTO author (firstname,lastname,date_of_birth,short_biography)
					       VALUES (?,?,?,?)";
				$author_statement = $connection->prepare($author_sql);
				
				//bind_param accepts only variables
				$firstname = $object->get_firstname();
				$lastname = $object->get_lastname();
				$date_of_birth = $object->get_date_of_birth();
				$biography = $object->get_short_biography();
				$author_books = $object->get_books();
				
				$author_statement->bind_param("ssss",$firstname,$lastname,$date_of_birth,$biography);
				$author_insert = $author_statement->execute();
				
				$id_author = mysqli_insert_id($connection);
				$book_authorDao = new book_authorDAO();
				$book_insert = TRUE;
				foreach($author_books as $author_book){
					$id_book = $author_book->get_id_book();
					if(!$book_authorDao->book_author_exists($id_book, $id_author)){
						$book_author_sql = "INSERT INTO book_author (id_book,id_author)
							     	    VALUES (?,?)";
						$book_author_statement = $connection->prepare($book_author_sql);
						$book_author_statement->bind_param("ii",$id_book,$id_author);
						$book_insert = ($book_insert and $book_author_statement->execute());
					}
				}
				return $author_insert and $book_insert;
			}
			return false;
			
		}
		
		public function update($old_object, $new_object){
			$db_object = $this->get_by_id($old_object->get_id_author());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$author_books_delete_sql = "DELETE FROM book_author WHERE id_author = ?";
				$author_books_delete_statement = $connection->prepare($author_books_delete_sql);
				$author_delete_id = $db_object->get_id_author();
				$author_books_delete_statement->bind_param("i",$author_delete_id);
				$author_books_delete = $author_books_delete_statement->execute();
								
				$author_sql = "UPDATE author SET firstname = ?,lastname = ?,date_of_birth = ?,short_biography = ?
					       WHERE id_author = ?";
				$author_statement = $connection->prepare($author_sql);
				
				//bind_param accepts only variables
				$firstname = $new_object->get_firstname();
				$lastname = $new_object->get_lastname();
				$date_of_birth = $new_object->get_date_of_birth();
				$biography = $new_object->get_short_biography();
				$id_author = $db_object->get_id_author();
				$author_books = $new_object->get_books();
				
				$author_statement->bind_param("ssssi",$firstname,$lastname,$date_of_birth,$biography,$id_author);
				$author_update = $author_statement->execute();
				
				$book_authorDao = new book_authorDAO();
				$book_insert = TRUE;
				echo count($author_books);
				foreach($author_books as $author_book){
					$id_book = $author_book->get_id_book();
					$book_author_sql = "INSERT INTO book_author (id_author,id_book)
							     	    VALUES (?,?)";
					$book_author_statement = $connection->prepare($book_author_sql);
					$book_author_statement->bind_param("ii",$id_author,$id_book);
					$book_insert = ($book_insert and $book_author_statement->execute());
					echo $book_insert;
					
				}
				return $author_books_delete and $author_update and $book_insert;
			}
			return false;
			
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_author());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM author WHERE id_author = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_author();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;		
			
		}
	
	}
	
?>
