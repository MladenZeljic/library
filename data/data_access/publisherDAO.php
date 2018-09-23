<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_models/publisher.php';
	require_once __DIR__.'/../../data/data_models/address.php';

	class publisherDAO extends connection implements query_interface{
		
		public function get_all(){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM publisher INNER JOIN address ON publisher.id_address = address.id_address";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$publishers = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					$publisher = new publisher($row["publisher_name"],$address);
					$publisher->set_id_publisher($row["id_publisher"]);
					array_push($publishers,$publisher);
				}
			}
			return $publishers;
		}

		public function get_in_range($from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM publisher INNER JOIN address ON publisher.id_address = address.id_address LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("ii",$from, $limit);
			$statement->execute();
			$results = $statement->get_result();
			 
			$publishers = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					$publisher = new publisher($row["publisher_name"],$address);
					$publisher->set_id_publisher($row["id_publisher"]);
					array_push($publishers,$publisher);
				}
			}
			return $publishers;
		}
		
		public function get_by_name_in_range($name,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM publisher INNER JOIN address ON publisher.id_address = address.id_address WHERE publisher_name LIKE ? LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$name."%";
			$statement->bind_param("sii",$like, $from, $limit);
			$statement->execute();
			$results = $statement->get_result();
			 
			$publishers = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					$publisher = new publisher($row["publisher_name"],$address);
					$publisher->set_id_publisher($row["id_publisher"]);
					array_push($publishers,$publisher);
				}
			}
			return $publishers;
		}
		
		public function count_by_name($name){
			$connection = $this->get_connection();
			$publisher_sql = "SELECT COUNT(*) FROM publisher INNER JOIN address ON publisher.id_address = address.id_address  WHERE publisher_name LIKE ?";
			$publisher_statement = $connection->prepare($publisher_sql);
			$like = "%".$name."%";
			$publisher_statement->bind_param("s",$like);
			$publisher_statement->execute();
			$count_result = $publisher_statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];	
		}
		
		public function get_by_id($id){
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM publisher INNER JOIN address ON publisher.id_address = address.id_address WHERE id_publisher = ?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
				$address->set_id_address($row["id_address"]);
				$publisher = new publisher($row["publisher_name"],$address);
				$publisher->set_id_publisher($row["id_publisher"]);
				return $publisher;
			}
			return null;
		
		}
		
		public function insert($object){
			$db_object = $this->get_by_id($object->get_id_publisher());
			echo (!$db_object);
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO publisher (publisher_name, id_address)
					VALUES (?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$publisher_name = $object->get_publisher_name();
				$id_address = $object->get_publisher_address()->get_id_address();
				
				$statement->bind_param("si",$publisher_name,$id_address);
				return $statement->execute();
			}
			return false;
			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_id($old_object->get_id_publisher());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE publisher SET publisher_name = ?, id_address = ? WHERE id_publisher = ?";
				$statement = $connection->prepare($sql);
				
				$publisher_name = $new_object->get_publisher_name();
				$id_address = $new_object->get_publisher_address()->get_id_address();
				$id_publisher = $db_object->get_id_publisher();

				$statement->bind_param("sii",$publisher_name,$id_address,$id_publisher);
												   
				return $statement->execute();
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_publisher());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM publisher WHERE id_publisher = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_publisher();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
