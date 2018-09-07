<?php

	require_once '../../data/data_connect/connection.php';
	require_once '../../data/data_access/query_interface.php';
	
	class book_genreDAO extends connection {
		
		public function book_genre_exists($id_book, $id_genre){
			
			$connection = $this->get_connection();
			
			$sql = "SELECT * FROM book_genre WHERE id_book = ? AND id_genre = ? ";
			$statement = $connection->prepare($sql);
			
			$statement->bind_param("ii", $id_book, $id_genre);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows == 1) {
				return true;
			}
			return false;
		}
	
	}
	
?>
