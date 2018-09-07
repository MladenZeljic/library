<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	require_once '../../data/data_access/addressDAO.php';
	require_once '../../data/data_access/userDAO.php';
	require_once '../../data/data_models/membership.php';
	require_once '../../data/data_models/user.php';
	
	class memberDAO extends connection implements query_interface{
		
		public function get_all(){
			
			$connection = $this->get_connection();
			$sql = "SELECT * FROM member";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$results = $statement->get_result();
			 
			$memberships = array();
			
			if ($results->num_rows > 0) {
				while($row = $results->fetch_assoc()) {
					$addressDao = new addressDAO();
					$userDao = new userDAO();
	
					$address = $addressDao->get_by_id($row["id_address"]);
					$user = $userDao->get_by_id($row["id_user"]);
					$membership = new member($row["member_phone"],$row["member_mobile"],$row["member_from"],
								     $row["member_to"],$row["penality_points"],
								     $row["notes"], $address, $user);
					$membership->set_id_member($row["id_member"]);
					array_push($memberships,$membership);
				}
			}
			return $memberships;
		}
		
		public function get_by_id($id){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM member WHERE id_member = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("i",$id);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$addressDao = new addressDAO();
					$userDao = new userDAO();
	
				$address = $addressDao->get_by_id($row["id_address"]);
				$user = $userDao->get_by_id($row["id_user"]);
				$membership = new member($row["member_phone"],$row["member_mobile"],$row["member_from"],
							     $row["member_to"],$row["penality_points"],
							     $row["notes"], $address, $user);
				$membership->set_id_member($row["id_member"]);
				return $membership;
			}
			return null;
		}
		
		public function get_by_username($username){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM member INNER JOIN user ON member.id_user = user.id_user WHERE user.username = ? ";
			$statement = $connection->prepare($sql);
			$statement->bind_param("s",$username);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$user = new user($row["firstname"],$row["lastname"],$row["date_of_birth"],$row["username"],
								 $row["e_mail"],$row["password"],$row["approval"],$row["admin"],$row["status"]);
				$user->set_id_user($row["id_user"]);
				$addressDao = new addressDAO();
				
				$address = $addressDao->get_by_id($row["id_address"]);
				$membership = new member($row["member_phone"],$row["member_mobile"],$row["member_from"],
							     $row["member_to"],$row["penality_points"],
							     $row["notes"], $address, $user);
				$membership->set_id_member($row["id_member"]);
				return $membership;
			}
			return null;
		}
		
		public function get_by_user($user){
			
			return $this->get_by_username($user->get_username());
		}
		
		public function insert($object){
			
			$userDao = new userDAO();
			$db_object_user = $userDao->get_by_id($object->get_user()->get_id_user());
			
			$db_object_membership = $this->get_by_user($db_object_user);
			
			if(!$db_object_membership){
				$connection = $this->get_connection();
				
				$sql = "INSERT INTO member (member_phone, member_mobile, member_from, member_to, 
								penality_points, notes, id_address,id_user)
								VALUES (?,?,?,?,?,?,?,?)";
				$statement = $connection->prepare($sql);
				
				//bind_param accepts only variables
				$member_phone = $object->get_member_phone();
				$member_mobile = $object->get_member_mobile();
				$member_from = $object->get_member_from();
				$member_to = $object->get_member_to();
				$penality_points = $object->get_penality_points();
				$notes = $object->get_notes();				
				$id_address = $object->get_member_address()->get_id_address();
				$id_user = $object->get_user()->get_id_user();
				
				$statement->bind_param("ssssisii",$member_phone, $member_mobile, $member_from, $member_to,
								  $penality_points, $notes, $id_address, $id_user);
			
				return $statement->execute();
			}
			return false;			
		}
		
		public function update($old_object, $new_object){
			
			$userDao = new userDAO();
			$db_object_user = $userDao->get_by_id($old_object->get_user()->get_id_user());
			
			$db_object_membership = $this->get_by_user($db_object_user);
			
			if($db_object_membership){
				$connection = $this->get_connection();
				
				$sql = "UPDATE member SET member_phone = ?, member_mobile = ?, member_from = ?, member_to = ?, 
							      penality_points = ?, notes = ?, id_address = ?, id_user = ?
							      WHERE id_member = ?";
				$statement = $connection->prepare($sql);
				
				$member_phone = $new_object->get_member_phone();
				$member_mobile = $new_object->get_member_mobile();
				$member_from = $new_object->get_member_from();
				$member_to = $new_object->get_member_to();
				$penality_points = $new_object->get_penality_points();
				$notes = $new_object->get_notes();
				$id_address = $new_object->get_member_address()->get_id_address();
				$id_user = $new_object->get_user()->get_id_user();
				$id_member = $db_object_membership->get_id_member();
				
				$statement->bind_param("ssssisiii",$member_phone, $member_mobile, $member_from, $member_to, 
								   $penality_points, $notes, $id_address, $id_user, $id_member);
												   
				return $statement->execute();
			}
			return false;	
		}
		
		public function delete($object){
			$userDao = new userDAO();
			$db_object_user = $userDao->get_by_id($object->get_user()->get_id_user());
			
			$db_object_membership = $this->get_by_user($db_object_user);
			
			if($db_object_membership){
				$connection = $this->get_connection();
				
				$sql = "DELETE FROM member WHERE id_member = ?";
				$statement = $connection->prepare($sql);
				
				$id = $db_object_membership->get_user()->get_id_user();
				$statement->bind_param("i",$id);
				
				return $statement->execute();
			}
			return false;
		}
	
	}
	
?>
