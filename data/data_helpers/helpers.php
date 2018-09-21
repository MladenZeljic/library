<?php
	include_once __DIR__.'/../data_access/memberDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';

	class helpers{
		
		public function redirect($url){
			header("Location: ".$url, true, 301);
			exit();
		}
		public function print_request_value($request_index,$method){
			$ret_val = "";
			if(strtolower($method) === "get"){
				if(isset($_GET[$request_index])){		
					$ret_val = $_GET[$request_index]; 
				}
			}
			else{
				if(strtolower($method) === "post"){
					if(isset($_POST[$request_index])){		
						$ret_val = $_POST[$request_index];
					}	
				}
			}
			return $ret_val;
		}
		public function is_member($username){
			$userDao = new userDAO();
			$user = $userDao->get_by_username($username);
			$memberDao = new memberDAO();
			$member = $memberDao->get_by_user($user);
			return $member ? true : false;
		}
		public function username_taken($username){
			$userDao = new userDAO();
			$user = $userDao->get_by_username($username);
			return $user ? true : false;
		}
		public function email_taken($email){
			$userDao = new userDAO();
			$user = $userDao->get_by_e_mail($email);
			return $user ? true : false;
		}
		public function empty_manage($value){
			return empty($value) ? "-" : $value;
			
			
		}
	}
?>
