<?php
	require_once __DIR__.'/../data_helpers/helpers.php';
	require_once __DIR__.'/basic_controller.php';
	include_once __DIR__.'/../data_access/memberDAO.php';
	include_once __DIR__.'/../data_access/roleDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	
	//custom controller class for index.php page
	class login_register_controller extends basic_controller{
	
		public function do_post_action(){
	
			$helper = new helpers();
			// if our user clicked on login
			if(isset($_POST["login"])){
			
				$username = $_POST["log-username-input"];
				$password = $_POST["log-password-input"];
				
				$userDao = new userDAO();
				$user = $userDao->get_by_username($username);
				//check if user exists in database, if his/hers password is correct if his/hers account is approved 
				//and not blocked
				if($user and password_verify($password,$user->get_password()) and $user->get_approval() === 1 and $user->get_status() === 1){
					//if the above is true, start session, set username session variable and redirect user 
					//to his/hers profile page
					session_start();
					$_SESSION["username"] = $username;
					
					//
					$helper->redirect("http://localhost/project/interface/pages/user-profile.php");	
				}
				else{
					//else redirect user back to login
					$message = "You have entered wrong username or password! Check if your caps lock is turned off or if you entered your username and password correctly!";
					echo '<script>alert("'.$message.'");</script>';
					//$helper->redirect("http://localhost/project/");
									
				}
				
			}
			else{
				//else user wants to register 
				if(isset($_POST["register"])){
					$message = "Registration was successfull! You'll need to wait until our administrators approve your account.";
					$firstname = $_POST["firstname-input"];
					$lastname = $_POST["lastname-input"];
					$username = $_POST["username-input"];
					$password = password_hash($_POST["password-input"], PASSWORD_DEFAULT);
					$email = $_POST["email-input"];
					$date_of_birth = $_POST["date-of-birth-input"];
					$roleDao = new roleDAO();
					$role = $roleDao->get_by_id(3);
					$user = new user($firstname, $lastname, $date_of_birth, $email, $username, $password, 0, 1, $role);
					$userDao = new userDAO();
					
					if($helper->username_taken($_POST["username-input"]) or $helper->email_taken($_POST["email-input"])){
						$message = "Username/E-mail is taken! Please try another one!";
						if($helper->username_taken($_POST["username-input"])){
							$_POST["username-input"] = "";
						}
						if($helper->email_taken($_POST["email-input"])){
							$_POST["email-input"] = "";
						}
					}
					else{
						//save user to database
						$userDao->insert($user);
					}
					echo '<script>alert("'.$message.'");</script>';
				}
				
			}
		}
		public function do_get_action(){
					
		}
	}

?>
