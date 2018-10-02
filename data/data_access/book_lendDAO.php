<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_access/book_copyDAO.php';
	require_once __DIR__.'/../../data/data_access/memberDAO.php';
	require_once __DIR__.'/../../data/data_models/book_copy.php';
	require_once __DIR__.'/../../data/data_models/lend.php';
	require_once __DIR__.'/../../data/data_models/membership.php';
	
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		public function get_all_with_user($user){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member WHERE member.id_user = ? AND book_lend.approved = 1 ";
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		public function get_in_range($from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend  ORDER BY approved LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("ii",$from, $limit);
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}

		public function get_by_name_in_range($name,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member INNER JOIN user ON user.id_user = member.id_user WHERE user.firstname LIKE ? OR user.lastname LIKE ? ORDER BY approved LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$name."%";
			$statement->bind_param("ssii",$like,$like, $from, $limit);
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function count_by_name($name){
			$connection = $this->get_connection();
			$book_lend_sql = "SELECT COUNT(*) FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member INNER JOIN user ON user.id_user = member.id_user WHERE user.firstname LIKE ? OR user.lastname LIKE ?";
			$book_lend_statement = $connection->prepare($book_lend_sql);
			$like = "%".$name."%";
			$book_lend_statement->bind_param("ss",$like,$like);
			$book_lend_statement->execute();
			$count_result = $book_lend_statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];
		}
		
		public function count_by_member($member){
			$connection = $this->get_connection();
			$book_lend_sql = "SELECT COUNT(*) FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member INNER JOIN user ON user.id_user = member.id_user WHERE user.username LIKE ?";
			$book_lend_statement = $connection->prepare($book_lend_sql);
			$like = "%".$member->get_user()->get_username()."%";
			$book_lend_statement->bind_param("s",$like);
			$book_lend_statement->execute();
			$count_result = $book_lend_statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];
		}

		public function get_in_range_with_user($user, $from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend INNER JOIN member ON book_lend.id_member = member.id_member WHERE member.id_user = ? AND book_lend.approved = 1 LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$id_user = $user->get_id_user();
			$statement->bind_param("iii",$id_user, $from, $limit);
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}

		public function get_by_name_in_range_with_user($user, $name,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend  INNER JOIN book_copy ON book_lend.id_book_copy = book_copy.id_book_copy INNER JOIN book ON book_copy.id_book = book.id_book INNER JOIN member ON book_lend.id_member = member.id_member INNER JOIN user ON user.id_user = member.id_user WHERE user.id_user = ? AND book_lend.approved = 1 AND (book.book_title LIKE ?) LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$name."%";
			$id_user = $user->get_id_user();
			$statement->bind_param("isii",$id_user, $like, $from, $limit);
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function count_by_name_with_user($user, $name){
			$connection = $this->get_connection();
			$book_lend_sql = "SELECT COUNT(*) FROM book_lend INNER JOIN book_copy ON book_lend.id_book_copy = book_copy.id_book_copy INNER JOIN book ON book_copy.id_book = book.id_book INNER JOIN member ON book_lend.id_member = member.id_member INNER JOIN user ON user.id_user = member.id_user WHERE user.id_user = ? AND book_lend.approved = 1 AND (book.book_title LIKE ? )";
			$book_lend_statement = $connection->prepare($book_lend_sql);
			$like = "%".$name."%";
			$id_user = $user->get_id_user();
			$book_lend_statement->bind_param("is", $id_user, $like);
			$book_lend_statement->execute();
			$count_result = $book_lend_statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];
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
						      $row["approved"], $book_copy, $member);
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
							      $row["approved"], $book_copy, $member);
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
							      $row["approved"], $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}

		public function get_approved(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend WHERE approved = 1";
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
							      $row["approved"], $book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}

		public function get_not_approved(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM book_lend WHERE approved = 0";
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
							      $row["approved"], $book_copy, $member);
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
							      $row["approved"],$book_copy, $member);
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
							      $row["approved"],$book_copy, $member);
					$lend->set_id_lend($row["id_lend"]);
					array_push($lends,$lend);
				}
			}
			return $lends;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_book_copy($object->get_book_copy());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO book_lend (lend_date, return_date, approved,
							       id_book_copy,id_member)
							       VALUES (?,?,?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$lend_date = $object->get_lend_date();
				$return_date = $object->get_return_date();
				$approved = $object->get_approved();
				$id_book_copy = $object->get_book_copy()->get_id_book_copy();
				$id_member = $object->get_member()->get_id_member();
				
				$statement->bind_param("ssiii",$lend_date, $return_date, $approved,
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
			
			$db_object = $this->get_by_id($old_object->get_id_lend());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE book_lend SET lend_date = ?, return_date = ?, approved = ?, 
							     id_book_copy = ?, id_member = ?
							     WHERE id_lend = ?";
				$statement = $connection->prepare($sql);				
				$lend_date = $new_object->get_lend_date();
				$return_date = $new_object->get_return_date();
				$approved = $new_object->get_approved();
				$id_book_copy = $new_object->get_book_copy()->get_id_book_copy();
				$id_member = $new_object->get_member()->get_id_member();
				$id_lend = $db_object->get_id_lend();
				$statement->bind_param("ssiiii",$lend_date, $return_date, $approved,
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
				
				$id = $db_object->get_id_lend();
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
