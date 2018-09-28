<?php

	require_once __DIR__.'/../../data/data_connect/connection.php';
	require_once __DIR__.'/../../data/data_access/query_interface.php';
	require_once __DIR__.'/../../data/data_access/roleDAO.php';
	require_once __DIR__.'/../../data/data_models/user.php';

	class userDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM user";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();			
			
			$users = array();
			$roleDao = new roleDAO();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$role = $roleDao->get_by_id($row["id_role"]);
					$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
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
			$roleDao = new roleDAO();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$role = $roleDao->get_by_id($row["id_role"]);
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"],$row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					
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
			$roleDao = new roleDAO();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$role = $roleDao->get_by_id($row["id_role"]);
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					
				$user->set_id_user($row["id_user"]);
				return $user;
			}
			return null;
		}
		
		public function get_by_e_mail($e_mail){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM user WHERE e_mail = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("s",$e_mail);
			$statement->execute();
			$result = $statement->get_result();
			$roleDao = new roleDAO();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$role = $roleDao->get_by_id($row["id_role"]);
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					
				$user->set_id_user($row["id_user"]);
				return $user;
			}
			return null;
		}

		public function get_in_range($from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM user ORDER BY approval,status LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$statement->bind_param("ii", $from, $limit);
			$statement->execute();
			$results = $statement->get_result();			
			
			$users = array();
			$roleDao = new roleDAO();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$role = $roleDao->get_by_id($row["id_role"]);
					$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					$user->set_id_user($row["id_user"]);
					array_push($users,$user);
				}
			}
			return $users;
		}
		
		public function get_by_param_in_range($param ,$from, $limit){
			$connection = $this->get_connection();
			$sql = "SELECT * FROM user WHERE user.firstname LIKE ? OR user.lastname LIKE ? OR user.username LIKE ? OR user.e_mail LIKE ? ORDER BY approval,status LIMIT ?,?";
			$statement = $connection->prepare($sql);
			$like = "%".$param."%";			
			$statement->bind_param("ssssii", $like, $like, $like, $like, $from, $limit);
			$statement->execute();
			$results = $statement->get_result();			
			
			$users = array();
			$roleDao = new roleDAO();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$role = $roleDao->get_by_id($row["id_role"]);
					$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					$user->set_id_user($row["id_user"]);
					array_push($users,$user);
				}
			}
			return $users;
		}

		public function get_non_members(){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM user WHERE user.id_role <> 1 AND user.id_role <> 2 AND user.approval = 1 AND user.status = 1 AND user.id_user NOT IN (SELECT id_user FROM member)";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();			
			
			$users = array();
			$roleDao = new roleDAO();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$role = $roleDao->get_by_id($row["id_role"]);
					$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"], $row["e_mail"],
					$row["username"],$row["password"],$row["approval"],$row["status"],$role);
					$user->set_id_user($row["id_user"]);
					array_push($users,$user);
				}
			}
			return $users;
		}
				
		public function count_by_param($param){
			$connection = $this->get_connection();
			$sql = "SELECT COUNT(*) FROM user WHERE user.firstname LIKE ? OR user.lastname LIKE ? OR user.username LIKE ? OR user.e_mail LIKE ?";
			$statement = $connection->prepare($sql);
			$like = "%".$param."%";
			$statement->bind_param("ssss", $like, $like, $like, $like);			
			$statement->execute();
			$count_result = $statement->get_result();
			$count_row = $count_result->fetch_assoc();
			return $count_row['COUNT(*)'];	
		
		}
		
		public function insert($object){
			
			$db_object = $this->get_by_username($object->get_username());
			
			if(!$db_object){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO user (firstname, lastname, date_of_birth, e_mail, 
					username, password, approval, status, id_role)
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
				$status = $object->get_status();
				$id_role = $object->get_role()->get_id_role();
				
				$statement->bind_param("ssssssiii",$firstname,$lastname,$date_of_birth,
								   $email,$username,$password,$approval,$status,$id_role);
			
				return $statement->execute();
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			$db_object = $this->get_by_username($old_object->get_username());
			
			if($db_object){
				$connection = $this->get_connection();
				
				$sql = "UPDATE user SET firstname = ?, lastname = ?, date_of_birth = ?, e_mail = ?,
					username = ?, password = ?, approval = ?, status = ?, id_role = ? WHERE id_user = ?";
				$statement = $connection->prepare($sql);
				
				$firstname = $new_object->get_firstname();
				$lastname = $new_object->get_lastname();
				$date_of_birth = $new_object->get_date_of_birth();
				$email = $new_object->get_e_mail();				
				$username = $new_object->get_username();
				$password = $new_object->get_password();
				$approval = $new_object->get_approval();
				$status = $new_object->get_status();
				$id_role = $new_object->get_role()->get_id_role();
				$id = $db_object->get_id_user();
				
				$statement->bind_param("ssssssiiii",$firstname,$lastname,$date_of_birth,
								    $email,$username,$password,$approval,$status,$id_role,$id);
												   
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
