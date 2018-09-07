<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	require_once '../../data/data_access/bookDAO.php';
	require_once '../../data/data_access/publisherDAO.php';
	require_once '../../data/data_models/book.php';
	require_once '../../data/data_models/book_copy.php';
	require_once '../../data/data_models/publisher.php';
	
	class book_copyDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_copy";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$book_copies = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$bookDao = new bookDAO();
					$publisherDao = new publisherDAO();
	
					$book = $bookDao->get_by_id($row["id_book"]);
					$publisher = $publisherDao->get_by_id($row["id_publisher"]);
					$book_copy = new book_copy($row["year_of_publication"],$row["number_of_pages"],
								   $row["available"], $book, $publisher);
					$book_copy->set_id_book_copy($row["id_book_copy"]);
					array_push($book_copies,$book_copy);
				}
			}
			return $book_copies;
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM book_copy WHERE id_book_copy = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$bookDao = new bookDAO();
				$publisherDao = new publisherDAO();
	
				$book = $bookDao->get_by_id($row["id_book"]);
				$publisher = $publisherDao->get_by_id($row["id_publisher"]);
				$book_copy = new book_copy($row["year_of_publication"],$row["number_of_pages"],
							   $row["available"], $book, $publisher);
				$book_copy->set_id_book_copy($row["id_book_copy"]);
				return $book_copy;
			}
			return null;
		}
		
		public function get_by_book($book){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_copy WHERE id_book = ?";
			$statement = $connection->prepare($sql);
			$id_book = $book->get_id_book();
			$statement->bind_param("i",$id_book);
			$statement->execute();
			$results = $statement->get_result();
			 
			$book_copies = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$bookDao = new bookDAO();
					$publisherDao = new publisherDAO();
	
					$book = $bookDao->get_by_id($row["id_book"]);
					$publisher = $publisherDao->get_by_id($row["id_publisher"]);
					$book_copy = new book_copy($row["year_of_publication"],$row["number_of_pages"],
								   $row["available"], $book, $publisher);
					$book_copy->set_id_book_copy($row["id_book_copy"]);
					array_push($book_copies,$book_copy);
				}
			}
			return $book_copies;
		}

		public function get_non_lended_copies(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_copy WHERE available = 1";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$book_copies = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$bookDao = new bookDAO();
					$publisherDao = new publisherDAO();
	
					$book = $bookDao->get_by_id($row["id_book"]);
					$publisher = $publisherDao->get_by_id($row["id_publisher"]);
					$book_copy = new book_copy($row["year_of_publication"],$row["number_of_pages"],
								   $row["available"], $book, $publisher);
					$book_copy->set_id_book_copy($row["id_book_copy"]);
					array_push($book_copies,$book_copy);
				}
			}
			return $book_copies;
		}

		public function get_by_publisher($publisher){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_copy WHERE id_publisher = ?";
			$statement = $connection->prepare($sql);
			$id_publisher = $publisher->get_id_publisher();
			$statement->bind_param("i",$id_publisher);
			$statement->execute();
			$results = $statement->get_result();
			 
			$book_copies = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$bookDao = new bookDAO();
					$publisherDao = new publisherDAO();
	
					$book = $bookDao->get_by_id($row["id_book"]);
					$publisher = $publisherDao->get_by_id($row["id_publisher"]);
					$book_copy = new book_copy($row["year_of_publication"],$row["number_of_pages"],
								   $row["available"], $book, $publisher);
					$book_copy->set_id_book_copy($row["id_book_copy"]);
					array_push($book_copies,$book_copy);
				}
			}
			return $book_copies;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_id($object->get_id_book_copy());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO book_copy (year_of_publication, number_of_pages, available, 
							       id_book,id_publisher)
							       VALUES (?,?,?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$year_of_publication = $object->get_year_of_publication();
				$number_of_pages = $object->get_number_of_pages();
				$available = $object->get_available();
				$id_book = $object->get_book()->get_id_book();
				$id_publisher = $object->get_publisher()->get_id_publisher();
				
				$statement->bind_param("siiii",$year_of_publication, $number_of_pages, $available,
								  $id_book,$id_publisher);
			
				return $statement->execute();
			}
			return false;
			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_id($old_object->get_id_book_copy());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE book_copy SET year_of_publication = ?, number_of_pages = ?, available = ?, 
							     id_book = ?, id_publisher = ?
							     WHERE id_book_copy = ?";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$year_of_publication = $new_object->get_year_of_publication();
				$number_of_pages = $new_object->get_number_of_pages();
				$available = $new_object->get_available();
				$id_book = $new_object->get_book()->get_id_book();
				$id_publisher = $new_object->get_publisher()->get_id_publisher();
				$id_book_copy = $db_object->get_id_book_copy();
				
				$statement->bind_param("siiiii",$year_of_publication, $number_of_pages, $available,
							       $id_book,$id_publisher,$id_book_copy);
												   
				return $statement->execute();
			}
			return false;	
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_book_copy());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM book_copy WHERE id_book_copy = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_book_copy();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
