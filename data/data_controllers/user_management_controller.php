<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/roleDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for user-management.php page
	class user_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$userDao = new userDAO();
				
				if(!isset($_POST["id-user"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$user = $userDao->get_by_id($_POST["id"]);
						$message = 'User deletion was successfull!';
						if(!$userDao->delete($user)){
							$message = 'User deletion was not successfull!';
						}
					}
				}
				
				else{
					$old_user = $userDao->get_by_id($_POST["id-user"]);
					$new_user = $old_user;
					$roleDao = new roleDAO();
					$role = $roleDao->get_by_id($_POST["id-role"]);
					$new_user->set_role($role);
					$new_user->set_approval(true);
					if($_POST["approved"] == "off"){
						$new_user->set_approval(false);					
					}
					$new_user->set_status(true);					
					if($_POST["status"] == "off"){
						$new_user->set_status(false);					
					}
					$message = 'User update was successfull!';
					if(!$userDao->update($old_user,$new_user)){
						$message = 'User update was not successfull!';
					}				
				}
				echo "<span id='message'>{$message}</span>";
				//...
			}			
			
		}

		public function do_get_action(){
			$helper = new helpers();			
			
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				if(isset($_GET["logout"]) or isset($_GET["log-out"])){
					session_destroy();
					$helper->redirect("http://localhost/project/");
				}
			}
		}
	}

?>
