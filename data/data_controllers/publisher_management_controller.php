<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/addressDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for publisher-management.php page
	class publisher_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$addressDao = new addressDAO();
				$publisherDao = new publisherDAO();
						
				if(!isset($_POST["id-publisher"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$publisher = $publisherDao->get_by_id($_POST["id"]);
						
						$message = 'Publisher deletion was successfull!';
						if(!$publisherDao->delete($publisher)){
							$message = 'Publisher deletion was not successfull!';
						}
					}
					else{
						$address = $addressDao->get_by_id($_POST["id-address"]);

						$publisher = new publisher($_POST['publisher-name-input'],$address);
						$publisherDao = new publisherDAO();
						
						$message = 'Publisher insertion was successfull!';
						if(!$publisherDao->insert($publisher)){
							$message = 'Publisher insertion was not successfull!';
						}
					}
				}
				
				else{
					$old_publisher = $publisherDao->get_by_id($_POST["id-publisher"]);
					$new_publisher = $old_publisher;
	
					$address = $addressDao->get_by_id($_POST["id-address"]);

					$new_publisher->set_publisher_address($address);	
					if(!empty($_POST['publisher-name-input'])){
						$new_publisher->set_publisher_name($_POST['publisher-name-input']);
					}
					$message = 'Publisher update was successfull!';
					if(!$publisherDao->update($old_publisher,$new_publisher)){
						$message = 'Publisher update was not successfull!';
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
