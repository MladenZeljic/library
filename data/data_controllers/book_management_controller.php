<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/authorDAO.php';
	include_once __DIR__.'/../data_access/bookDAO.php';
	include_once __DIR__.'/../data_access/categoryDAO.php';	
	include_once __DIR__.'/../data_access/genreDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for book-management.php page
	class book_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$categoryDao = new categoryDAO();
				$category = $categoryDao->get_by_id($_POST["id-category"]);
				$bookDao = new bookDAO();
				$authorDao = new authorDAO();
				$genreDao = new genreDAO();

				$book = new book($_POST['book-title-input'],$_POST['original-book-title-input'],$category);
				$authors_size = $_POST['author-size'];
				$genres_size = $_POST['genre-size'];
				
				for($i = 1; $i <= $authors_size; $i++){
					$author = $authorDao->get_by_id($_POST['author'.$i]);
					$book->add_author($author);				
				}
				
				for($i = 1; $i <= $genres_size; $i++){
					$genre = $genreDao->get_by_id($_POST['genre'.$i]);
					$book->add_genre($genre);				
				}

				$message = 'Book insertion was successfull!';
				if(!$bookDao->insert($book)){
					$message = 'Book insertion was not successfull!';
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
