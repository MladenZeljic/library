<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';	
	include_once __DIR__.'/../data_access/addressDAO.php';
	include_once __DIR__.'/../data_access/memberDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for membership-management.php page
	class membership_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$userDao = new userDAO();
				$memberDao = new memberDAO();
						
				if(!isset($_POST["id-member"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$member = $memberDao->get_by_id($_POST["id"]);
						
						$message = 'Member deletion was successfull!';
						if(!$memberDao->delete($member)){
							$message = 'Member deletion was not successfull!';
						}
					}
					else{
						$user = $userDao->get_by_id($_POST["id-user"]);
						$addressDao = new addressDAO();
						$address = $addressDao->get_by_id($_POST["id-address"]);

						$member = new member($_POST['member-phone-input'],$_POST['member-mobile-input'],date('Y-m-d'),date('Y-m-d', strtotime('+1 year')),0,$_POST['notes'],$address,$user);
				
						$message = 'Member insertion was successfull!';
						if(!$memberDao->insert($member)){
							$message = 'Member insertion was not successfull!';
						}

					}
				}
				
				else{
					$old_member = $memberDao->get_by_id($_POST["id-member"]);
					$new_member = $old_member;
	
					$addressDao = new addressDAO();
					$address = $addressDao->get_by_id($_POST["id-address"]);

					$new_member->set_member_address($address);	
					if(!empty($_POST['member-phone-input'])){
						$new_member->set_member_phone($_POST['member-phone-input']);
					}
					if(!empty($_POST['member-mobile-input'])){
						$new_member->set_member_mobile($_POST['member-mobile-input']);
					}
					if(!empty($_POST['member-to'])){
						$new_member->set_member_to($_POST['member-to']);
					}
					$new_member->set_notes($_POST['notes']);
					$message = 'Member update was successfull!';
					if(!$memberDao->update($old_member,$new_member)){
						$message = 'Member update was not successfull!';
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
