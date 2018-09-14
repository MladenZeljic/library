<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_models/user.php';

	class userDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM user";
			$results = $connection->query($sql);
			$users = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["admin"],$row["status"]);
					$user->set_id_user($row["id_user"]);
					array_push($users,$user);
				}
			}
			return $users;
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM user WHERE id_user = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["admin"],$row["status"]);
					
				$user->set_id_user($row["id_user"]);
				return $user;
			}
			return null;
		}
		
		public function get_by_username($username){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM user WHERE username = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("s",$username);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["admin"],$row["status"]);
					
				$user->set_id_user($row["id_user"]);
				return $user;
			}
			return null;
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_username($object->get_username());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO user (firstname, lastname, date_of_birth, e_mail, 
					username, password, approval, admin, status)
					VALUES (?,?,?,?,?,?,?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$firstname = $object->get_firstname();
				$lastname = $object->get_lastname();
				$date_of_birth = $object->get_date_of_birth();
				$email = $object->get_e_mail();				
				$username = $object->get_username();
				$password = $object->get_password();
				$approval = $object->get_approval();
				$admin = $object->get_admin();
				$status = $object->get_status();
				
				$statement->bind_param("ssssssiii",$firstname,$lastname,$date_of_birth,
								   $email,$username,$password,$approval,$admin,$status);
			
				return $statement->execute();
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			$db_object = $this->get_by_username($old_object->get_username());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE user SET firstname = ?, lastname = ?, date_of_birth = ?, e_mail = ?,
					username = ?, password = ?, approval = ?, admin = ?, status = ? WHERE id_user = ?";
				$statement = $connection->prepare($sql);
				
				$firstname = $new_object->get_firstname();
				$lastname = $new_object->get_lastname();
				$date_of_birth = $new_object->get_date_of_birth();
				$email = $new_object->get_e_mail();				
				$username = $new_object->get_username();
				$password = $new_object->get_password();
				$approval = $new_object->get_approval();
				$admin = $new_object->get_admin();
				$status = $new_object->get_status();
				$id = $db_object->get_id_user();
				
				$statement->bind_param("ssssssiiii",$firstname,$lastname,$date_of_birth,
								    $email,$username,$password,$approval,$admin,$status,$id);
												   
				return $statement->execute();
			}
			return false;
		}
		
		public function delete($object){
			$db_object = $this->get_by_username($object->get_username());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM user WHERE id_user = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object->get_id_user();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
