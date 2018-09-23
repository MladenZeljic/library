<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for admin-manager-profile.php page
	class user_profile_controller extends basic_controller {
		
		public function do_post_action(){
			$helper = new helpers();			
			
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				if(isset($_POST["save"])){
					$userDao = new userDAO();
					$user = $userDao->get_by_username($_SESSION["username"]);
							
					if($_POST["save"] == "save-user"){
						$new_user = $user;
						if(!empty($_POST["firstname-input"])){
							$new_user->set_firstname($_POST["firstname-input"]);
						}
						if(!empty($_POST["lastname-input"])){
							$new_user->set_lastname($_POST["lastname-input"]);
						}
						if(!empty($_POST["password-input"])){
							$new_user->set_password($_POST["password-input"]);
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
					else{
						if($_POST["save"] == "save-member"){
							$memberDao = new memberDAO();
							$member = $memberDao->get_by_user($user);
							$new_member = $member;
											
							if(!empty($_POST["phone-input"])){
								$new_member->set_member_phone($_POST["phone-input"]);
							}
							
							if(!empty($_POST["mobile-input"])){
								$new_member->set_member_mobile($_POST["mobile-input"]);
							}
							
							if(!empty($_POST["address-select"])){
								$id_address = $_POST["address-select"];
								$addressDao = new addressDAO();
								$address = $addressDao->get_by_id($id_address);
								$new_member->set_member_address($address);			
							}
							
							if(!empty($_POST["notes-input"])){
								$new_member->set_notes($_POST["notes-input"]);
							}
							
							$message = "Member has been updated!";
							if(!$memberDao->update($member, $new_member)){
								$message = "Member has not been updated!";
							}
							echo '<script>alert("'.$message.'");</script>';
							
			
						}
					}
				}
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
