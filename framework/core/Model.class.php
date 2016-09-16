<?php

/**
* 
*/
class Model extends Mysql
{
	protected $table_name;

	function __construct() {
		$this->set_table_name();
	}

	public function set_table_name($table=''){
		$this->table_name = (empty($table))?  'barang' : $table;
	}	

	public function get($table_name){
		return $this->db->query("SELECT * FROM $table_name")->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>