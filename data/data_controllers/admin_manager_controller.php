<?php
	require_once __DIR__.'/basic_controller_interface.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for admin-manager-profile.php page
	class admin_manager_controller implements basic_controller_interface {
		public function do_action(){

			$helper = new helpers();			
			session_start();
			//redirect user back to login if session variable username is not set
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$userDao = new userDAO();
				$user = $userDao->get_by_username($_SESSION["username"]);
				$new_user = $user;
				//if user clicked on save button
				if(isset($_POST["save"])){
					if(!empty($_POST["firstname-input"])){
						$new_user->set_firstname($_POST["firstname-input"]);
					}
					if(!empty($_POST["lastname-input"])){
						$new_user->set_lastname($_POST["lastname-input"]);
					}
					if(!empty($_POST["password-input"])){
						$new_user->set_password($_POST["password-input"]);
					}
					if(!empty($_POST["email-input"])){
						$new_user->set_e_mail($_POST["email-input"]);
					}
					if(!empty($_POST["date-of-birth-input"])){
						$new_user->set_date_of_birth($_POST["date-of-birth-input"]);
					}
					
					$message = "User has been updated!";
					if(!$userDao->update($user,$new_user)){
						$message = "User has not been updated!";
					}
					echo '<script>alert("'.$message.'");</script>';
				}
				if(isset($_POST["logout"])){
					session_destroy();
					$helper->redirect("http://localhost/project/");
				}
			}
		}
	}

?>
