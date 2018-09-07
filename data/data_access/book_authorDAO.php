<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	
	class book_authorDAO extends connection {
		
		public function book_author_exists($id_book, $id_author){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM book_author WHERE id_book = ? AND id_author = ? ";
			$statement = $connection->prepare($sql);
			
			$statement->bind_param("ii", $id_book, $id_author);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				return true;
			}
			return false;
		}	
	}
	
?>
