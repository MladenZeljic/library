<?php
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/memberDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	
	//custom controller class for index.php page
	class index_controller{
	
		public function do_action(){
	
			$helper = new helpers();
			// if our user clicked on login
			if(isset($_POST["login"])){
			
				$username = $_POST["log-username-input"];
				$password = $_POST["log-password-input"];
					
				$userDao = new userDAO();
				$user = $userDao->get_by_username($username);
				//check if user exists in database, if his/hers password is correct if his/hers account is approved 
				//and not blocked
				if($user and $user->get_password() === $password and $user->get_approval()=== 1 and $user->get_status() === 1){
					//if the above is true, start session, set username session variable and redirect user 
					//to his/hers profile page
					session_start();
					$_SESSION["username"] = $username;
					$memberDao = new memberDAO();
					$member = $memberDao->get_by_user($user);
					//By default system admins and managers should not be members of library, meaning that they should not 
					//be able to lend any book. They still have the ability to add new members into our library, except 
					//for themselves
					if(!$member){
						$helper->redirect("http://localhost/project/interface/pages/admin-manager-profile.php");
					}
					else{
						$helper->redirect("http://localhost/project/interface/pages/common-user-profile.php");
					}	
				}
				else{
					//else redirect user back to login
					$helper->redirect("http://localhost/project/");
				}
				
			}
			else{
				//else user wants to register 
				if(isset($_POST["register"])){
					$firstname = $_POST["firstname-input"];
					$lastname = $_POST["lastname-input"];
					$username = $_POST["username-input"];
					$password = $_POST["password-input"];
					$email = $_POST["email-input"];
					$date_of_birth = $_POST["date-of-birth-input"];
					
					$user = new user($firstname, $lastname, $date_of_birth, $email, $username, $password, 0, 0, 1);
					$userDao = new userDAO();
					//save user to database
					$userDao->insert($user);
					
				}
			}
		}
	}

?>
