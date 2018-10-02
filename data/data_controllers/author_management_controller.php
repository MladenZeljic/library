<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/authorDAO.php';
	

	//custom controller class for author-management.php page
	class author_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();			
			//redirect user back to login if session variable username is not set
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$authorDao = new authorDAO();
				
				if(!isset($_POST["id-author"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$author = $authorDao->get_by_id($_POST["id"]);
						$message = 'Author deletion was successfull!';
						if(!$authorDao->delete($author)){
							$message = 'Author deletion was not successfull!';
						}
					}
					else{
						$author = new author($_POST['author-firstname-input'],$_POST['author-lastname-input'],$_POST['author-birth-date-input'],$_POST['author-biography-input']);
						$message = 'Author insertion was successfull!';
						if(!$authorDao->insert($author)){
							$message = 'Author insertion was not successfull!';
						}
				
					}
				}
				
				else{
					$old_author = $authorDao->get_by_id($_POST["id-author"]);
					$new_author = $old_author;
					if(!empty($_POST["author-firstname-input"])){
						$new_author->set_firstname($_POST["author-firstname-input"]);					
					}
					if(!empty($_POST["author-lastname-input"])){
						$new_author->set_lastname($_POST["author-lastname-input"]);					
					}
					if(!empty($_POST["author-date-of-birth-input"])){
						$new_author->set_date_of_birth($_POST["author-date-of-birth-input"]);					
					}
					$new_author->set_short_biography($_POST["author-biography-input"]);
					$message = 'Author update was successfull!';
					if(!$authorDao->update($old_author,$new_author)){
						$message = 'Author update was not successfull!';
					}				
				}
				echo "<span id='message'>{$message}</span>";
				
				//...
			}
		}
		public function do_get_action(){
			$helper = new helpers();			
			//redirect user back to login if session variable username is not set
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
