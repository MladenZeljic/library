<?php
	class connection {
		protected $_connection;
		
		function __destruct() {
			if($this->_connection){
			$this->_connection->close();
			}
		}
		
		public function get_connection(){
			
			$this->_connection = mysqli_connect("localhost", "root", "", "library");
				
			if ($this->_connection->connect_error) {
				die("Connection failed: " . $$this->_connection->connect_error);
				return null;
			} 
			return $this->_connection;
		}
		
		public function get_connection_with_credentials($url, $username, $password, $db_name){
			
			$this->_connection = mysqli_connect($url, $username, $password, $db_name);
				
			if ($this->_connection->connect_error) {
				die("Connection failed: " . $$this->_connection->connect_error);
				return null;
			} 
			return $this->_connection;
		}
	
	}
	
?>
