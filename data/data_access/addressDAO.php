<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_models/address.php';
	
	class addressDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM address";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$addresses = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					array_push($addresses,$address);
				}
			}
			return $addresses;
		}
		
		public function get_in_range($from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM address LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("ii", $from, $limit);
			$statement->execute();
			$results = $statement->get_result();
			 
			$addresses = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					array_push($addresses,$address);
				}
			}
			return $addresses;
		}
		
		public function get_by_param_in_range($param ,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM address WHERE street_name LIKE ? OR city LIKE ? LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$param."%";
			$statement->bind_param("ssii", $like, $like, $from, $limit);			
			$statement->execute();
			$results = $statement->get_result();
			 
			$addresses = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
					$address->set_id_address($row["id_address"]);
					array_push($addresses,$address);
				}
			}
			return $addresses;
		}
		
		public function count_by_param($param){
			
			$connection = $this->get_connection();
			$sql = "SELECT COUNT (*) FROM address WHERE street_name LIKE ? OR city LIKE ?";
			$statement = $connection->prepare($sql);
			$like = "%".$param."%";
			$statement->bind_param("ss", $like, $like);			
			$statement->execute();
			$count_result = $statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];	
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM address WHERE id_address = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
				$address->set_id_address($row["id_address"]);
				return $address;
			}
			return null;
		}
		
		public function get_by_zip_code($zip_code){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM address WHERE zip_code = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$zip_code);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$address = new address($row["zip_code"],$row["street_address"],$row["city"]);
				$address->set_id_address($row["id_address"]);
				return $address;
			}
			return null;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_zip_code($object->get_zip_code());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO address (zip_code, street_address, city)
					VALUES (?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$zip_code = $object->get_zip_code();
				$street_address = $object->get_street_address();
				$city = $object->get_city();
				
				$statement->bind_param("iss",$zip_code,$street_address,$city);
			
				return $statement->execute();
			}
			return false;
			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_zip_code($old_object->get_zip_code());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE address SET zip_code = ?, street_address = ?, city = ? WHERE id_address = ?";
				$statement = $connection->prepare($sql);
				
				$zip_code = $new_object->get_zip_code();
				$street_address = $new_object->get_street_address();
				$city = $new_object->get_city();
				$id_address = $db_object->get_id_address();

				$statement->bind_param("issi",$zip_code,$street_address,$city,$id_address);
												   
				return $statement->execute();
			}
			return false;
			
		}
		
		public function delete($object){
			$db_object = $this->get_by_zip_code($object->get_zip_code());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM address WHERE id_address = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_address();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
			
		}
	
	}
	
?>
