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
				$book = $bookDao->get_by_id($_POST["id-book"]);
				$publisherDao = new publisherDAO();
				$publisher = $publisherDao->get_by_id($_POST["id-publisher"]);

				$book_copy = new book_copy($_POST['year-of-publication-input'],$_POST['number-of-pages-input'],1,$book,$publisher);
				$copyDao = new book_copyDAO();
				
				$message = 'Book copy insertion was successfull!';
				if(!$copyDao->insert($book_copy)){
					$message = 'Book copy insertion was not successfull!';
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
