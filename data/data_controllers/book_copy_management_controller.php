<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/bookDAO.php';
	include_once __DIR__.'/../data_access/book_copyDAO.php';
	include_once __DIR__.'/../data_access/publisherDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for book-copy-management.php page
	class book_copy_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$bookDao = new bookDAO();
				$copyDao = new book_copyDAO();
				$publisherDao = new publisherDAO();
						
				if(!isset($_POST["id-copy"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$copy = $copyDao->get_by_id($_POST["id"]);
						$message = 'Book copy deletion was successfull!';
						if(!$copyDao->delete($copy)){
							$message = 'Book copy deletion was not successfull!';
						}
					}
					else{
						$book = $bookDao->get_by_id($_POST["id-book"]);
						$publisher = $publisherDao->get_by_id($_POST["id-publisher"]);

						$book_copy = new book_copy($_POST['year-of-publication-input'],$_POST['number-of-pages-input'],1,$book,$publisher);
						
						$message = 'Book copy insertion was successfull!';
						if(!$copyDao->insert($book_copy)){
							$message = 'Book copy insertion was not successfull!';
						}
					}
				}
				
				else{
					$old_copy = $copyDao->get_by_id($_POST["id-copy"]);
					$new_copy = $old_copy;
	
					$book = $bookDao->get_by_id($_POST["id-book"]);
					$publisher = $publisherDao->get_by_id($_POST["id-publisher"]);
					
					$new_copy->set_book($book);
					$new_copy->set_publisher($publisher);		
					if(!empty($_POST['year-of-publication-input'])){
						$new_copy->set_year_of_publication($_POST['year-of-publication-input']);					
					}
					if(!empty($_POST['number-of-pages-input'])){
						$new_copy->set_number_of_pages($_POST['number-of-pages-input']);					
					}
					$message = 'Book copy update was successfull!';
					if(!$copyDao->update($old_copy,$new_copy)){
						$message = 'Book copy update was not successfull!';
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
