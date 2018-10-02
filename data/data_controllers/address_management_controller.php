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
				
				if(!isset($_POST["id-address"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$address = $addressDao->get_by_id($_POST["id"]);
						$message = 'Address deletion was successfull!';
						if(!$addressDao->delete($address)){
							$message = 'Address deletion was not successfull!';
						}
					}
					else{
						$address = new address($_POST['zip-input'], $_POST['street-input'], $_POST['city-input']);
						$message = 'Address insertion was successfull!';
						if(!$addressDao->insert($address)){
							$message = 'Address insertion was not successfull!';
						}
					}
				}
				
				else{
					$old_address = $addressDao->get_by_id($_POST["id-address"]);
					$new_address = $old_address;
					if(!empty($_POST['zip-input'])){
						$new_address->set_zip_code($_POST["zip-input"]);
					}
					if(!empty($_POST['street-input'])){
						$new_address->set_street_address($_POST["street-input"]);
					}
					if(!empty($_POST['city-input'])){
						$new_address->set_city($_POST["city-input"]);
					}
					$message = 'Address update was successfull!';
					if(!$addressDao->update($old_address,$new_address)){
						$message = 'Address update was not successfull!';
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
