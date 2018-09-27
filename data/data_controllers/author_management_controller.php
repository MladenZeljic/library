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
				
				$author = new author($_POST['author-firstname-input'],$_POST['author-lastname-input'],$_POST['author-birth-date-input'],$_POST['author-biography-input']);
				$message = 'Author insertion was successfull!';
				if(!$authorDao->insert($author)){
					$message = 'Author insertion was not successfull!';
				}
				echo "<span id='message'>'{$message}'</span>";
				
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
