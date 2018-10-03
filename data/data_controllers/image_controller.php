<?php
	require_once __DIR__.'/basic_controller.php';
	require_once __DIR__.'/../data_helpers/helpers.php';
	include_once __DIR__.'/../data_access/userDAO.php';
	

	//custom controller class for admin-manager-profile.php page
	class image_controller extends basic_controller {
	
		public function do_post_action(){
			echo $_FILES["image"]["tmp_name"];
		}
		
		public function do_get_action(){
		}
	
	}
?>
