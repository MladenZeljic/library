<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_models/role.php';
	
	class roleDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM role";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$roles = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					
					$role = new role($row["role_title"]);
					$role->set_id_role($row["id_role"]);
					array_push($roles,$role);
				}
			}
			return $roles;
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM role WHERE id_role = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$role = new role($row["role_title"]);
				$role->set_id_role($row["id_role"]);
				return $role;
			}
			return null;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_id($object->get_id_role());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO role (role_title)
					VALUES (?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$role_title = $object->get_role_title();
				
				$statement->bind_param("s",$role_title);
			
				return $statement->execute();
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			
			$db_object = $this->get_by_id($old_object->get_id_role());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE role SET role_title = ? WHERE id_role = ?";
				$statement = $connection->prepare($sql);
				
				$role_title = $new_object->get_role_title();
				$id_role = $db_object->get_id_role();

				$statement->bind_param("si",$role_title,$id_role);
												   
				return $statement->execute();
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_id($object->get_id_role());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM role WHERE id_role = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_role();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
