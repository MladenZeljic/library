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
		public function get_approval_text($approval){
			return $approval ? "approved" : "not approved";
			
		}
		public function get_status_text($status){
			return $status ? "active" : "deactivated";
			
		}
		public function get_available_text($available){
			return $available ? "available" : "not available";
			
		}
		public function print_active_tab_class($element_deactivated = false){
			if(!$element_deactivated){			
				if(!isset($_GET["page"]) and !isset($_GET["search"])){
					echo "active-tab";
				}
			}
			else{
				if(isset($_GET["page"])){
					echo "active-tab";
				}
				else{
					if(isset($_GET["search"])){
						echo "active-tab";
					}
				}
			}
		}
		public function print_hide_view_class($element_hidden = false){
			if($element_hidden){
				if(!isset($_GET["page"]) and !isset($_GET["search"])){ 
					echo "tab-view-hide";
				}
			}
			else{
				if(isset($_GET["page"])){ 
					echo "tab-view-hide";
				}
				else{
					if(isset($_GET["search"])){
						echo "tab-view-hide";
					}
				}
			}
		}
	}
?>
