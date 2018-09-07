<?php

class address{
	protected $_id_address;
	protected $_zip_code;
	protected $_street_address;
	protected $_city;

	public function __construct($zip_code, $street_address, $city){
		$this->_zip_code = $zip_code;
		$this->_street_address = $street_address;
		$this->_city = $city;
	}
	public function get_id_address(){
		return $this->_id_address;
	}
	public function set_id_address($id_address){
		$this->_id_address = $id_address;
	}
	public function get_zip_code(){
		return $this->_zip_code;
	}
	public function set_zip_code($zip_code){
		$this->_zip_code = $zip_code;
	}
	public function get_street_address(){
		return $this->_street_address;
	}
	public function set_street_address($city_address){
		$this->_street_address = $city_address;
	}
	public function get_city(){
		return $this->_city;
	}
	public function set_city($city){
		$this->_city = $city;
	}
}

?>
