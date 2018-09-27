<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/genreDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for genre-management.php page
	class genre_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$genreDao = new genreDAO();
				
				$genre = new genre($_POST['genre-name-input']);
				$message = 'Genre insertion was successfull!';
				if(!$genreDao->insert($genre)){
					$message = 'Genre insertion was not successfull!';
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
