<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/book_lendDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for book-lenfings-management.php page
	class book_lendings_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$lendDao = new book_lendDAO();
				if(!isset($_POST["id-lend"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$lend = $lendDao->get_by_id($_POST["id"]);
						$message = 'Lend deletion was successfull!';
						if(!$lendDao->delete($lend)){
							$message = 'Lend deletion was not successfull!';
						}
					}
				}
				
				else{
					$old_lend = $lendDao->get_by_id($_POST["id-lend"]);
					$new_lend = $old_lend;
					if($_POST["approved"] == "on"){
						$new_lend->set_approved(true);					
					}
					else{
						$new_lend->set_approved(false);
					}
					$message = 'Lend update was successfull!';
					if(!$lendDao->update($old_lend,$new_lend)){
						$message = 'Lend update was not successfull!';
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
