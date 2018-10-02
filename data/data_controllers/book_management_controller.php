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
				$bookDao = new bookDAO();
				
				if(!isset($_POST["id-book"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$book = $bookDao->get_by_id($_POST["id"]);
						$message = 'Book deletion was successfull!';
						if(!$bookDao->delete($book)){
							$message = 'Book deletion was not successfull!';
						}
					}
					else{
						$categoryDao = new categoryDAO();
						$category = $categoryDao->get_by_id($_POST["id-category"]);
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
					}
				}
				
				else{
					$authorDao = new authorDAO();
					$genreDao = new genreDAO();

					$old_book = $bookDao->get_by_id($_POST["id-book"]);
					$new_book = $old_book;
					if(!empty($_POST["book-title-input"])){
						$new_book->set_book_title($_POST["book-title-input"]);					
					}
					if(!empty($_POST["original-book-title-input"])){
						$new_book->set_original_book_title($_POST["original-book-title-input"]);					
					}
					$new_book->set_authors(array());
					$authors_size = $_POST['author-size'];
					$genres_size = $_POST['genre-size'];
					
					for($i = 1; $i <= $authors_size; $i++){
						$author = $authorDao->get_by_id($_POST['author'.$i]);
						$new_book->add_author($author);				
					}
					
					$new_book->set_genres(array());
					for($i = 1; $i <= $genres_size; $i++){
						$genre = $genreDao->get_by_id($_POST['genre'.$i]);
						$new_book->add_genre($genre);				
					}
					
					$categoryDao = new categoryDAO();
					$category = $categoryDao->get_by_id($_POST["id-category"]);
					$new_book->set_category($category);

					$message = 'Book update was successfull!';
					if(!$bookDao->update($old_book,$new_book)){
						$message = 'Book update was not successfull!';
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
