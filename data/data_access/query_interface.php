<?php

	interface query_interface{
		
		public function get_all();
		public function get_by_id($id);
		public function insert($object);
		public function update($old_object, $new_object);
		public function delete($object);
		
	}
	
?>