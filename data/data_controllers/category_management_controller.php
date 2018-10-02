<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/categoryDAO.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for category-management.php page
	class category_management_controller extends basic_controller {
		
		public function do_post_action(){

			$helper = new helpers();
			if(!isset($_SESSION["username"])){
				$helper->redirect("http://localhost/project/");
			}
			else{
				$categoryDao = new categoryDAO();
				
				if(!isset($_POST["id-category"])){
					if(isset($_POST["action"]) && $_POST["action"] == 'delete'){
						$category = $categoryDao->get_by_id($_POST["id"]);
						$message = 'Category deletion was successfull!';
						if(!$categoryDao->delete($category)){
							$message = 'Category deletion was not successfull!';
						}
					}
					else{
										
						$category = new category($_POST['category-name-input']);
						$message = 'Category insertion was successfull!';
						if(!$categoryDao->insert($category)){
							$message = 'Category insertion was not successfull!';
						}
					}
				}
				
				else{
					$old_category = $categoryDao->get_by_id($_POST["id-category"]);
					$new_category = $old_category;
					if(!empty($_POST['category-name-input'])){
						$new_category->set_category_title($_POST["category-name-input"]);
					}
					$message = 'Category update was successfull!';
					if(!$categoryDao->update($old_category,$new_category)){
						$message = 'Category update was not successfull!';
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
