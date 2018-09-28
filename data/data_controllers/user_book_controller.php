<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/book_lendDAO.php';
	include_once __DIR__.'/../data_access/memberDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for user-book.php page
	class user_book_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$copyDao = new book_copyDAO();
				$copy = $copyDao->get_by_id($_POST["id-copy"]);
				
				$memberDao = new memberDAO();
				$member = $memberDao->get_by_username($_SESSION["username"]);
				
				$lend = new book_lend(date('Y-m-d'),date('Y-m-d', strtotime('+14 day')), 0, $copy, $member);
				$lendDao = new book_lendDAO();
				
				$message = 'Lend insertion was successfull!';
				if(!$lendDao->insert($lend)){
					$message = 'Lend insertion was not successfull!';
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
