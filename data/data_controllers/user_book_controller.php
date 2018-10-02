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
				if(!isset($_POST["id-lend"])){
					$copy = $copyDao->get_by_id($_POST["id-copy"]);
					$max_books_per_member = 2;
					$memberDao = new memberDAO();
					$member = $memberDao->get_by_username($_SESSION["username"]);
					
					$lend = new book_lend(date('Y-m-d'),date('Y-m-d', strtotime('+14 day')), 0, $copy, $member);
					$lendDao = new book_lendDAO();
					$member_book_copies_count = $lendDao->count_by_member($member);
					if($member_book_copies_count >= $max_books_per_member){
						$message = "You are not allowed to lend more than {$max_books_per_member} books! Please return the ones that you already have, and then lend another one!";
					}
					else{
						$message = 'You have successfully lended your book. Please wait until our administrators approve it!';
						if(!$lendDao->insert($lend)){
							$message = 'You have not successfully lended your book!';
						}
					}
				}
				else{
					$days_per_point = 3;
					$return_date = new DateTime($_POST["return-date"]);
					$today = new DateTime();
					$days = $return_date->diff($today)->format('%a');
					$points = 0;
					if($today > $return_date && $days > 0){
						$points = floor($days/$days_per_point);
					}
					
					$memberDao = new memberDAO();
					$old_member = $memberDao->get_by_username($_SESSION["username"]);
					$penality = $old_member->get_penality_points();
					$penality +=$points;
					$new_member = $old_member;
					$new_member->set_penality_points($penality);
					$lendDao = new book_lendDAO();
					$lend = $lendDao->get_by_id($_POST["id-lend"]);
					
					$member_update = $memberDao->update($old_member,$new_member);
					$lend_delete = $lendDao->delete($lend);
					$message = "Book is returned successfully!";
					if(!$lend_delete && !$member_update){
						$message = "Book is not returned successfully!";
					}
					else{
						if($points > 0){
							$message = $message." You have recieved some penality points. Please return your book on time next time!";
						}
						else{
							$message = $message." Thank you for returning your book!";
						}
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
