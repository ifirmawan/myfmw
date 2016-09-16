<?php

/**
* Load library class
*/
class Mysql{
	
	protected $db;

	function __construct() {
		$this->setup();
	}

	protected function setup($config=array())
	{
		$host 		= $GLOBALS['config']['host'];
		$user		= $GLOBALS['config']['user'];
		$password 	= $GLOBALS['config']['password'];
		$db_name	= $GLOBALS['config']['db_name'];
		$options	= array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		$this->db 	= new PDO('mysql:host=$host;dbname=$db_name;charset=utf8', $user, $password, $options);
	}
	
}

?>