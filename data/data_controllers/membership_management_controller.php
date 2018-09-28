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
				$user = $userDao->get_by_id($_POST["id-user"]);
				$addressDao = new addressDAO();
				$address = $addressDao->get_by_id($_POST["id-address"]);

				$member = new member($_POST['member-phone-input'],$_POST['member-mobile-input'],date('Y-m-d'),date('Y-m-d', strtotime('+1 year')),0,$_POST['notes'],$address,$user);
				$memberDao = new memberDAO();
				
				$message = 'Member insertion was successfull!';
				if(!$memberDao->insert($member)){
					$message = 'Member insertion was not successfull!';
				}
				echo "<span id='message'>'{$message}'</span>";
				
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
