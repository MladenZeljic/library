<?php
	//root class for all controllers
	abstract class basic_controller{
		
		public function __construct(){
			session_start();
		}
		//determine request method and apply appropriate method
		public function do_action(){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->do_post_action();
			}
			else{ 
				if ($_SERVER['REQUEST_METHOD'] === 'GET') {
					$this->do_get_action();
				}
			}
		}

		abstract protected function do_get_action();
		abstract protected function do_post_action();
		
	}
	
?>
