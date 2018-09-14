<?php

class helpers{
	
	public function redirect($url){
		header("Location: ".$url, true, 301);
		exit();
	}
	public function print_request_value($request_index,$method){
		$ret_val = "";
		if(strtolower($method) === "get"){
			if(isset($_GET[$request_index])){		
				$ret_val = $_GET[$request_index]; 
			}
		}
		else{
			if(strtolower($method) === "post"){
				if(isset($_POST[$request_index])){		
					$ret_val = $_POST[$request_index];
				}	
			}
		}
		return $ret_val;
	}

}
?>
