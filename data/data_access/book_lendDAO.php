<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	require_once '../../data/data_access/book_copyDAO.php';
	require_once '../../data/data_access/memberDAO.php';
	require_once '../../data/data_models/book_copy.php';
	require_once '../../data/data_models/lend.php';
	require_once '../../data/data_models/membership.php';
	
	class book_lendDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$lends = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$book_copyDao = new book_copyDAO();
					$memberDao = new memberDAO();
	
					$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
					$member = $memberDao->get_by_id($row["id_member"]);
					$lend = new book_lend($row["lend_date"],$row["return_date"],
							      $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM book_lend WHERE id_lend = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$book_copyDao = new book_copyDAO();
				$memberDao = new memberDAO();
	
				$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
				$member = $memberDao->get_by_id($row["id_member"]);
				$lend = new book_lend($row["lend_date"],$row["return_date"],
								     $book_copy, $member);
				$lend->set_id_lend($row["id_lend"]);
				return $lend;
			}
			return null;
		}
		
		public function get_by_book($book){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend INNER JOIN book_copy ON book_lend.id_book_copy = book_copy.id_book_copy WHERE id_book = ?";
			$statement = $connection->prepare($sql);
			$id_book = $book->get_id_book();
			$statement->bind_param("i",$id_book);
			$statement->execute();
			$results = $statement->get_result();
			 
			$lends = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$book_copyDao = new book_copyDAO();
					$memberDao = new memberDAO();
	
					$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
					$member = $memberDao->get_by_id($row["id_member"]);
					$lend = new book_lend($row["lend_date"],$row["return_date"],
							      $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function get_by_member($member){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend WHERE id_member = ?";
			$statement = $connection->prepare($sql);
			$id_member = $member->get_id_member();
			$statement->bind_param("i",$id_member);
			$statement->execute();
			$results = $statement->get_result();
			 
			$lends = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$book_copyDao = new book_copyDAO();
					$memberDao = new memberDAO();
	
					$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
					$member = $memberDao->get_by_id($row["id_member"]);
					$lend = new book_lend($row["lend_date"],$row["return_date"],
							      $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function get_by_user($user){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member WHERE member.id_user = ?";
			$statement = $connection->prepare($sql);
			$id_user = $user->get_id_user();
			$statement->bind_param("i",$id_user);
			$statement->execute();
			$results = $statement->get_result();
			 
			$lends = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$book_copyDao = new book_copyDAO();
					$memberDao = new memberDAO();
	
					$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
					$member = $memberDao->get_by_id($row["id_member"]);
					$lend = new book_lend($row["lend_date"],$row["return_date"],
							      $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}

		public function get_by_book_copy($book_copy){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend WHERE id_book_copy = ?";
			$statement = $connection->prepare($sql);
			$id_book_copy = $book_copy->get_id_book_copy();
			$statement->bind_param("i",$id_book_copy);
			$statement->execute();
			$results = $statement->get_result();
			 
			$lends = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$book_copyDao = new book_copyDAO();
					$memberDao = new memberDAO();
	
					$book_copy = $book_copyDao->get_by_id($row["id_book_copy"]);
					$member = $memberDao->get_by_id($row["id_member"]);
					$lend = new book_lend($row["lend_date"],$row["return_date"],
							      $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_id($object->get_id_lend());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO book_lend (lend_date, return_date, 
							       id_book_copy,id_member)
							       VALUES (?,?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$lend_date = $object->get_lend_date();
				$return_date = $object->get_return_date();
				$id_book_copy = $object->get_book_copy()->get_id_book_copy();
				$id_member = $object->get_member()->get_id_member();
				
				$statement->bind_param("ssii",$lend_date, $return_date,
								  $id_book_copy,$id_member);

				$lend_insert = $statement->execute();
				$book_copyDao = new book_copyDAO();
				$book_copy = $object->get_book_copy();
				$id_book_copy = $book_copy->get_id_book_copy();
				$new_book_copy = $book_copy;
				$new_book_copy->set_available(0);
				$copy_update = $book_copyDao->update($book_copy,$new_book_copy);

				return $lend_insert and $copy_update;
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_id($old_object->get_id_book_copy());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE book_copy SET lend_date = ?, return_date = ?, 
							     id_book_copy = ?, id_member = ?
							     WHERE id_book_copy = ?";
				$lend_date = $object->get_lend_date();
				$return_date = $object->get_return_date();
				$id_book_copy = $object->get_book_copy()->get_id_book_copy();
				$id_member = $object->get_member()->get_id_member();
				$id_lend = $db_object->get_id_lend();
				
				$statement->bind_param("ssiii",$lend_date, $return_date,
								  $id_book_copy,$id_member,$id_lend);
												   
				return $statement->execute();
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_lend());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM book_lend WHERE id_lend = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_book_lend();
				$statement->bind_param("i",$id);
				
				$lend_delete = $statement->execute();
				$book_copyDao = new book_copyDAO();
				$book_copy = $object->get_book_copy();
				$id_book_copy = $book_copy->get_id_book_copy();
				$new_book_copy = $book_copy;
				$new_book_copy->set_available(1);
				$copy_update = $book_copyDao->update($book_copy,$new_book_copy);

				return $lend_delete and $copy_update;
			}
			return false;
		}
	
	}
	
?>
