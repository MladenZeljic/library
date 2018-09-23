<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_models/category.php';
	
	class categoryDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM category";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$categories = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$category = new category($row["category_title"]);
					$category->set_id_category($row["id_category"]);
					array_push($categories,$category);
				}
			}
			return $categories;
		}
		
		public function get_in_range($from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM category LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("ii", $from, $limit);						
			$statement->execute();
			$results = $statement->get_result();
			 
			$categories = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$category = new category($row["category_title"]);
					$category->set_id_category($row["id_category"]);
					array_push($categories,$category);
				}
			}
			return $categories;
		}
		
		public function get_by_name_in_range($name ,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM category WHERE category_title LIKE ? LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$name."%";
			$statement->bind_param("sii", $like, $from, $limit);						
			$statement->execute();
			$results = $statement->get_result();
			 
			$categories = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$category = new category($row["category_title"]);
					$category->set_id_category($row["id_category"]);
					array_push($categories,$category);
				}
			}
			return $categories;
		}
		
		public function count_by_name($name){
			$connection = $this->get_connection();
			$sql = "SELECT COUNT(*) FROM category WHERE category_title LIKE ? ";
			$statement = $connection->prepare($sql);
			$like = "%".$name."%";
			$statement->bind_param("s",$like);			
			$statement->execute();
			$count_result = $statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];	
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM category WHERE id_category = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$category = new category($row["category_title"]);
				$category->set_id_category($row["id_category"]);
				return $category;
			}
			return null;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_id($object->get_id_category());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO category (category_title)
					VALUES (?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$category_title = $object->get_category_title();
				
				$statement->bind_param("s",$category_title);
			
				return $statement->execute();
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_id($old_object->get_id_category());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE category SET category_title = ? WHERE id_category = ?";
				$statement = $connection->prepare($sql);
				
				$category_title = $new_object->get_category_title();
				$id_category = $db_object->get_id_category();

				$statement->bind_param("si",$category_title,$id_category);
												   
				return $statement->execute();
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_category());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM category WHERE id_category = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_category();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
