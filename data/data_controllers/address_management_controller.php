<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/addressDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for address-management.php page
	class address_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$addressDao = new addressDAO();
				
				$address = new address($_POST['zip-input'], $_POST['street-input'], $_POST['city-input']);
				$message = 'Address insertion was successfull!';
				if(!$addressDao->insert($address)){
					$message = 'Address insertion was not successfull!';
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
